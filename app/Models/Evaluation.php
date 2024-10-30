<?php

namespace App\Models;

use App\Models\Eleve;
use App\Models\Matiere;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evaluation extends Model
{
    use HasFactory;
    protected $guarded= [];
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }
}

