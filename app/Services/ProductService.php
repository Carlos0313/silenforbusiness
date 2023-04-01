<?php

namespace App\Services;

use App\Models\Product;
use Exception;

class ProductService
{
    public function getProducts($data){

        $productos = Product::where('activo',1)
        ->Nombre($data['nombre'])
        ->SKU($data['sku'])
        ->Rango($data['rango']['min'], $data['rango']['max'])
        ->orderBy('nombre', 'ASC')
        ->get();
        
        return $productos;
    }

    public function createProduct(array $data){

        $sku = $this->generateSKU($data['nombre']);
        $data['sku'] = $sku;

        $producto = Product::create($data);

        if(is_null($producto)) throw new Exception("Error al Crear Producto", 500);

        return $producto;
    }

    public function updateProduct(array $data){
        $producto = Product::find($data['product_id']);

        if(is_null($producto)) throw new Exception("No existe el Producto que intenta actualizar", 400);
        if($producto->activo != 1) throw new Exception("Este Producto ya ha sido removido de la lista", 400);


        $sku = $this->generateSKU($data['nombre']);
        $data['sku'] = $sku;

        $producto->fill($data);
        $producto->save();

        if(is_null($producto)) throw new Exception("Error al Actualizar Producto", 500);

        return $producto;
    }

    public function deleteProduct(int $product_id){
        $producto = Product::find($product_id);

        if(is_null($producto)) throw new Exception("No existe el Producto que intenta eliminar", 400);
        if($producto->activo != 1) throw new Exception("Este Producto ya ha sido removido de la lista", 400);

        $producto->update(['activo'=> 0]);

        return true;
    }
    

    // Private Funtions
    private function generateSKU($nombre){
        $prefijo = 'pro-';
        $numero_aleatorio = $this->generarCodigo(3);
        $ultimas_letras = substr($nombre,-3);

        $sku = $prefijo.$numero_aleatorio.$ultimas_letras;

        return $sku;
    }

    function generarCodigo($longitud){
        $llave = '';
        $patron = '1234567890';
        $max = strlen($patron)-1;
        for($i=0;$i < $longitud;$i++){ 
            $llave .= $patron[mt_rand(0,$max)];
        }

        return $llave;
    }   

}