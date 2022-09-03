<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\StudentCourse as Subscription;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Mockery\Undefined;

class PaymentsController extends Controller
{

    public function checkPayments()
    {
        $thisMonth = date('m');
        $thisYear = date('Y');
        $subscriptions = DB::table('courses_students')
            ->where('active', '==', 0)
            ->join('courses', 'courses_students.course_id', '=', 'courses.courses_id')
            ->select('courses_students.courses_students_id', 'courses.price', 'courses_students.student_id')
            ->get();
        echo ($thisMonth . '/' . $thisYear) . "\n";
        foreach ($subscriptions as $key => $sub) {
            if (Payment::where('course_instance_id', $sub->courses_students_id)->where('month', $thisMonth)->where('year', $thisYear)->exists()) {
                echo "esiste già";
            } else {
                echo "NON ESISTE \n";
                $paymentEntity = new Payment();
                $paymentEntity->value = $sub->price;
                $paymentEntity->month = $thisMonth;
                $paymentEntity->year = $thisYear;
                $paymentEntity->course_instance_id = $sub->courses_students_id;
                $paymentEntity->student_id = $sub->student_id;
                $paymentEntity->date_of_payment = null;

                $paymentEntity->save();
            }
        }

        return "db aggiornato";
    }

    public function payCourse($paymentId)
    {
        $today = date('Y-m-d');
        $payment = Payment::findOrFail($paymentId);
        $payment->date_of_payment = $today;
        $payment->status = 0;

        $payment->save();

        return 'PAGATO';
    }
    public function cancelPayment($paymentId)
    {
        $today = date('Y-m-d');
        $payment = Payment::findOrFail($paymentId);
        $payment->date_of_payment = $today;
        $payment->status = 1;

        $payment->save();

        return 'PAGAMENTO ANNULLATO';
    }
    public function undoPayment($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->date_of_payment = null;
        $payment->status = null;

        $payment->save();

        return 'STATUS PAGAMENTO ANNULLATO';
    }
}
