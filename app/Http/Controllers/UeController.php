<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUeRequest;
use App\Http\Requests\UpdateUeRequest;
use App\Models\Ue;

class UeController extends Controller
{
    
    public function index()
    {
        try {
            // Récupérer toutes les U.E.
            $ues = UE::all();

            return response()->json([
                'status' => true,
                'data' => $ues,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la récupération des U.E. : ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Crée une nouvelle unité d'enseignement.
     */
    public function store(Request $request)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'matiere_id' => 'required|exists:matieres,id',
                'libelle' => 'required|string|max:255',
                'coef' => 'required|integer|min:1',
                'date_debut' => 'required|date',
                'date_fin' => 'required|date|after_or_equal:date_debut',
            ]);

            // Création de l'unité d'enseignement
            $ue = UE::create($validatedData);

            return response()->json([
                'status' => true,
                'data' => $ue,
                'message' => 'Unité d\'enseignement créée avec succès',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la création de l\'unité d\'enseignement : ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Affiche une unité d'enseignement spécifique.
     */
    public function show(UE $ue)
    {
        try {
            return response()->json([
                'status' => true,
                'data' => $ue,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la récupération de l\'unité d\'enseignement : ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Met à jour une unité d'enseignement existante.
     */
    public function update(Request $request, UE $ue)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'matiere_id' => 'sometimes|required|exists:matieres,id',
                'libelle' => 'sometimes|required|string|max:255',
                'coef' => 'sometimes|required|integer|min:1',
                'date_debut' => 'sometimes|required|date',
                'date_fin' => 'sometimes|required|date|after_or_equal:date_debut',
            ]);

            // Mettre à jour l'unité d'enseignement
            $ue->update($validatedData);

            return response()->json([
                'status' => true,
                'data' => $ue,
                'message' => 'Unité d\'enseignement mise à jour avec succès',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la mise à jour de l\'unité d\'enseignement : ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Supprime une unité d'enseignement spécifique.
     */
    public function destroy(UE $ue)
    {
        try {
            // Supprimer l'unité d'enseignement
            $ue->delete();

            return response()->json([
                'status' => true,
                'message' => 'Unité d\'enseignement supprimée avec succès',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la suppression de l\'unité d\'enseignement : ' . $e->getMessage(),
            ], 500);
        }
    }
}
