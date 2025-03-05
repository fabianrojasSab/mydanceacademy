<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\StudentLesson;
use App\Models\User;
use App\Models\Lesson;
use App\Models\AcademyUser;
use Illuminate\Support\Facades\DB;
use App\Enums\ErrorCodes;

class Inscriptions extends Component
{
    public $id;
    public $inscription_date;
    public $lesson_id;
    public $student_id;
    public $inscriptions;
    public $inscriptionId;
    public $students;
    public $lessons;

    public function mount()
    {
        $sessionUser = auth()->user()->id;
        // Obtener la academia asociada al usuario
        $academyId = AcademyUser::where('user_id', $sessionUser)->first()->academy_id;

        $this->students = User::role('Estudiante')->whereHas('state', function ($query) {
            $query->where('id', '1'); // Filtra para el estado activo
        })->whereHas('academyUsers.academy', function ($query) use ($academyId) {
            $query->where('id', $academyId); // Filtra por el ID de la academia específica
        })
        ->with('academyUsers.academy', 'state')
        ->get();

        $this->lessons = Lesson::where('academy_id', $academyId)
        ->where('state', 1) // Solo clases activas
        ->get();
        $this->updateInscriptions();
    }

    public function delete($id)
    {
        try {
            StudentLesson::where('id',$id)->delete();
            return $this->redirect('/ncp/r',navigate:true); 
        } catch (\Exception $th) {
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::INSCRIPTION_DELETE_ERROR), tipo: 'error', code: ErrorCodes::INSCRIPTION_DELETE_ERROR);
        }
    }

    public function edit($id)
    {
        $inscription = StudentLesson::findOrFail($id);

        $this->inscriptionId = $inscription->id;
        $this->inscription_date = $inscription->inscription_date;
        $this->lesson_id = $inscription->lesson_id;
        $this->student_id = $inscription->student_id;
    }

    public function update()
    {
        try {
            DB::beginTransaction();
            $inscription = StudentLesson::findOrFail($this->inscriptionId);
            $inscription->update([
                'inscription_date' => $this->inscription_date,
                'lesson_id' => $this->lesson_id,
                'student_id' => $this->student_id
            ]);

            DB::commit();
            $this->updateInscriptions();
            $this->reset(['inscription_date','lesson_id','student_id']);
            $this->dispatch('mostrarAlerta', mensaje: 'Inscripción actualizada correctamente.', tipo: 'success');
        } catch (\Exception $th) {
            DB::rollBack();
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::INSCRIPTION_UPDATE_ERROR), tipo: 'error', code: ErrorCodes::INSCRIPTION_UPDATE_ERROR);
            $this->reset(['inscription_date','lesson_id','student_id']);
        }
    }

    public function save()
    {
        try {
            DB::beginTransaction();
            //valida si el estudiante ya esta inscrito en la clase
            $inscrito = StudentLesson::where('student_id', $this->student_id)
            ->where('lesson_id', $this->lesson_id)
            ->first();

            //si ya esta inscrito no lo deja inscribirse
            if($inscrito){
                $this->dispatch('mostrarAlerta', mensaje: 'El estudiante ya esta inscrito en esta clase.', tipo: 'error');
                DB::commit();
                return;
            }

            StudentLesson::create([
                'student_id' => $this->student_id,
                'lesson_id' => $this->lesson_id,
                'inscription_date' => now()
            ]);
            
            DB::commit();
            $this->updateInscriptions();
            $this->reset(['inscription_date','lesson_id','student_id']);
            $this->dispatch('mostrarAlerta', mensaje: 'Estudiante inscrito correctamente.', tipo: 'success');
        } catch (\Exception $th) {
            DB::rollBack();
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::INSCRIPTION_CREATE_ERROR), tipo: 'error', code: ErrorCodes::INSCRIPTION_CREATE_ERROR);
            $this->reset(['inscription_date','lesson_id','student_id']);
        }
    }

    public function updateInscriptions()
    {
        $sessionUser = auth()->user()->id;

        if (User::find($sessionUser)->hasRole('Estudiante')) {

        }
        if (User::find($sessionUser)->hasRole('Profesor')) {

        }
        if (User::find($sessionUser)->hasRole('SuperAdmin')) {

        }
        else if (User::find($sessionUser)->hasRole('Administrador')){

            //consulta las inscripcion de los estudiantes de la academia del usuario que inicia sesion
            $sessionUser = auth()->user()->id;
            $academyId = AcademyUser::where('user_id', $sessionUser)->first()->academy_id;
            $this->inscriptions = StudentLesson::whereHas('student', function ($query) {
                $query->where('state_id', 1); // Filtra para el estado activo
            })->whereHas('lesson', function ($query) use ($academyId) {
                $query->where('academy_id', $academyId); // Filtra por el ID de la academia específica
            })->with('student', 'lesson')->get();
        }
    }

    public function render()
    {
        return view('livewire.inscriptions');
    }
}
