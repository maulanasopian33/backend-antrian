<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class antrian extends Model
{
    use HasApiTokens,HasFactory, Notifiable;
    protected $fillable = [
        'id_loket',
        'id_antrian',
        'status',
    ];
}
