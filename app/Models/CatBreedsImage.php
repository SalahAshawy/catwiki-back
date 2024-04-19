<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatBreedsImage extends Model
{
    use HasFactory;
    protected $fillable = [
       'image',
       'cat_breed_id' ,
    ];
    public function image ()
    {
        return $this->belongsTo(CatBreed::class);
    }
}
