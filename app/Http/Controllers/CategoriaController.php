<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         try {
            $categorias = Categoria::orderBy('id', 'desc')->get();
            return response()->json($categorias, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las categorías.'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validamos que el nombre sea único y con restricciones
            $request->validate([
                'nombre' => [
                    'required',
                    'string',
                    'min:2',
                    'max:90',
                    'unique:categorias,nombre'
                ]
            ], [
                'nombre.unique' => 'Ya existe una categoría con ese nombre.'
            ]);

            $categoria = Categoria::create([
                'nombre' => $request->nombre
            ]);

            return response()->json([
                'message' => 'Categoría creada correctamente.',
                'categoria' => $categoria
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error interno en el servidor.'
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
