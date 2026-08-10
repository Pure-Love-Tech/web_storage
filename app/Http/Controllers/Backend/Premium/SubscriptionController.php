<?php

namespace App\Http\Controllers\Backend\Premium;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PremiumPlan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        updateIsViewed(Subscription::class);
        $counters['active'] = Subscription::notExpired()->count();
        $counters['expired'] = Subscription::expired()->count();
        $users = User::all();
        $plans = Plan::all();
        $subscriptions = Subscription::query();
        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $subscriptions->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->orWhereHas('user', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', $searchTerm)
                            ->orWhere('username', 'like', $searchTerm)
                            ->orWhere('email', 'like', $searchTerm)
                            ->orWhere('mobile', 'like', $searchTerm);
                    });
            });
        }
        if (request()->filled('user')) {
            $subscriptions->where('user_id', request('user'));
        }
        if (request()->filled('status')) {
            if (request('status') == 1) {
                $subscriptions->notExpired();
            } elseif (request('status') == 2) {
                $subscriptions->expired();
            }
        }
        $subscriptions = $subscriptions->orderByDesc('id')->paginate(50);
        $subscriptions->appends(request()->only(['search', 'user', 'plan', 'status']));
        return view('backend.premium.subscriptions.index', [
            'counters' => $counters,
            'users' => $users,
            'plans' => $plans,
            'subscriptions' => $subscriptions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $premiumPlans = PremiumPlan::all();
        return view('backend.premium.subscriptions.create', [
            'users' => User::all(),
            'premiumPlans' => $premiumPlans,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => ['required', 'integer', 'exists:users,id'],
            'plan_id' => ['required', 'integer', 'exists:premium_plans,id'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        $subscription = Subscription::where('user_id', $request->user)->first();
        if ($subscription) {
            toastr()->error(admin_trans('The selected user already have an active subscription'));
            return back();
        }
        $premiumPlan = PremiumPlan::findOrFail($request->plan_id);
        $expiryAt = Carbon::now()->addDays($premiumPlan->interval);
        $createSubscription = Subscription::create([
            'user_id' => $request->user,
            'expiry_at' => $expiryAt,
        ]);
        if ($createSubscription) {
            toastr()->success(admin_trans('Subscription created successfully'));
            return redirect()->route('admin.premium.subscriptions.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        return view('backend.premium.subscriptions.edit', [
            'subscription' => $subscription,
            'users' => User::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        $validator = Validator::make($request->all(), [
            'expiry_at' => ['required'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        $expiry_at = Carbon::parse($request->expiry_at);
        if ($expiry_at > Carbon::parse($subscription->expiry_at)) {
            $subscription->expire_notification = false;
        }
        $subscription->expiry_at = $expiry_at;
        $subscription->update();
        toastr()->success(admin_trans('Subscription updated successfully'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        toastr()->success(admin_trans('Deleted successfully'));
        return back();
    }
}
