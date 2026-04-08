<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    public function index()
    {
        try {
            $productos = Producto::with(['marca', 'categoria'])
                ->orderBy('id', 'desc')
                ->get();

            return response()->json($productos, 200);

        } catch (\Exception $e) {
            Log::error('Error en ProductoController@index: ' . $e->getMessage());

            return response()->json([
                'message' => 'Error al obtener la lista de productos.'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre'       => 'required|string|max:80|unique:productos,nombre',
                'descripcion'  => 'required|string|max:200',
                'precio'       => 'required|numeric|min:0',
                'stock'        => 'required|integer|min:0',
                'modelo'       => 'required|string|max:50',
                'marca.id'     => 'required|exists:marcas,id',
                'categoria.id' => 'required|exists:categorias,id',
                'activo'       => 'required|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Errores de validación',
                    'errors'  => $validator->errors()
                ], 422);
            }

            $data = [
                'nombre'       => $request->input('nombre'),
                'descripcion'  => $request->input('descripcion'),
                'precio'       => $request->input('precio'),
                'stock'        => $request->input('stock'),
                'modelo'       => $request->input('modelo'),
                'marca_id'     => $request->input('marca.id'),
                'categoria_id' => $request->input('categoria.id'),
                'activo'       => $request->input('activo'),
            ];

            $producto = Producto::create($data);

            return response()->json([
                'message'  => 'Producto creado exitosamente',
                'producto' => $producto
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error en ProductoController@store: ' . $e->getMessage());

            return response()->json([
                'message' => 'Error al crear el producto.'
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
