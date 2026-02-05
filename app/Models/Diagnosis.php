<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $table = 'diagnosis';

    protected $fillable = [
   'diag_code', 
   'diagnosis', 
   'treatment_plan',
   'cost'
             
  ];
}
