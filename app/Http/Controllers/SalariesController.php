<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salaries;
use Illuminate\Support\Facades\DB;

class SalariesController extends Controller
{
    public function checkSalary()
    {
        $thisMonth = date('m');
        $thisYear = date('Y');

        $prevMonth = $thisMonth - 1;
        if ($prevMonth < 1) {
            $prevMonth = 12;
            $thisYear = $thisYear - 1;
        }

        $subscriptions = DB::table('courses_teachers')
            ->where('active', '==', 0)
            ->get();

        foreach ($subscriptions as $key => $sub) {
            if (Salaries::where('course_instance_id', $sub->courses_teachers_id)->where('month', $prevMonth)->where('year', $thisYear)->exists()) {
                echo "esiste già";
            } else {

                echo "NON ESISTE \n";

                $paymentEntity = new Salaries();
                $studentsNumber = DB::table('courses_students')
                    ->join('payments', 'courses_students.courses_students_id', '=', 'payments.course_instance_id')
                    ->where('active', '=', 0)
                    ->where('course_id', '=', $sub->course_id)
                    ->where('payments.month', '=', $prevMonth) //prevMonth perchè considero il mese precedente
                    ->count();
                if (true) { // rimetti " $studentsNumber > 0" dopo il test per non creare istanze di pagamento inutili quando il mese precedente ha 0 studenti
                    if ($sub->type == 0) { // fisso orario
                        $value = $sub->unit * $sub->work_hours;
                    } elseif ($sub->type == 1 || $sub->type == 3) { // fisso mensile o affitto
                        $value = $sub->unit;
                    } elseif ($sub->type == 2) { // percentuale
                        $coursePrice = DB::table('courses')
                            ->where('courses_id', '=', $sub->course_id)
                            ->select('price')
                            ->first()
                            ->price;
                        $value =  (($coursePrice * $studentsNumber) * $sub->unit) / 100; //calcolo la percentuale che spetta all'insegnante
                    }

                    $paymentEntity->value = $value;
                    $paymentEntity->month = $prevMonth;
                    $paymentEntity->year = $thisYear;
                    $paymentEntity->type = $sub->type;
                    $paymentEntity->course_instance_id = $sub->courses_teachers_id;
                    $paymentEntity->teacher_id = $sub->teacher_id;
                    $paymentEntity->date_of_payment = null;

                    $paymentEntity->save();
                    return "db aggiornato";
                }
            }
        }
    }

    public function paySalary(Request $request)
    {
        $today = date('Y-m-d');
        $payment = Salaries::findOrFail($request->paymentId);
        /* $payment = DB::table('salaries')
            ->where('salaries_id', '=', $paymentId)
            ->first(); */
        $payment->date_of_payment = $today;
        $payment->value = $request->value;
        $payment->status = 0;

        $payment->save();

        return $payment;
    }
    public function cancelSalary($paymentId)
    {
        $today = date('Y-m-d');
        $payment = Salaries::findOrFail($paymentId);
        $payment->date_of_payment = $today;
        $payment->status = 1;

        $payment->save();

        return 'PAGAMENTO ANNULLATO';
    }
    public function undoSalary($paymentId)
    {
        $payment = Salaries::findOrFail($paymentId);
        $payment->date_of_payment = null;
        $payment->status = null;

        $payment->save();

        return 'PAGAMENTO ANNULLATO';
    }
}
