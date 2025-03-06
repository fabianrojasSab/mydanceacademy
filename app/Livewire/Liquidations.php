<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\User;
use App\Models\TeacherPaymentSetting;
use App\Models\Presence;
use App\Models\Lesson;
use App\Models\AcademyUser;
use App\Models\StudentLesson;
use App\Enums\ErrorCodes;
use App\Models\TeacherPayment;

class Liquidations extends Component
{
    public $teachers;
    public $teacherId;
    public $lessons;
    public $teacherSetting;
    public $lessonsteacher;
    public $lessonId;
    public $totalPagar;
    public $totalByStudents;
    public $adittionalValue;
    public $infoLesson;
    public $infoShedule;
    public $teachersLesson;
    public $isPayShared;
    public $monthLiquidation; 
    public $yearLiquidation;

    public function mount()
    {
        $this->monthLiquidation = date('m') - 1; // Mes anterior para liquidar
        $this->yearLiquidation = date('Y');
        
        $sessionUser = auth()->user()->id;

        $academyId = AcademyUser::where('user_id', $sessionUser)->first()->academy_id;

        $this->teachers = User::role('Profesor')->whereHas('state', function ($query) {
            $query->where('id', '1'); // Filtra para el estado activo
        })
            ->whereHas('academyUsers.academy', function ($query) use ($academyId) {
                $query->where('id', $academyId); // Filtra por el ID de la academia específica
            })
            ->with('academyUsers.academy', 'state')
            ->get();
    }

    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    public function save(){
        $this->validate([
            'teacherId' => 'required',
            'lessonId' => 'required',
            'totalPagar' => 'required',
            'monthLiquidation' => 'required',
            'yearLiquidation' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $teacherPayment = TeacherPayment::create([
                'teacher_id' => $this->teacherId,
                'payment_method_id' => $this->teacherSetting->first()->payment_method_id,
                'amount' => $this->totalPagar,
                'payment_date' => now(),
                'lesson_id' => $this->lessonId,
            ]);

            DB::commit();

            $this->dispatch('mostrarAlerta', mensaje: 'Se registró liquidación correctamente.', tipo: 'success');
            $this->teacherId = null;
            $this->resetValues();
        } catch (\Exception $th) {
            DB::rollBack();
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::TEACHER_PAYMENT_SAVE_ERROR), tipo: 'error', code: ErrorCodes::TEACHER_PAYMENT_SAVE_ERROR);
        }
    }

    //funcion que trae las clases dictadas por un profesor
    public function getLessonIds(){

        $this->resetValues();
        $this->getTeacherPaymentSetting();

        // Obtener las clases del profesor que haya marcado como dictadas y que no cuente con pagos registrados
        $lessonsIds = DB::table('presences as p')
        ->join('schedules as s', 'p.schedule_id', '=', 's.id')
        ->leftjoin('teacher_payments as tp', function($join) {
                    $join->on('tp.lesson_id', '=', 's.lesson_id')
                        ->on('tp.teacher_id', '=', 's.teacher_id'); // Segunda condición con AND
                    })// Relación con los pagos de los profesores
        ->where('p.teacher_id', $this->teacherId)
        ->whereNull('tp.teacher_id')
        ->select('s.lesson_id', DB::raw('count(*) as lesson_count'))
        ->groupBy('s.lesson_id')
        ->get();

        //recorre la variable lessonsids y consulta las clases
        $this->lessonsteacher = Lesson::whereIn('id', $lessonsIds->pluck('lesson_id'))->where('state', 1)->get();
    }

    //funcionque consulta los estudiantes que se encontraban inscritos a las clases dictadas por el profesor
    public function getPreview()
    {
        //consultar la cantidad de clases dictadas por el profesor
        $this->infoLesson = DB::table('presences as p')
        ->join('schedules as s', 'p.schedule_id', '=', 's.id')
        ->join('lessons as l', 's.lesson_id', '=', 'l.id')
        ->where('p.teacher_id', $this->teacherId)
        ->where('l.id', $this->lessonId)
        ->whereMonth('s.date', $this->monthLiquidation)
        ->whereYear('s.date', $this->yearLiquidation)
        ->select('l.id', 'l.name as name', DB::raw('count(l.id) as lesson_count'))
        ->groupBy('l.id', 'l.name')
        ->get();

        //consultar la cantidad de shedules por clase
        $this->infoShedule = DB::table('schedules as s')
        ->join('lessons as l', 's.lesson_id', '=', 'l.id')
        ->where('l.id', $this->lessonId)
        ->whereMonth('s.date', $this->monthLiquidation)
        ->whereYear('s.date', $this->yearLiquidation)
        ->select('l.id', DB::raw('count(l.id) as schedule_count'))
        ->groupBy('l.id')
        ->get();

        // Consultar los estudiantes que estaban inscritos y pagaron antes o durante las clases dictadas
        $this->lessons = StudentLesson::where('lesson_id', $this->lessonId)
        ->whereHas('student.studentPayments', function ($query) {// Filtrar pagos dentro del mes y año de liquidación
            $query->whereMonth('payment_date', $this->monthLiquidation)
                ->whereYear('payment_date', $this->yearLiquidation);
        })
        ->with(['lesson.services', 'student.studentPayments'])
        ->get()
        ->map(function ($sl) {
            return [
                'student_id' => $sl->student_id,
                'name' => $sl->student->name,
                'price' => $sl->lesson->services->price ?? null,
                'payment_date' => optional($sl->student->studentPayments->last())->payment_date, // Muestra la última fecha de pago
            ];
        });

        // Consulta la informacion de las clases dictadas por el profesor para comparar con la fecha de pago del estudiante
        $dateShedule =  DB::table('presences as p')
        ->join('schedules as s', 'p.schedule_id', '=', 's.id')
        ->leftjoin('teacher_payments as tp', function($join) {
                    $join->on('tp.lesson_id', '=', 's.lesson_id')
                        ->on('tp.teacher_id', '=', 's.teacher_id'); // Segunda condición con AND
                    })// Relación con los pagos de los profesores
        ->where('p.teacher_id', $this->teacherId)
        ->whereNull('tp.teacher_id')
        ->select('s.lesson_id', 's.date')
        ->get();

        //comparar la fecha de la clase con la fecha de pago del estudiante, si la fecha de pago es menor o igual a la fecha de la clase se muestra el estudiante
        $this->lessons = $this->lessons->filter(function ($lesson) use ($dateShedule) {
            return $lesson['payment_date'] <= $dateShedule->pluck('date')->last();
        });

        //saca el total de dinero que se le debe al profesor
        $this->totalByStudents = $this->lessons->sum('price');

        $this->getTeachersLesson();
        $this->calculateTotal();
    }

    //funcion que consulta los profesores que dictaron una clase
    public function getTeachersLesson()
    {
        //consulta de la lesson para saber cuantos profesores dictaron la clase
        $this->teachersLesson = Lesson::where('state', 1) // Solo clases activas
        ->where('id', $this->lessonId)
        ->with('schedules.teachers') // Cargar los horarios y los profesores de esos horarios
        ->get();

        if ($this->teachersLesson->isNotEmpty()) {
            $processedLessons = [];
    
            foreach ($this->teachersLesson as $teacherLesson) {
                // Obtener los nombres de los profesores y convertirlo en un array plano
                $teachers = $teacherLesson->schedules->pluck('teachers')->flatten()->unique('id')->toArray();
    
                // Agregar al array de lecciones procesadas
                $processedLessons = array_merge($processedLessons, $teachers);
            }
    
            // Asignar el array de nombres de profesores a la propiedad Livewire
            $this->teachersLesson = $processedLessons;
        }
    }

    //Funcion para hacer calculo del valor total a pagar de acuerdo a la configuracion de pago del profesor
    public function calculateTotal()
    {
        //extrae de teacherSetting el payment_method_id y lo almacena en una variable
        $paymentMethodId = $this->teacherSetting->first()->payment_method_id;

        switch ($paymentMethodId) {
            case 1:
                $this->calculateTotalByFixed();
                break;
            case 2:
                $this->calculateTotalByLesson();
                break;
            case 3:
                $this->calculateTotalByPercentage();
                break;
        }
    }

    //funcion para calcular el total a pagar por porcentaje
    public function calculateTotalByPercentage()
    {
        $infoLesson = DB::table('presences as p')
        ->join('schedules as s', 'p.schedule_id', '=', 's.id')
        ->join('lessons as l', 's.lesson_id', '=', 'l.id')
        ->where('l.id', $this->lessonId)
        ->whereMonth('s.date', $this->monthLiquidation)
        ->whereYear('s.date', $this->yearLiquidation)
        ->select('l.id', DB::raw('count(l.id) as lesson_count'))
        ->groupBy('l.id')
        ->get();

        $lesson_count = $infoLesson->pluck('lesson_count')->first();
        $schedule_count = $this->infoShedule->pluck('schedule_count')->first();

        //recorre los profesores de la clase y valida si son mas de uno
        if (count($this->teachersLesson) > 1) {
            //valida que todas las clases dictadas sean iguales a la cantidad de horarios de la clase
            if($lesson_count == $schedule_count){
                //habilitar boton para liquidar
                $this->totalPagar = $this->totalByStudents * $this->teacherSetting->first()->param_value;
            }else{
                //deshabilitar boton para liquidar
                $this->dispatch('mostrarAlerta', mensaje: 'No se han dictado todas las clases programadas.', tipo: 'warning');
                $this->totalPagar = 0;
            }
        } else {
            //si solo hay un profesor en la clase, valida si la cantidad de clases dictadas es igual a la cantidad de horarios de la clase
            if ($lesson_count == $schedule_count) {
                //habilitar boton de liquidar
                $this->totalPagar = $this->totalByStudents * $this->teacherSetting->first()->param_value;
            } else {
                $this->dispatch('mostrarAlerta', mensaje: 'No se han dictado todas las clases programadas.', tipo: 'warning');
                $this->totalPagar = 0;
            }
        }
    }

    //funcion para calcular el total a pagar por valor fijo
    public function calculateTotalByFixed()
    {
        $this->totalPagar = $this->teacherSetting->first()->param_value;
    }

    //funcion para calcular el total a pagar por porcentaje y valor fijo
    public function calculateTotalByLesson()
    {
        $this->totalPagar = $this->totalByStudents * $this->teacherSetting->first()->param_value;
    }

    //funcion para reiniciar las variables
    public function resetValues()
    {
        $this->lessonsteacher = null;
        $this->lessonId = null;
        $this->infoLesson = null;
        $this->infoShedule = null;
        $this->totalPagar = null;
        $this->teachersLesson = null;
        $this->teacherSetting = null;
        $this->isPayShared = false;
        $this->totalByStudents = 0;
        $this->adittionalValue = null;
        $this->lessons = null;
        //clases de estudiantes
    }

    //funcion para capturar el evento de cambio de toggle clase compartida
    public function toggleIsPayShared()
    {
        //validar si el total a pagar ya esta calculado
        if($this->totalPagar == 0 ){
            $this->isPayShared = false;
            //genera mensaje indicando que no se ha calculado el total a pagar
        }else{
            if($this->isPayShared){
                $this->totalPagar = $this->totalByStudents * $this->teacherSetting->first()->param_value;
                $this->totalPagar = $this->totalPagar / count($this->teachersLesson);
            } else {
                $this->totalPagar = $this->totalByStudents * $this->teacherSetting->first()->param_value;
            }
        }
    }

    //funcion que trae la configuracion de pagos de un profesor
    public function getTeacherPaymentSetting()
    {
        //obtener la configuracion de pagos del profesor
        $this->teacherSetting = TeacherPaymentSetting::where('teacher_id', $this->teacherId)->get();
    }

    //funcion para actualizar el valor total a pagar
    public function updateTotal()
    {   
        $this->totalPagar = $this->totalPagar + $this->adittionalValue;
        $this->adittionalValue = 0;
    }

    public function render()
    {
        return view('livewire.liquidations');
    }
}
