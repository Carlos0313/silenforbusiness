<?php

namespace App\Http\Controllers;

use Throwable;
use Exception;
use Carbon\Carbon;
use App\Services\UserService;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected UserService $UserService;

    public function __construct(UserService $userService)
    {
        $this->UserService = $userService;
    }

    public function login(Request $request):JsonResponse
    {

        try{
            DB::beginTransaction();
            
                $respuesta = $this->UserService->login($request->email, $request->password);
            
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();

            $code = $e->getCode() == 0 ? 500 : $e->getCode();

            if($code >= 500){
                return response()->json([
                    'res' => false,
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ], $code);
            }else{
                return response()->json([
                    'res' => false,
                    'message' => $e->getMessage()
                ], $code);
            }
        }

        return response()->json($respuesta, 200);
    }

    public function getUsers(Request $request)
    {
        try{
            DB::beginTransaction();

                $usuarios = $this->UserService->getUsers();
            
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();

            $code = $e->getCode() == 0 ? 500 : $e->getCode();

            if($code >= 500){
                return response()->json([
                    'res' => false,
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ], $code);
            }else{
                return response()->json([
                    'res' => false,
                    'message' => $e->getMessage()
                ], $code);
            }
        }

        return response()->json([
            "res" => true,
            "usuarios" => $usuarios
        ], 200);
    }

    public function createUser(CreateUserRequest $request):JsonResponse
    {

        try{
            DB::beginTransaction();
            
            $data_user = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ];
            $usuario = $this->UserService->createUser($data_user);
            
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();

            $code = $e->getCode() == 0 ? 500 : $e->getCode();

            if($code >= 500){
                return response()->json([
                    'res' => false,
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ], $code);
            }else{
                return response()->json([
                    'res' => false,
                    'message' => $e->getMessage()
                ], $code);
            }
        }

        return response()->json([
            "res" => true,
            "usuario" => $usuario
        ], 201);
    }

    public function deleteUser($user_id):JsonResponse
    {

        try{
            DB::beginTransaction();
            
                $this->UserService->deleteUser($user_id);
            
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();

            $code = $e->getCode() == 0 ? 500 : $e->getCode();

            if($code >= 500){
                return response()->json([
                    'res' => false,
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ], $code);
            }else{
                return response()->json([
                    'res' => false,
                    'message' => $e->getMessage()
                ], $code);
            }
        }

        return response()->json([
            "res" => true,
            "message" => "Usuario Eliminado Correctamente"
        ], 200);
    }
}