<?php

namespace App\Http\Controllers\Backend\Files;

use App\Http\Controllers\Controller;
use App\Models\FileReport;

class ReportedFilesController extends Controller
{
    public function index()
    {
        updateIsViewed(FileReport::class);
        $fileReports = FileReport::with('file_entry')->get();
        return view('backend.files.reports.index', ['fileReports' => $fileReports]);
    }

    public function show(FileReport $fileReport)
    {
        updateIsViewed(FileReport::class);
        return view('backend.files.reports.show', ['fileReport' => $fileReport]);
    }

    public function destroy(FileReport $fileReport)
    {
        deleteAdminNotification(route('admin.files.reports.show', $fileReport->id));
        $fileReport->delete();
        toastr()->success(admin_trans('Deleted Successfully'));
        return redirect()->route('admin.files.reports.index');
    }
}
