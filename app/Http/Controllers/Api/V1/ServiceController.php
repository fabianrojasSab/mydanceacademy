<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\ServiceFilter;
use App\Http\Requests\Api\V1\Store\StoreServiceRequest;
use App\Http\Requests\Api\V1\Update\UpdateServiceRequest;
use App\Http\Resources\Api\V1\Collections\ServiceCollection;
use App\Http\Resources\Api\V1\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filter = new ServiceFilter();

        $queryItems = $filter->transform(request());

        $services = Service::where($queryItems)->paginate();

        $serviceCollection = new ServiceCollection($services);

        if ($serviceCollection) {
            return response()->json($serviceCollection, 200);
        } else {
            return response()->json([
                'status' => 'Sin contenido'
            ], 204);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        try {
            $validated = $request->validated();

            $filter = new ServiceFilter();

            $mappedData = $filter->mapAndFilter($validated);

            $service = Service::create($mappedData);

            return response()->json(new ServiceResource($service), 201);
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
            $academy = Service::findOrFail($id);
            return new ServiceResource($academy);
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

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
