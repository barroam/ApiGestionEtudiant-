<?php

namespace App\Models;

use App\Models\User;
use App\Models\Evaluation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Eleve extends Model
{
    use HasFactory;
    protected $guarded= [];

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class); // Matiere a plusieurs Evaluations
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
