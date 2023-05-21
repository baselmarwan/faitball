<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academy extends Model
{
    use HasFactory;
    protected $fillable=['name','email','phone','user_id','location','rating','trainers_count','players_count'];
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeLikeName($query, $name)
    {
        return $query->where('name', 'like', '%'.$name.'%');
    }
    public function trainers()
    {
        return $this->hasMany(Trainer::class,'academy_id');
    }
    public function players()
    {
        return $this->hasMany(Players::class,'academy_id');
    }
}
