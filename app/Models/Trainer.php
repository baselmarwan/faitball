<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'level_of_training',
        'academy_id',
    ];
    public function scopeLikeName($query, $searchTerm)
    {
        return $query->where('name', 'LIKE', '%' . $searchTerm . '%');
    }
    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }
}
