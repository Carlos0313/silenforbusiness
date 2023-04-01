<?php

namespace App\Http\Controllers;

use Throwable;
use Exception;
use Carbon\Carbon;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected ProductService $ProductService;

    public function __construct(ProductService $productService)
    {
        $this->ProductService = $productService;
    }

    public function getProducts(Request $request):JsonResponse
    {
        try{
            DB::beginTransaction();
                $data = $request->all();
                $productos = $this->ProductService->getProducts($data);
            
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
            "productos" => $productos
        ], 200);
    }

    public function createProduct(Request $request)
    {
        try{
            DB::beginTransaction();

                if($request->hasFile('imagen')){
                    $filename = $request->file('imagen')->store('/', 'productos');
                }

                $data = [
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'precio' => $request->precio,
                    'cantidad' => $request->cantidad,
                    'imagen' => $filename
                ];

                $producto = $this->ProductService->createProduct($data);

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
            "producto" => $producto
        ], 201);
    }

    public function updateProduct(Request $request, $product_id)
    {
        try{
            DB::beginTransaction();

                if($request->hasFile('imagen')){
                    $filename = $request->file('imagen')->store('/', 'productos');
                }

                $data = [
                    'product_id' => $product_id,
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'precio' => $request->precio,
                    'cantidad' => $request->cantidad,
                    'imagen' => $filename
                ];
                $producto = $this->ProductService->updateProduct($data);

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
            "producto_actualizado" => $producto
        ], 201);
    }

    public function deleteProduct($product_id):JsonResponse
    {
        try{
            DB::beginTransaction();
            
                $this->ProductService->deleteProduct($product_id);
            
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
            "message" => "Producto Eliminado Correctamente"
        ], 200);
    }
}
