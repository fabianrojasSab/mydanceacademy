<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\StudentPayment;
use App\Models\User;
use App\Models\Lesson;
use App\Models\AcademyUser;
use App\Models\StudentLesson;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentMethod;

class Payments extends Component
{
    public $id;
    public $name;
    public $description;
    public $date;
    public $amount;
    public $student_id;
    public $payments;
    public $paymentId;
    public $students;
    public $lesson_id;
    public $service_id;

    public $lessonsStudent;
    public $paymentMethods;

    public function mount()
    {
        $sessionUser = auth()->user()->id;
        // Obtener la academia asociada al usuario
        $academyId = AcademyUser::where('user_id', $sessionUser)->first()->academy_id;

        $this->paymentMethods = PaymentMethod::all();

        $this->students = User::role('Estudiante')->whereHas('state', function ($query) {
            $query->where('id', '1'); // Filtra para el estado activo
        })
        ->whereHas('academyUsers.academy', function ($query) use ($academyId) {
            $query->where('id', $academyId); // Filtra por el ID de la academia específica
        })
        ->with('academyUsers.academy', 'state')
        ->get();
        
        $this->updatePayments();
    }

    public function delete($id)
    {
        try {
            Pay::where('id',$id)->delete();
            return $this->redirect('/pym/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        $payment = StudentPayment::where('id', $id)        
        ->with('service')
        ->get();

        foreach ($payment as $pay) {
            $this->paymentId = $pay->id;
            $this->name = $pay->service->name;
            $this->description = $pay->description;
            $this->date = $pay->payment_date;
            $this->amount = $pay->amount;
            $this->student_id = $pay->student_id;
        }
    }

    public function update()
    {
        try {
            DB::beginTransaction();
            $payment = StudentPayment::findOrFail($this->paymentId);
            $payment->update([
                'description' => $this->description,
                'payment_date' => $this->date,
                'amount' => $this->amount,
                'student_id' => $this->student_id,
            ]);

            DB::commit();
            $this->updatePayments();
            $this->reset(['name','description','date','amount','student_id','lesson_id']);
        } catch (\Exception $th) {
            dd($th);
            DB::rollBack();
        }
    }

    public function save()
    {
        try {
            DB::beginTransaction();
            StudentPayment::create([
                'description' => $this->name,
                'payment_date' => $this->date,
                'amount' => $this->amount,
                'student_id' => $this->student_id,
                'service_id' => $this->service_id
            ]);

            DB::commit();
            $this->updatePayments();
            $this->reset(['name','description','date','amount','student_id','lesson_id']);
            $this->lessonsStudent = [];
        } catch (\Exception $th) {
            dd($th);
            DB::rollBack();
        }
    }

    public function updatePayments()
    {
        $sessionUser = auth()->user()->id;
        
        $academyId = AcademyUser::where('user_id', $sessionUser)->first()->academy_id;

        if (User::find($sessionUser)->hasRole('Estudiante')) {

        }
        if (User::find($sessionUser)->hasRole('Profesor')) {

        }
        if (User::find($sessionUser)->hasRole('SuperAdmin')) {

        }
        else if (User::find($sessionUser)->hasRole('Administrador')){
            // consulta los pago que pertenecen a los usuarios de la academia del usuario
            $this->payments = StudentPayment::whereHas('user.academyUsers.academy', function ($query) use ($academyId) {
                $query->where('id', $academyId);
            })
            ->with('user', 'paymentMethod')
            ->get();
        }
    }

    //funcion para validar las clases que tiene un estudiante
    public function getLessons()
    {
        $this->lessonsStudent = StudentLesson::where('student_id', $this->student_id)        
        ->with('lesson')
        ->get();
    }

    //funcion que me trae la informacion de la clase seleccionada
    public function getLesson()
    {
        //me trae la clase con los servicios que tiene
        $lesson = Lesson::where('id', $this->lesson_id)
        ->with('services')
        ->first();
        $this->service_id = $lesson->services->first()->id;
        $this->name = $lesson->name;
        $this->description = $lesson->description;
        $this->amount = $lesson->services->first()->price;
    }

    public function render()
    {
        return view('livewire.payments',[
            'payments' => $this->payments,
            'students' => $this->students
        ]);
    }
}
