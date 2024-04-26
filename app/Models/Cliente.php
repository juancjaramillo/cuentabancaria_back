<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    public $table = "clientes";
    protected $fillable= [
    'nombre', 
    'apellido', 
    'documento', 
    'numero_cuenta', 
    'foto', 
    'direccion',
    'longitud',
    'latitud',
	'email',
	'password',
    'saldo',  
    'tipo',
    'id'   

    ];

    public function procesos (){
    return $this->belongsToMany(Proceso::class,"proceso_cliente");
    }
}
