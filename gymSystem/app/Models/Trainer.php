<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $table = 'Trainers';
    protected $fillable = ['id', 't_id', 'experience', 'salary'];

    public function personaldetails()
    {
        return $this->hasOne(Personal_Details::class, 't_id', 't_id');
    }
}
