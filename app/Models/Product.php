<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * [Product Model]
 * 
 * @property string $nombre
 * @property string $descripcion
 * @property string $sku
 * @property float|null $precio
 * @property int|null $cantidad
 * @property string|null $imagen
 * @property boolean|null $activo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $appends = ['imagen_producto_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'sku',
        'precio',
        'cantidad',
        'imagen',
        'activo'
    ];

    //Campos Virtuales
    public function getImagenProductoUrlAttribute():string
    {
        return Storage::disk('productos')->url($this->imagen);
    }

    public function scopeNombre($querry, $nombre)
    {
        if(!empty($nombre)){
            $querry->where([['nombre', 'like', "%$nombre%"]]);
        }
    }

    public function scopeSKU($querry, $sku)
    {
        if(!empty($sku)){
            $querry->where([['sku', 'like', "%$sku%"]]);
        }
    }

    public function scopeRango($querry, $min, $max)
    {
        if(!empty($min) && !empty($max)){
            $querry->where([['precio', '>=', $min]])
            ->where([['precio', '<=', $max]]);
        }else if(!empty($min)){
            $querry->where([['precio', '>=', $min]]);
        }else if(!empty($max)){
            $querry->where([['precio', '<=', $max]]);
        }
    }
}
