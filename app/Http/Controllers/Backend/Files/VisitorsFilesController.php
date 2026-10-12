<?php

namespace App\Http\Controllers\Backend\Files;

use App\Http\Controllers\Controller;
use App\Models\FileEntry;
use Exception;
use Illuminate\Http\Request;
use Validator;

class VisitorsFilesController extends Controller
{
    public function index()
    {
        $fileEntries = FileEntry::forVisitors()->file();
        updateIsViewed($fileEntries->get(), true);
        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $fileEntries->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->orWhere('name', 'like', $searchTerm)
                    ->orWhere('filename', 'like', $searchTerm)
                    ->orWhere('ip', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm);
            });
        }
        if (request()->filled('shared_id')) {
            $fileEntries->where('id', unhashid(request('shared_id')));
        }
        $counters['total_files'] = $fileEntries->count();
        $counters['used_space'] = $fileEntries->sum('size');
        $fileEntries = $fileEntries->orderbyDesc('id')->paginate(50);
        $fileEntries->appends(request()->only(['search', 'shared_id']));
        return view('backend.files.visitors.index', [
            'counters' => $counters,
            'fileEntries' => $fileEntries,
        ]);
    }

    public function show(FileEntry $fileEntry)
    {
        abort_if($fileEntry->isForUser(), 404);
        return view('backend.files.visitors.show', ['fileEntry' => $fileEntry]);
    }

    public function update(Request $request, FileEntry $fileEntry)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        $update = $fileEntry->update([
            'name' => $request->name,
            'password' => $request->password,
            'description' => $request->description,
        ]);
        if ($update) {
            toastr()->success(admin_trans('Updated Successfully'));
            return back();
        }
    }

    public function download(FileEntry $fileEntry, $filename)
    {
        abort_if($filename != $fileEntry->getFullName(), 404);
        try {
            $response = $fileEntry->downloadFile();
            if (isset($response->type) && $response->type == "error") {
                toastr()->error($response->message);
                return back();
            }
            return $response;
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function destroy(FileEntry $fileEntry)
    {
        $fileEntry->deleteRecursive();
        toastr()->success(admin_trans('Deleted Successfully'));
        return redirect()->route('admin.files.visitors.index');
    }

    public function destroySelected(Request $request)
    {
        if (empty($request->delete_ids)) {
            toastr()->error(admin_trans('No items selected'));
            return back();
        }
        try {
            $selectedIds = explode(',', $request->delete_ids);
            foreach ($selectedIds as $selectedId) {
                $fileEntry = FileEntry::where('id', $selectedId)->forVisitors()->file()->first();
                if ($fileEntry) {
                    $fileEntry->deleteRecursive();
                }
            }
            toastr()->success(admin_trans('Deleted Successfully'));
            return back();
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
