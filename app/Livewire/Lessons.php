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

    public function mount()
    {
        $this->updateLessons();
        
        $this->teachers = User::whereHas('roles', function($q){
            $q->where('name', 'Profesor');
        })->get();
    }

    public function delete($id)
    {
        try {
            Lesson::where('id',$id)->delete();
            Schedule::where('lesson_id',$id)->delete();
            return $this->redirect('/lsn/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
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
            session()->flash('message', 'Clase inactivada correctamente.');
        } catch (\Exception $th) {
            dd($th);
            DB::rollback();
        }
    }

    public function edit($id)
    {
        //consulta la clase que se va a editar 
        $lesson = Lesson::where('id', $id)->first();
        //busca en la tabla schedule las clases que tengan el id de la clase
        $schedule = Schedule::where('lesson_id', $id)->first();

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
            session()->flash('message', 'Clase actualizada correctamente.');
        } catch (\Exception $th) {
            dd($th);
            DB::rollback();
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
            session()->flash('message', 'Clase creada correctamente.');
        } catch (\Exception $th) {
            dd($th);
            DB::rollback();
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
