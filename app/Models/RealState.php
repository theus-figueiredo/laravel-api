<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{

    protected $table = 'real_state';
    protected $fillable = ['user_id', 'title', 'description', 'content', 'price', 'slug', 'bathrooms', 'bedrooms', 'property_area', 'total_area'];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
