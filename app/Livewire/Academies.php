<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Academy;
use App\Models\State;

class Academies extends Component
{
    public $id;
    public $name;
    public $address;
    public $description;    
    public $phone;
    public $email;
    public $state_id;
    public $rating;
    public $created_at;
    public $updated_at;
    public $academies;
    public $academyId;
    public $states;

    public function mount()
    {
        $this->academies = Academy::all();
        $this->states = State::all();
    }
    
    public function delete($id)
    {
        try {
            Academy::where('id',$id)->delete();
            return $this->academies = Academy::all();
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        $academy = Academy::findOrFail($id);

        $this->academyId = $academy->id;
        $this->name = $academy->name;
        $this->address = $academy->address;
        $this->phone = $academy->phone;
        $this->description = $academy->description;
        $this->state_id = $academy->state_id;
        $this->email = $academy->email;
    }

    public function update()
    {
        try {
            Academy::where('id', $this->academyId)->update([
                'name' => $this->name,
                'address' => $this->address,
                'phone' => $this->phone,
                'description' => $this->description,
                'state_id' => $this->state_id,
                'email' => $this->email
            ]);

            $this->academies = Academy::all();
            $this->reset(['name', 'address', 'phone', 'description', 'state_id', 'email']);
            session()->flash('message', 'Academia actualizada correctamente.');

        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function save()
    {
        try {
            Academy::create([
                'name' => $this->name,
                'address' => $this->address,
                'phone' => $this->phone,
                'description' => $this->description,
                'state_id' => $this->state_id,
                'email' => $this->email,
                'created_at' => now(),
                'updated_at' => null,
                'rating' => 0
            ]);

            $this->academies = Academy::all();
            $this->reset(['name', 'address', 'phone', 'description', 'state_id', 'email']);
            session()->flash('message', 'Academia creada correctamente.');

        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function render()
    {
        return view('livewire.academies');
    }
}
