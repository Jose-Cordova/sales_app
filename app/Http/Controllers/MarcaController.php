<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Marca;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $marcas = Marca::orderBy('id', 'desc')->get();

            return response()->json([
                'marcas' => $marcas
            ], 200);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Error al obtener las marcas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate(
                [
                    'nombre' => 'required|string|min:2|max:80|unique:marcas,nombre'
                ],
                [
                    'nombre.unique' => 'Ya existe una marca con este nombre.'
                ]
            );

            $marca = Marca::create([
                'nombre' => $request->nombre
            ]);
            return response()->json([
                'message' => 'Marca registrada correctamente',
                'marca' => $marca
            ], 201);

        }catch(ValidationException $e){
            return response()->json([
                'message' => 'Error de validacion.',
                'errores' => $e->errors()
            ], 422);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Error interno en el servidor.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
