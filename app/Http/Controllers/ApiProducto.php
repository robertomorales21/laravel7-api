<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ProductoModel;
use App\Http\Resources\Producto as ProductoResource;

class ApiProducto extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $productos = ProductoModel::all();

        if(!empty($productos)) {
            return response()->json(array('data' => $productos), 200);
        } else {
            return response()->json(array('data' => 'No se encontraron registros'), 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $producto = new ProductoModel();
        $producto->nombre = trim($request->nombre);
        $producto->cantidad = trim($request->cantidad);
        $producto->precio = trim($request->precio);
        $producto->estado = true;

        if(!empty($producto->nombre) && !empty($producto->cantidad) && !empty($producto->precio)) {
            $producto->save();
            return response()->json(array('Mensaje' => 'Registro creado exitosamente'), 201);
        } else {
            return response()->json(array('Error' => 'Ningún campo puede quedar vacío'), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $producto = ProductoModel::find($id);

        if($producto) {
            return response()->json(array('data' => $producto), 200);
        } else {
            return response()->json(array('Error' => 'No se pudo encontrar el recurso. Es posible que el ID sea incorrecto. Id='.$id), 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if(!empty(trim($id))) {
            $producto = ProductoModel::find($id);

            if($producto) {
                $producto->nombre = trim($request->nombre);
                $producto->cantidad = trim($request->cantidad);
                $producto->precio = trim($request->precio);
                $producto->estado = $request->estado;

                if(!empty($producto->nombre) && !empty($producto->cantidad) && !empty($producto->precio) && !empty($producto->estado)) {
                    $producto->save();
                    return response()->json(array('Mensaje' => 'Registro actualizado con exito.'), 200);
                } else {
                    return response()->json(array('Error' => 'Los campos no pueden quedar vacíos'), 400);
                }
            } else {
                return response()->json(array('Error' => 'El registro solicitado no existe. Id='.$id), 404);
            }
        } else {
            return response()->json(array('Error' => 'No puedes enviar un id vacío'), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        switch (trim($id)) {
            case empty($id):
                    return response()->json(array('Error' => 'No puedes enviar un id vacío.'), 400);
                break;
            case empty($producto = ProductoModel::find($id)):
                    return response()->json(array('Mensaje' => 'El registro solicitado no existe'), 404);
                break;
            default:
                    $producto->delete();
                    return response()->json(array('Mensaje' => 'Registro eliminado exitosamente.', 'data' => $producto), 200);
                break;
        }
    }
}
