<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbTemp extends Model
{
    protected $fillable = ['name','phone'];
    protected $table = 'pbtemps';
    public $timestamps = false; 
}
