<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $fillable = ['t_id', 'passwd', 'name', 'dob', 'age', 'gender', 'experience', 'address', 'mobile', 'salary'];
}
