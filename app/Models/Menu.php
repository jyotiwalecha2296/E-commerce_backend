<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['title','parent_id','order'];

    public function childs() {
        return $this->hasMany('App\Models\Menu','parent_id','id')->orderBy('order','ASC') ;
    }
    public function getChilds() {
        return $this->hasMany('App\Models\Menu','parent_id','id') ;
    }
    public function getType() {
        return $this->belongsTo('App\Models\MenuType','menu_type') ;
    }
}
