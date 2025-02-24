<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\AcademyFilter;
use App\Http\Requests\Api\V1\Store\StoreAcademyRequest;
use App\Http\Requests\Api\V1\Update\UpdateAcademyRequest;
use App\Http\Resources\Api\V1\Collections\AcademyCollection;
use App\Http\Resources\Api\V1\Resources\AcademyResource;
use App\Models\Academy;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AcademyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filter = new AcademyFilter();

        $queryItems = $filter->transform(request());

        $academies = Academy::where($queryItems)->paginate();

        $academyResource = new AcademyCollection($academies);

        if ($academyResource) {
            return response()->json($academyResource, 200);
        } else {
            return response()->json([
                'status' => 'Sin contenido'
            ], 204);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcademyRequest $request)
    {
        try {

            $validateData = $request->validated();

            $filter = new AcademyFilter();

            $mappedData = $filter->mapAndFilter($validateData);

            $academy = Academy::create($mappedData);
            $academyResource = new AcademyResource($academy);

            return response()->json($academyResource, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => 'Ocurrió un error inesperado',
                'details' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $academy = Academy::findOrFail($id);
            return new AcademyResource($academy);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => 'Academia no encontrada.',
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => 'Ocurrió un error inesperado.',
                'details' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAcademyRequest $request, string $id)
    {
        try {

            $validateData = $request->validated();
            $filter = new AcademyFilter();

            $mappedData = $filter->mapAndFilter($validateData);

            $academy = Academy::findOrFail($id);
            $academy->update($mappedData);

            $academyResource = new AcademyResource($academy);

            return response()->json($academyResource, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => 'Academia no encontrada.',
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => 'Ocurrió un error inesperado.',
                'details' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
