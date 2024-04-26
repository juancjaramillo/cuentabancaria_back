<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    use HasFactory;


    public $table = "procesos";
    protected $fillable= array("*");

    public function clientes (){
        return $this->belongsToMany(Cliente::class,"proceso_cliente");
        }


}
