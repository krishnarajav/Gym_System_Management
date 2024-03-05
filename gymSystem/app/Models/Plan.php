<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'Plans';
    protected $fillable = ['id', 'p_id', 'name', 'period', 'price'];
}