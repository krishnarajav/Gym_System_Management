<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'Equipments';
    protected $fillable = ['id', 'e_id', 'name', 'brand', 'serial', 'purchased_date', 'price'];
}