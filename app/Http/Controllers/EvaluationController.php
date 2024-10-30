<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\UpdateEvaluationRequest;

class EvaluationController extends Controller
{

    public function index()
    {
        try {
            $evaluations = Evaluation::with(['matiere', 'eleve'])->get();

            return response()->json([
                'status' => true,
                'data' => $evaluations,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la récupération des évaluations : ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Crée une nouvelle évaluation.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'matiere_id' => 'required|exists:matieres,id',
                'eleve_id' => 'required|exists:eleves,id',
                'date' => 'required|date',
                'valeurs' => 'required|integer|min:0',
            ]);

            $evaluation = Evaluation::create($validatedData);

            return response()->json([
                'status' => true,
                'data' => $evaluation,
                'message' => 'Évaluation créée avec succès',
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la création de l\'évaluation : ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Affiche une évaluation spécifique avec ses relations.
     */
    public function show(Evaluation $evaluation)
    {
        try {
            $evaluation->load(['matiere', 'eleve']);

            return response()->json([
                'status' => true,
                'data' => $evaluation,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la récupération de l\'évaluation : ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Met à jour une évaluation existante.
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        try {
            $validatedData = $request->validate([
                'matiere_id' => 'sometimes|required|exists:matieres,id',
                'eleve_id' => 'sometimes|required|exists:eleves,id',
                'date' => 'sometimes|required|date',
                'valeurs' => 'sometimes|required|integer|min:0',
            ]);

            $evaluation->update($validatedData);

            return response()->json([
                'status' => true,
                'data' => $evaluation,
                'message' => 'Évaluation mise à jour avec succès',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la mise à jour de l\'évaluation : ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Supprime une évaluation spécifique.
     */
    public function destroy(Evaluation $evaluation)
    {
        try {
            $evaluation->delete();

            return response()->json([
                'status' => true,
                'message' => 'Évaluation supprimée avec succès',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la suppression de l\'évaluation : ' . $e->getMessage(),
            ], 500);
        }
    }
}
