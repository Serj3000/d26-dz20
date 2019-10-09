<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    static public function cat() {
        return $this->where('name','=','Features')->first();
    }
}
