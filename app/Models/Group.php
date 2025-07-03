<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    protected $table = "groups_";
    protected $primaryKey = "id";
    protected $name;
    protected $idParent;
    public function products(): HasMany {
        return $this->hasMany(Product::class,"id_group","id");
    }

    public function parent() {
        return $this->belongsTo(Group::class, 'id_parent', 'id');
    }

    public function children() {
        return $this->hasMany(Group::class,'id_parent','id');
    }

    public function ancestors() {
        return $this->parent()->with('ancestors');
    }
}