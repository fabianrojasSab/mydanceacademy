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

    public function mount()
    {
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

    //funcion que trae las clases dictadas por un profesor
    public function getLessonIds(){

        $this->resetValues();
        $this->getTeacherPaymentSetting();

        // Obtener las clases del profesor
        $lessonsIds = DB::table('presences as p')
        ->join('schedules as s', 'p.schedule_id', '=', 's.id')
        ->where('p.teacher_id', $this->teacherId)
        ->select('s.lesson_id', DB::raw('count(s.lesson_id) as lesson_count'))
        ->groupBy('s.lesson_id')
        ->get();

        //recorre la variable lessonsids y consulta las clases
        $this->lessonsteacher = Lesson::whereIn('id', $lessonsIds->pluck('lesson_id'))->where('state', 1)->get();
    }

    //funcionque consulta los estudiantes que se encontraban inscritos a las clases dictadas por el profesor
    public function getPreview()
    {
        $this->infoLesson = DB::table('presences as p')
        ->join('schedules as s', 'p.schedule_id', '=', 's.id')
        ->join('lessons as l', 's.lesson_id', '=', 'l.id')
        ->where('p.teacher_id', $this->teacherId)
        ->where('l.id', $this->lessonId)
        ->select('l.id', 'l.name as name', DB::raw('count(l.id) as lesson_count'))
        ->groupBy('l.id', 'l.name')
        ->get();

        //consultar la cantidad de shedules por clase
        $this->infoShedule = DB::table('schedules as s')
        ->join('lessons as l', 's.lesson_id', '=', 'l.id')
        ->where('l.id', $this->lessonId)
        ->select('l.id', DB::raw('count(l.id) as schedule_count'))
        ->groupBy('l.id')
        ->get();

        //consultar los estudiantes que estaban inscritos a las clases dictadas por los profesores
        $this->lessons = StudentLesson::where('lesson_id', $this->lessonId)
        ->with(['lesson.services'])
        ->get()
        ->map(function ($sl) {
            return [
                'student_id' => $sl->student_id,
                'name' => $sl->student->name,
                'price' => $sl->lesson->services->price ?? null,
            ];
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
        //recorre los profesores de la clase y valida si son mas de uno
        if (count($this->teachersLesson) > 1) {
            $infoLesson = DB::table('presences as p')
            ->join('schedules as s', 'p.schedule_id', '=', 's.id')
            ->join('lessons as l', 's.lesson_id', '=', 'l.id')
            ->where('l.id', $this->lessonId)
            ->select('l.id', DB::raw('count(l.id) as lesson_count'))
            ->groupBy('l.id')
            ->get();

            $lesson_count = $infoLesson->pluck('lesson_count')->first();
            $schedule_count = $this->infoShedule->pluck('schedule_count')->first();

            //valida que todas las clases dictadas sean iguales a la cantidad de horarios de la clase
            if($lesson_count == $schedule_count){
                //habilitar boton para liquidar
                $this->totalPagar = $this->totalByStudents * $this->teacherSetting->first()->param_value;
            }else{
                //deshabilitar boton para liquidar
                $this->totalPagar = 0;
            }
        } else {
            //si solo hay un profesor en la clase, valida si la cantidad de clases dictadas es igual a la cantidad de horarios de la clase
            if ($lesson_count == $schedule_count) {
                //habilitar boton de liquidar
                $this->totalPagar = $this->totalByStudents * $this->teacherSetting->first()->param_value;
            } else {
                //si no es igual, deshabilitar boton de liquidar
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
    }

    //funcion para capturar el evento de cambio de toggle clase compartida
    public function toggleIsPayShared()
    {
        //reiniciar total a pagar
        $this->totalPagar = 0;

        if($this->isPayShared){
            $this->totalPagar = $this->totalByStudents * $this->teacherSetting->first()->param_value;
            $this->totalPagar = $this->totalPagar / count($this->teachersLesson);
        } else {
            $this->totalPagar = $this->totalByStudents * $this->teacherSetting->first()->param_value;
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
