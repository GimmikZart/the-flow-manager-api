<?php

namespace App\Http\Controllers;

use App\Models\StudentCourse as Subscription;
use App\Http\Resources\SubscriptionCollection;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function singleSubscribe(Request $request)
    {
        if (Subscription::where('student_id', $request->student_id)->where('course_id', $request->course_id)->where('active', '==', 0)->exists()) {
            return response("esiste già");
        } else {
            $subscription = new Subscription();
            $subscription->student_id = $request->student_id;
            $subscription->course_id = $request->course_id;
            $subscription->active = 0;
            $subscription->start_date = $request->start_date;

            $subscription->save();
            return response('done');
        }
    }

    public function endSubscription($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->active = 1;
        $subscription->end_date = date('Y-m-d');

        $subscription->save();
    }
    public function reactiveSubscription(Request $request)
    {
        if (Subscription::where('student_id', $request->student_id)->where('course_id', $request->course_id)->where('active', '==', 0)->exists()) {
            return response("esiste già");
        } else {
            $subscription = Subscription::findOrFail($request->subscription_id);
            $subscription->active = 0;
            $subscription->end_date = null;

            $subscription->save();
            return response('done');
        }
    }
}
