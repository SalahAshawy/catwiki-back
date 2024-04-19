<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatBreed extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'description',
        'temperament',
        'origin',
        'life_span',
        'adaptability',
        'affection_level',
        'child_friendly',
        'grooming',
        'intelligence',
        'health_issues',
        'social_needs',
        'stranger_friendly',
        'search_count',
    ];
   
    public function image ()
    {
        return $this->hasMany(CatBreedsImage::class);
    }
}
