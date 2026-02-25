<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function interests()
    {
        return $this->belongsToMany(Interest::class);
    }
}
