<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use App\Models\Presence;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Enums\ErrorCodes;

class Schedules extends Component
{
    public $id;
    public $lesson_id;
    public $day;
    public $start_time;
    public $end_time;
    public $capacity;
    public $date;
    public $teacherId;
    public $schedules;
    public $teachers;

    public $toEdit = false;
    public $toPresence = false;
    public $selectedDays = []; // Para almacenar los días seleccionados
    public $month; 

    public function mount()
    {
        $this->updateSchedules();

        $this->teachers = User::whereHas('roles', function($q){
            $q->where('name', 'Profesor');
        })->get();
    }

    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    public function edit($id)
    {
        $this->toPresence = false;
        $schedule = Schedule::findOrFail($id);
        $this->id = $schedule->id;  
        $this->lesson_id = $schedule->lesson_id;
        $this->day = $schedule->day;
        $this->start_time = $schedule->start_time;
        $this->end_time = $schedule->end_time;
        $this->capacity = $schedule->capacity;
        $this->date = $schedule->date;
        $this->teacherId = $schedule->teachers->pluck('id')->toArray();

        $this->toEdit = true;
    }

    public function presence($scheduleId)
    {
        $this->toEdit = false;
        $schedule = Schedule::findOrFail($scheduleId);

        $this->id = $schedule->id;  
        $this->lesson_id = $schedule->lesson_id;
        $this->day = $schedule->day;
        $this->start_time = $schedule->start_time;
        $this->end_time = $schedule->end_time;
        $this->capacity = $schedule->capacity;
        $this->date = $schedule->date;
        $this->teacherId = $schedule->teachers->pluck('id')->toArray();

        $this->toPresence = true;
    }

    //funcion para hacer el registro de la clase dicatada por el profesor en la tabla presences
    public function togglePresence()
    {
        try{
            DB::beginTransaction();
            $schedule = Schedule::findOrFail($this->id);

            //valida si el profesor es el mismo que el que dicta la clase, si no lo es lo actualiza
            if($schedule->teachers->pluck('id')->toArray() <> $this->teacherId){
                $schedule->teachers()->sync($this->teacherId);
            }
    
            $presence = Presence::create([
                'schedule_id' => $this->id,
                'teacher_id' => $this->teacherId[0],
                'status' => 1
            ]);
    
            DB::commit();
            $this->toPresence = false;
            $this->reset(['day', 'start_time', 'end_time', 'capacity', 'date', 'teacherId']);
            $this->updateSchedules();
            $this->dispatch('mostrarAlerta', mensaje: 'Clase dictada correctamente.', tipo: 'success');
        }
        catch(\Exception $e){
            DB::rollBack();
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::SCHEDULE_OTHER_ERROR), tipo: 'error', code: ErrorCodes::SCHEDULE_OTHER_ERROR);
            $this->reset(['day', 'start_time', 'end_time', 'capacity', 'date', 'teacherId']);
        }
    }

    public function update()
    {
        try{
            DB::beginTransaction();
            $this->validate([
                'day' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'capacity' => 'required',
                'date' => 'required',
                'teacherId' => 'required'
            ]);
    
            $schedule = Schedule::findOrFail($this->id);
            $schedule->update([
                'day' => $this->day,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'capacity' => $this->capacity,
                'date' => $this->date,
                'teacher_id' => $this->teacherId
            ]);
    
            DB::commit();
            $this->toEdit = false;
            $this->reset(['day', 'start_time', 'end_time', 'capacity', 'date', 'teacherId']);
            $this->updateSchedules();
            $this->dispatch('mostrarAlerta', mensaje: 'Clase actualizada correctamente.', tipo: 'success');
        }
        catch(\Exception $e){
            DB::rollBack();
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::SCHEDULE_UPDATE_ERROR), tipo: 'error', code: ErrorCodes::SCHEDULE_UPDATE_ERROR);
            $this->reset(['day', 'start_time', 'end_time', 'capacity', 'date', 'teacherId']);
        }
    }

    public function updateSchedules(){
        $sessionUser = auth()->user()->id;

        if (User::find($sessionUser)->hasRole('Estudiante')) {

        }
        if (User::find($sessionUser)->hasRole('Profesor')) {

        }
        if (User::find($sessionUser)->hasRole('SuperAdmin')) {

        }
        else if (User::find($sessionUser)->hasRole('Administrador')){

            // Obtener todas las clases programadas del mes actual ordenadas por fecha, teniendo en cuenta el mes seleccionado en $month y sin registros en presences
            $this->schedules = Schedule::whereMonth('date', $this->month)
            ->whereDoesntHave('presences')
            ->orderBy('date')
            ->get();
            
        }
    }

    public function delete($id)
    {
        try{
            DB::beginTransaction();
            $schedule = Schedule::findOrFail($id);
            $schedule->delete();
            DB::commit();
            $this->updateSchedules();
            $this->dispatch('mostrarAlerta', mensaje: 'Clase eliminada correctamente.', tipo: 'success');
        }
        catch(\Exception $e){
            DB::rollBack();
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::SCHEDULE_DELETE_ERROR), tipo: 'error', code: ErrorCodes::SCHEDULE_DELETE_ERROR);
        }
    }

    public function render()
    {
        return view('livewire.schedules');
    }
}