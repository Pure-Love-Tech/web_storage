<?php

namespace App\Http\Controllers\Backend\Members;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Referral;
use App\Models\User;
use App\Models\UserLog;
use App\Models\WithdrawalMethod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        updateIsViewed(User::class);

        $counters['active'] = User::where('status', 1)->get()->count();
        $counters['banned'] = User::where('status', 0)->get()->count();
        $counters['subscribed'] = User::whereHas('subscription')->count();
        $counters['unsubscribed'] = User::whereDoesntHave('subscription')->count();

        $users = User::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $users->where('firstname', 'like', $searchTerm)
                ->OrWhere('lastname', 'like', $searchTerm)
                ->OrWhere('username', 'like', $searchTerm)
                ->OrWhere('email', 'like', $searchTerm)
                ->OrWhere('mobile', 'like', $searchTerm);
        }

        if (request()->filled('subscription')) {
            if (request('subscription') == 1) {
                $users->whereHas('subscription');
            } else {
                $users->whereDoesntHave('subscription');
            }
        }

        if (request()->filled('status')) {
            $users->where('status', request('status'));
        }

        $users = $users->orderbyDesc('id')->paginate(30);
        $users->appends(request()->only(['search', 'subscription', 'status']));

        return view('backend.members.users.index', ['counters' => $counters, 'users' => $users]);
    }

    public function create()
    {
        return view('backend.members.users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'alpha_dash', 'max:50', 'unique:users'],
            'email' => ['required', 'email', 'string', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
        if ($request->has('avatar')) {
            $avatar = imageUpload($request->file('avatar'), 'images/avatars/users/', '110x110');
        } else {
            $avatar = "images/avatars/default.png";
        }
        $user = User::create([
            'name' => $request->username,
            'username' => $request->username,
            'email' => $request->email,
            'avatar' => $avatar,
            'password' => Hash::make($request->password),
        ]);
        if ($user) {
            $user->forceFill(['email_verified_at' => Carbon::now()])->save();
            toastr()->success(admin_trans('Created Successfully'));
            return redirect()->route('admin.members.users.edit', $user->id);
        }
    }

    public function show(User $user)
    {
        return abort(404);
    }

    public function edit(User $user)
    {
        $withdrawalMethods = WithdrawalMethod::orderBy('sort_id', 'asc')->active()->get();
        return view('backend.members.users.edit.index', ['user' => $user, 'withdrawalMethods' => $withdrawalMethods]);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => ['nullable', 'string', 'max:50'],
            'lastname' => ['nullable', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username,' . $user->id],
            'email' => ['required', 'email', 'string', 'max:100', 'unique:users,email,' . $user->id],
            'mobile' => ['nullable', 'string', 'max:50', 'unique:users,mobile,' . $user->id],
            'downloads_earnings' => ['required', 'numeric'],
            'referrals_earnings' => ['required', 'numeric'],
            'address_1' => ['nullable', 'max:255'],
            'address_2' => ['nullable', 'max:255'],
            'city' => ['nullable', 'max:150'],
            'state' => ['nullable', 'max:150'],
            'zip' => ['nullable', 'max:100'],
            'country' => ['nullable', 'integer', 'exists:countries,id'],
            'withdrawal_method' => ['nullable', 'integer', 'exists:withdrawal_methods,id'],
            'withdrawal_account' => ['nullable', 'string', 'max:600'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        if (!is_null($request->withdrawal_method) && is_null($request->withdrawal_account)) {
            toastr()->error(admin_trans('Withdrawal Account cannot be empty'));
            return back();
        }
        if (is_null($request->withdrawal_method)) {
            $request->withdrawal_account = null;
        }
        $country = Country::find($request->country);
        $status = ($request->has('status')) ? 1 : 0;
        $google2fa_status = ($request->has('google2fa_status')) ? 1 : 0;
        $address = [
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $country->name ?? null,
        ];
        $update = $user->update([
            'name' => $request->firstname . ' ' . $request->lastname,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'downloads_earnings' => $request->downloads_earnings,
            'referrals_earnings' => $request->referrals_earnings,
            'withdrawal_method_id' => $request->withdrawal_method,
            'withdrawal_account' => $request->withdrawal_account,
            'address' => $address,
            'google2fa_status' => $google2fa_status,
            'status' => $status,
        ]);
        if ($update) {
            $emailValue = ($request->has('email_status')) ? Carbon::now() : null;
            $user->forceFill([
                'email_verified_at' => $emailValue,
            ])->save();
            toastr()->success(admin_trans('Updated Successfully'));
            return back();
        }

    }

    public function destroy(User $user)
    {
        if ($user->file_entries->count() > 0) {
            foreach ($user->file_entries as $fileEntry) {
                $fileEntry->deleteRecursive();
            }
        }
        if ($user->transactions->count() > 0) {
            foreach ($user->transactions as $transaction) {
                if ($transaction->proof) {
                    storageRemove($transaction->proof, 'local');
                    $transaction->delete();
                }
            }
        }
        if ($user->avatar != "images/avatars/default.png") {
            removeFile(public_path($user->avatar));
        }
        deleteAdminNotification(route('admin.members.users.edit', $user->id));
        $user->delete();
        toastr()->success(admin_trans('Deleted Successfully'));
        return back();
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
                $user = User::where('id', $selectedId)->first();
                if ($user) {
                    if ($user->avatar != "images/avatars/default.png") {
                        removeFile(public_path($user->avatar));
                    }
                    $user->delete();
                }
            }
            toastr()->success(admin_trans('Deleted Successfully'));
            return back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function changeAvatar(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return response()->json(['error' => $error]);
            }
        }
        if ($request->has('avatar')) {
            if ($user->avatar == 'images/avatars/default.png') {
                $avatar = imageUpload($request->file('avatar'), 'images/avatars/users/', '110x110');
            } else {
                $avatar = imageUpload($request->file('avatar'), 'images/avatars/users/', '110x110', null, $user->avatar);
            }
        } else {
            return response()->json(['error' => admin_trans('Upload error')]);
        }
        $update = $user->update([
            'avatar' => $avatar,
        ]);
        if ($update) {
            return response()->json(['success' => admin_trans('Updated Successfully')]);
        }
    }

    public function deleteAvatar(User $user)
    {
        $avatar = "images/avatars/default.png";
        if ($user->avatar != $avatar) {
            removeFile(public_path($user->avatar));
        } else {
            toastr()->error(admin_trans('Default avatar cannot be deleted'));
            return back();
        }
        $update = $user->update([
            'avatar' => $avatar,
        ]);
        if ($update) {
            toastr()->success(admin_trans('Removed Successfully'));
            return back();
        }
    }

    public function sendMail(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'subject' => ['required', 'string'],
            'reply_to' => ['required', 'email'],
            'message' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        if (!settings('smtp')->status) {
            toastr()->error(admin_trans('SMTP is not enabled'));
            return back()->withInput();
        }
        try {
            $email = $user->email;
            $subject = $request->subject;
            $replyTo = $request->reply_to;
            $msg = $request->message;
            \Mail::send([], [], function ($message) use ($msg, $email, $subject, $replyTo) {
                $message->to($email)
                    ->replyTo($replyTo)
                    ->subject($subject)
                    ->html($msg);
            });
            toastr()->success(admin_trans('Sent successfully'));
            return back();
        } catch (\Exception $e) {
            toastr()->error(admin_trans('Sent error'));
            return back();
        }
    }

    public function referrals(User $user)
    {
        $referrals = Referral::where('referring_user_id', $user->id)->orderbyDesc('id')->get();
        return view('backend.members.users.edit.referrals', [
            'user' => $user,
            'referrals' => $referrals,
        ]);
    }

    public function destroyReferral(User $user, $id)
    {
        $referral = Referral::where('id', $id)->where('referring_user_id', $user->id)->firstOrFail();
        $referral->delete();
        toastr()->success(admin_trans('Deleted Successfully'));
        return back();
    }

    public function logs(User $user)
    {
        $logs = UserLog::where('user_id', $user->id)->select('id', 'ip', 'location')->orderbyDesc('id')->paginate(6);
        return view('backend.members.users.edit.logs', ['user' => $user, 'logs' => $logs]);
    }

    public function getLogs(User $user, UserLog $userLog)
    {
        $userLog['ip_link'] = route('admin.members.users.logsbyip', $userLog->ip);
        return response()->json($userLog);
    }

    public function logsByIp($ip)
    {
        $logs = UserLog::where('ip', $ip)->with('user')->paginate(12);
        return view('backend.members.users.logs', ['logs' => $logs]);
    }
}
