<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    // Tentukan kolom yang boleh diisi secara mass assignment
    protected $fillable = ['name', 'gender', 'birth_place', 'birth_date', 'no_ktp', 'height', 'weight', 'phone', 'email'];
}
