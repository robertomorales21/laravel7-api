<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Clases importadas para el registro de usuarios
 */
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Hash;
//------------------------------------------------

use Illuminate\Support\Facades\Auth;


class ApiSecurity extends Controller
{
    /**
     * Recibe una peticion procedente del cliente
     * con los parametros para el registro de un nuevo usuario
     * 
     * @param Request $request
     * @return App\User
     */
    public function register(Request $request) {

        $validation = $this->validator($request->all());

        if($validation->fails()) {
            return response()->json([
                'data' => $validation->errors()
            ], 400);
        } else {
            $usuario = User::create([
                'name' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            if($usuario) {
                $token = $usuario->createToken('api-token')->plainTextToken;
                return response()->json(['data' => $usuario, 'token' => $token], 201);
            } else {
                return response()->json(['error' => 'Ha ocurrido un error con la solicitud'], 500);
            }
        }
    }

    private function validator(array $data) {

        $mensajes = [
            'nombre.required' => 'El campo nombre es requerido'
        ];

        $validator = Validator::make($data, [
            'nombre'    => ['required', 'string', 'max:200'],
            'email'     => ['required', 'string', 'email'],
            'password'  => ['required', 'string', 'min:8', 'confirmed']
        ], $mensajes);

        return $validator;
    }

    public function login(Request $request) {
        
        $mensajes = [
            'required'  => 'Este campo es obligatorio',
            'string'    => 'Este campo debe ser un texto',
            'min'       => 'El minimo de caracteres para la contraseña es de 8'
        ];

        $validacion = Validator::make($request->all(), [
            'nombre'    => ['required', 'string'],
            'password'  => ['required', 'string', 'min:8']
        ], $mensajes);

        if($validacion->fails()) {
            return response()->json(['error' => $validacion->errors()], 400);
        } else {
            $credenciales = ['name' => $request->nombre, 'password' => $request->password];

            if(Auth::attempt($credenciales)) {
                
                $usuario = User::where('name', $request->nombre)->first();
                $token = $usuario->createToken('api-token')->plainTextToken;

                return response()->json(['data' => $usuario, 'token' => $token], 200);
            } else {
                return response()->json(['error' => 'las credenciales no son correctas'], 400);
            }
        }
    }

    public function logout(Request $request) {

        $id = $request->id;
        $user = User::where('id', $id)->first();
        $user->tokens()->delete();

        return response()->json(['mensaje' => '¡Has cerrado sesion exitosamente!'], 200);
    }
}
