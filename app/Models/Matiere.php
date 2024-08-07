<?php

namespace App\Models;

use App\Models\Ue;
use App\Models\Evaluation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matiere extends Model
{

    protected $guarded= [];
    use HasFactory;
    public function ues()
    {
        return $this->hasMany(Ue::class); // Relation inverse : Matiere a plusieurs UeS
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class); // Matiere a plusieurs Evaluations
    }
}
