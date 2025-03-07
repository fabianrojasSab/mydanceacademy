<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lesson;
use App\Models\User;
use App\Models\AcademyUser;
use App\Models\TeacherLesson;
use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use App\Models\Services;
use App\Models\TeacherPayment;
use App\Enums\ErrorCodes;

class Lessons extends Component
{
    public $id;
    public $name;
    public $description;
    public $duration;
    public $capacity;
    public $start_date;
    public $end_date;
    public $start_time;
    public $end_time;
    public $state_id;
    public $user_id;
    public $lessons;
    public $lessonId;
    public $teachers;
    public $teacherId;

    public $selectedDays = []; // Para almacenar los días seleccionados
    public $newSchedule = false; // Para saber si se está creando un nuevo horario

    public function mount()
    {
        $this->updateLessons();
        
        $this->teachers = User::whereHas('roles', function($q){
            $q->where('name', 'Profesor');
        })->get();
    }

    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    public function delete($id)
    {
        try {
            Lesson::where('id',$id)->delete();
            Schedule::where('lesson_id',$id)->delete();
            return $this->redirect('/lsn/r',navigate:true); 
        } catch (\Exception $th) {
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::LESSON_DELETE_ERROR), tipo: 'error', code: ErrorCodes::LESSON_DELETE_ERROR);
        }
    }

    //Funcion para inactivar las lessons
    public function disable($id)
    {
        try {
            DB::beginTransaction();
            $lesson = Lesson::findOrFail($id);
            $lesson->update([
                'state_id'=> 2
            ]);
            DB::commit();
            $this->updateLessons();
            $this->dispatch('mostrarAlerta', mensaje: 'Clase inactivada correctamente.', tipo: 'success');
        } catch (\Exception $th) {
            DB::rollback();
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::LESSON_ACTIVE_ERROR), tipo: 'error', code: ErrorCodes::LESSON_ACTIVE_ERROR);
        }
    }

    public function edit($id)
    {
        $this->selectedDays = [];
        $this->newSchedule = false; 

        //consulta la clase que se va a editar 
        $lesson = Lesson::where('id', $id)->first();
        //busca en la tabla schedule las clases que tengan el id de la clase
        $schedule = Schedule::where('lesson_id', $id)->first();

        //valida si $schedule viene vacia para asignarle un valor
        if (!$schedule) {
            $schedule = new Schedule();
            $schedule->capacity = 0;
            $schedule->start_time = '00:00';
            $schedule->end_time = '00:00';
        }

        //recorre la lista de dias de la semana que se imparte la clase, agruppados por dia
        $days = Schedule::where('lesson_id', $id)->get()->groupBy('day');
        //recorre la lista de dias de la semana que se imparte la clase, y los guarda en un array
        foreach ($days as $day) {
            $this->selectedDays[] = $day[0]->day;
        }
        
        //asigna los valores a las variables
        $this->lessonId = $lesson->id;
        $this->name = $lesson->name;
        $this->description = $lesson->description;
        $this->duration = $lesson->duration;
        $this->capacity = $schedule->capacity;
        $this->start_date = $lesson->start_date;
        $this->end_date = $lesson->end_date;
        $this->state_id = $lesson->state_id;
        $this->start_time = $schedule->start_time;
        $this->end_time = $schedule->end_time;
    }

    public function editSchedule($id)
    {
        $this->selectedDays = [];
        
        //consulta la clase que se va a editar 
        $lesson = Lesson::where('id', $id)->first();
        //busca en la tabla schedule las clases que tengan el id de la clase
        $schedule = Schedule::where('lesson_id', $id)->first();

        if (!$schedule) {
            $schedule = new Schedule();
            $schedule->capacity = 0;
            $schedule->start_time = '00:00';
            $schedule->end_time = '00:00';
        }

        //asigna los valores a las variables
        $this->lessonId = $lesson->id;
        $this->name = $lesson->name;
        $this->description = $lesson->description;
        $this->duration = $lesson->duration;
        $this->capacity = $schedule->capacity;
        $this->state_id = $lesson->state_id;
        $this->start_time = $schedule->start_time;
        $this->end_time = $schedule->end_time;

        $this->newSchedule = true; // Indica que se está editando un horario
    }

    public function update()
    {
        try {
            DB::beginTransaction();
            
            $lesson = Lesson::findOrFail($this->lessonId);
            $lesson->update([
                'name' => $this->name,
                'description'=> $this->description,
                'duration'=> $this->duration,
                'start_date'=> $this->start_date,
                'end_date'=> $this->end_date,
                'state_id'=> $this->state_id
            ]);

            //valida si agregó mas dias de los que tenia la clase y los agrega
            $days = Schedule::where('lesson_id', $this->lessonId)->get()->groupBy('day');
            foreach ($days as $day) {
                if (!in_array($day[0]->day, $this->selectedDays)) {
                    Schedule::where('lesson_id', $this->lessonId)->where('day', $day[0]->day)->delete();
                }
            }

            //falta poner validacion de que si quita un dia de la semana, que elimine los registros de la tabla schedule

            // Convertimos las fechas en Carbon para poder compararlas
            $startDate = Carbon::parse($this->start_date);
            $endDate = Carbon::parse($this->end_date);

            // Iteramos por cada día de la semana seleccionado
            foreach ($this->selectedDays as $day) {
                // Empezamos desde la fecha de inicio para cada día seleccionado
                $current_date = $startDate->copy();

                // Iteramos mientras la fecha actual no haya superado la fecha de fin
                while ($current_date <= $endDate) {
                    // Si el día de la semana coincide con el día seleccionado
                    if ($current_date->dayOfWeek === intval($day)) {
                        // Creamos la clase en la tabla schedule, asociada a la lesson
                        Schedule::updateOrCreate([
                            'lesson_id' => $this->lessonId,
                            'day' => $current_date->dayOfWeek,
                            'start_time' => $this->start_time,
                            'end_time' => $this->end_time,
                            'capacity' => $this->capacity,
                            'date' => $current_date->format('Y-m-d'),
                        ]);
                    }

                    // Avanzamos al siguiente día
                    $current_date->addDay();
                }
            }

            DB::commit();
            $this->updateLessons();
            $this->reset(['name','description','duration','capacity','start_date','end_date','state_id','teacherId','selectedDays','start_time','end_time']);
            $this->dispatch('mostrarAlerta', mensaje: 'Clase actualizada correctamente.', tipo: 'success');
        } catch (\Exception $th) {
            DB::rollback();
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::LESSON_UPDATE_ERROR), tipo: 'error', code: ErrorCodes::LESSON_UPDATE_ERROR);
            $this->reset(['name', 'description', 'duration', 'capacity', 'start_date', 'end_date', 'state_id', 'teacherId', 'selectedDays', 'start_time', 'end_time']);
        }
    }
    
    public function save()
    {
        try {
            DB::beginTransaction();
            $academyUser = AcademyUser::where('user_id', auth()->user()->id)->first();
            $lesson = Lesson::create([
                'name'=> $this->name,
                'description'=> $this->description,
                'duration'=> $this->duration,
                'start_date'=> $this->start_date,
                'end_date'=> $this->end_date,
                'state'=> 1,  
                'academy_id'=> $academyUser->academy_id,
                'service_id'=> 1
            ]);

            // Convertimos las fechas en Carbon para poder compararlas
            $startDate = Carbon::parse($this->start_date);
            $endDate = Carbon::parse($this->end_date);

            // Iteramos por cada día de la semana seleccionado
            foreach ($this->selectedDays as $day) {
                // Empezamos desde la fecha de inicio para cada día seleccionado
                $current_date = $startDate->copy();

                // Iteramos mientras la fecha actual no haya superado la fecha de fin
                while ($current_date <= $endDate) {
                    // Si el día de la semana coincide con el día seleccionado
                    if ($current_date->dayOfWeek === intval($day)) {
                        // Creamos la clase en la tabla schedule, asociada a la lesson
                        $schedule = Schedule::create([
                            'lesson_id' => $lesson->id,
                            'teacher_id' => $this->teacherId,
                            'day' => $current_date->dayOfWeek,
                            'start_time' => $this->start_time,
                            'end_time' => $this->end_time,
                            'capacity' => $this->capacity,
                            'date' => $current_date->format('Y-m-d'),
                        ]);
                    }

                    // Avanzamos al siguiente día
                    $current_date->addDay();
                }
            }

            DB::commit();
            $this->updateLessons();
            $this->reset(['name','description','duration','capacity','start_date','end_date','state_id','teacherId','selectedDays','start_time','end_time']);
            $this->dispatch('mostrarAlerta', mensaje: 'Clase creada correctamente.', tipo: 'success');
        } catch (\Exception $th) {
            DB::rollback();
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::LESSON_CREATE_ERROR), tipo: 'error', code: ErrorCodes::LESSON_CREATE_ERROR);
            $this->reset(['name', 'description', 'duration', 'capacity', 'start_date', 'end_date', 'state_id', 'teacherId', 'selectedDays', 'start_time', 'end_time']);
        }
    }

    //Funcion para agregar nuevo horario a la clase
    public function addSchedule()
    {
        //consultar que todos los horarios fueron marcados como vistos
        $countSchedules = Schedule::where('lesson_id', $this->lessonId)
                    ->select(DB::raw('count(id) as schedule_count'))->get();

        //consultar que todos los horarios fueron marcados como vistos
        $countPresences = Schedule::with('presences')->where('lesson_id', $this->lessonId)
                    ->select(DB::raw('count(id) as presence_count'))->get();

        if ($countSchedules[0]->schedule_count == $countPresences[0]->presence_count) {
            //consulta si el profesor ya fue liquidado
            $teacherPay = TeacherPayment::where('lesson_id', $this->lessonId)->first();
            //valida si $teacherPay tiene registros, para confirmar que el profesor fue liquidado
            if ($teacherPay){
                //consulta para ver que está fuera del rango de los horario que ya existen
                $lesson = Lesson::where('id', $this->lessonId)->whereDate('end_date', '<=', $this->start_date)->first();
                //valida si $lesson tiene registros
                if ($lesson) {
                    //crear el horario
                    try {
                        DB::beginTransaction();
                        // Convertimos las fechas en Carbon para poder compararlas
                        $startDate = Carbon::parse($this->start_date);
                        $endDate = Carbon::parse($this->end_date);
            
                        // Iteramos por cada día de la semana seleccionado
                        foreach ($this->selectedDays as $day) {
                            // Empezamos desde la fecha de inicio para cada día seleccionado
                            $current_date = $startDate->copy();
            
                            // Iteramos mientras la fecha actual no haya superado la fecha de fin
                            while ($current_date <= $endDate) {
                                // Si el día de la semana coincide con el día seleccionado
                                if ($current_date->dayOfWeek === intval($day)) {
                                    // Creamos la clase en la tabla schedule, asociada a la lesson
                                    $schedule = Schedule::create([
                                        'lesson_id' => $this->lessonId,
                                        'teacher_id' => $this->teacherId,
                                        'day' => $current_date->dayOfWeek,
                                        'start_time' => $this->start_time,
                                        'end_time' => $this->end_time,
                                        'capacity' => $this->capacity,
                                        'date' => $current_date->format('Y-m-d'),
                                    ]);
                                }
                                // Avanzamos al siguiente día
                                $current_date->addDay();
                            }
                        }
                        //modificar la fecha fin de la clase
                        $lesson->update([
                            'end_date'=> $this->end_date
                        ]);
            
                        DB::commit();
                        $this->updateLessons();
                        $this->reset(['name','description','duration','capacity','start_date','end_date','state_id','teacherId','selectedDays','start_time','end_time']);
                        $this->dispatch('mostrarAlerta', mensaje: 'Horario reagendado correctamente.', tipo: 'success');
                    } catch (\Exception $th) {
                        DB::rollback();
                        $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::LESSON_OTHER_ERROR), tipo: 'error', code: ErrorCodes::LESSON_OTHER_ERROR);
                        $this->reset(['name', 'description', 'duration', 'capacity', 'start_date', 'end_date', 'state_id', 'teacherId', 'selectedDays', 'start_time', 'end_time']);
                    }
                }else{
                    $this->dispatch('mostrarAlerta', mensaje: 'No se puede agregar horarios, revise las fechas de inicio y fin.', tipo: 'error');
                }
            }else{
                $this->dispatch('mostrarAlerta', mensaje: 'No se puede agregar horarios a una clase que no ha sido liquidada.', tipo: 'error');
            }
        }else{
            $this->dispatch('mostrarAlerta', mensaje: 'No se puede agregar horarios a una clase que ya tiene horarios programados.', tipo: 'error');
        }
    }

    //funcion para actualizar la lista de clases
    public function updateLessons()
    {
        $sessionUser = auth()->user()->id;

        if (User::find($sessionUser)->hasRole('Estudiante')) {
            //traer las clases del estudiante
            //$this->lessons = ClaseUser::with('user')->with('Estudiante')->get();
            $this->lessons = Lesson::inscriptionsByStudent($sessionUser);
        }
        if (User::find($sessionUser)->hasRole('Profesor')) {
            $this->lessons = ClaseUser::where('user_id', $sessionUser )->with('teachers')->get();
        }
        if (User::find($sessionUser)->hasRole('SuperAdmin')) {
            $this->lessons = Lesson::with('teachers','academy')->get(); //trae todas las clases
        }
        else if (User::find($sessionUser)->hasRole('Administrador')){

            // Obtener la academia asociada al usuario
            $academyId = AcademyUser::where('user_id', $sessionUser)->first()->academy_id;

            // Obtener todas las lecciones activas de la academia con sus horarios y profesores asociados
            $this->lessons = Lesson::where('academy_id', $academyId)
                ->where('state', 1) // Solo clases activas
                ->with('schedules.teachers') // Cargar los horarios y los profesores de esos horarios
                ->get();

                if($this->lessons->isNotEmpty()){
                //recorre las clases y extraer los profesores
                foreach ($this->lessons as $lesson) {
                    //guardar dentro de los atributos de cada clase los profesores
                    $lesson->teachers = $lesson->schedules->pluck('teachers')->flatten()->unique('id');

                    // Agregar la lección procesada al array de lecciones
                    $processedLessons[] = $lesson; // Agrega la lección procesada al array
                }
        
                // Ahora asigna el array procesado a $this->lessons
                $this->lessons = $processedLessons;
                }  
        }
    }

    public function addDay()
    {
        $this->selectedDays[] = null; // Agrega un campo vacío al array de días seleccionados
    }

    public function removeDay($index)
    {
        unset($this->selectedDays[$index]); // Elimina el día del array según su índice
        $this->selectedDays = array_values($this->selectedDays); // Reindexa el array después de eliminar el elemento
    }

    public function render()
    {
        return view('livewire.lessons');
    }
}
