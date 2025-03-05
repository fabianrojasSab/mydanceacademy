<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\StudentLesson;
use App\Models\User;
use App\Models\Lesson;
use App\Models\AcademyUser;
use Illuminate\Support\Facades\DB;

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
        })->get();;

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
            dd($th);
        }
    }

    public function edit($id)
    {
        $inscription = StudentLesson::findOrFail($id);

        $this->inscriptionId = $inscription->id;
        $this->inscription_date = $inscription->inscription_date;
        $this->lesson_id = $inscription->lesson_id;
        $this->student_id = $inscription->user_id;
    }

    public function update()
    {
        try {
            DB::beginTransaction();
            $inscription = ClaseUser::findOrFail($this->inscriptionId);
            $inscription->update([
                'inscription_date' => $this->inscription_date,
                'lesson_id' => $this->lesson_id,
                'user_id' => $this->student_id
            ]);

            DB::commit();
            $this->updateInscriptions();
            $this->reset(['inscription_date','lesson_id','student_id']);
            $this->dispatch('mostrarAlerta', mensaje: 'Inscripción actualizada correctamente.', tipo: 'success');
        } catch (\Exception $th) {
            dd($th);
            DB::rollBack();
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
            dd($th);
            DB::rollBack();
        }
    }

    public function updateInscriptions()
    {
        $this->inscriptions = StudentLesson::with('lesson','student')->get();
    }

    public function render()
    {
        return view('livewire.inscriptions');
    }
}
