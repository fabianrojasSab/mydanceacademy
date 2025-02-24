<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Filters\UserFilter;
use App\Http\Requests\Api\V1\Store\UserStoreRequest;
use App\Http\Requests\Api\V1\Update\UserUpdateRequest;
use App\Http\Resources\Api\V1\Collections\UserCollection;
use App\Http\Resources\Api\V1\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        try {

            $filter = new UserFilter();

            $queryItems = $filter->transform($request);
            // $usuarios = Usuarios::w
            $usuarios = User::where($queryItems)->paginate();
            //Roles y permisos
            $usuarios = User::with('roles')->paginate();


            $usuarioResource = new UserCollection($usuarios);

            if ($usuarioResource) {
                return response()->json($usuarioResource, 200);
            } else {
                return response()->json([
                    'status' => 'Sin contenido'
                ], 204);
            }
            // return response()->json($usuarioResource, 200, [], JSON_PRETTY_PRINT);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'page not found',
            ], 400);
        }
    }

    public function show(int $id)
    {
        try {

            $user = User::findOrFail($id);
            return new UserResource($user);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => 'Academia no encontrada.',
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => 'Ocurrió un error inesperado',
                'details' => $th->getMessage(),
            ], 500);
        }
    }


    public function store(UserStoreRequest $request)
    {
        try {

            $validateData = $request->validated();

            $filter = new UserFilter();

            $mappedData = $filter->mapAndFilter($validateData);


            $user = User::create($mappedData);
            //Asignamos el rol al usuario
            $user->assignRole($validateData['role']);
            $userResource = new UserResource($user);

            return response()->json($userResource, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => 'Ocurrió un error inesperado',
                'details' => $th->getMessage(),
            ], 500);
        }
    }


    public function update(UserUpdateRequest $request, int $id)
    {
        try {

            $validateData =   $request->validated();
            $filter = new UserFilter();

            $mappedData = $filter->mapAndFilter($validateData);

            //Recuperamos el usuario y lo actualizamos
            $user =  User::findOrFail($id);
            $user->update($mappedData);

            return new UserResource($user);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => 'Ocurrió un error inesperado',
                'details' => $th->getMessage(),
            ], 500);
        }
    }
}
