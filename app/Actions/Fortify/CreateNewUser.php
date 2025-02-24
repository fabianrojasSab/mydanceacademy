<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        //validacion del rol, si es 3 o 2, si es 3(estudiante) se debe asignar a la variable estado_id el valor 1(activo)
        $state_id = $input['rol_id'] == 'Estudiante' ? 1 : 3;

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'date_of_birth' => $input['date_of_birth'],
            'phone' => $input['phone'],
            'state_id' => $state_id,
            'password' => Hash::make($input['password'])
        ]);

        $user->assignRole($input['rol_id']);

        return $user;
    }
}
