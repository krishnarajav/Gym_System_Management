<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $table = 'Trainers';
    protected $fillable = ['id', 't_id', 'name', 'dob', 'age', 'gender', 'experience', 'address', 'mobile', 'salary'];
}
