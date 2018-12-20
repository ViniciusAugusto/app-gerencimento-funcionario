<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = ['nome','sexo','idade','tipo', 'linguagem', 'projeto'];
    protected $guarded = ['id'];
    protected $table = 'person';
}