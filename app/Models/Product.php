<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $table = "products";
    protected $primaryKey = "id";
    protected $name;

    protected $atributes = [
        "id_group" => 0,
    ];

    public function price (): HasOne {
        return $this->hasOne(Price::class, "id_product", "id");
    }
    public function group(){
        return $this->belongsTo(Group::class, 'id_group', 'id');
    }

}

