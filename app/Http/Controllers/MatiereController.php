<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreMatiereRequest;
use App\Http\Requests\UpdateMatiereRequest;

class MatiereController extends Controller
{
    /**
     * Constructeur avec middleware pour l'authentification API.
     */

    /**
     * Récupère toutes les matières.
     */
    public function index()
    {
        try {
            // Récupérer toutes les matières
            $matieres = Matiere::all();

            return response()->json([
                'status' => true,
                'data' => $matieres,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la récupération des matières : ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Crée une nouvelle matière.
     */
    public function store(Request $request)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'libelle' => 'required|string|max:255',
                'date_debut' => 'required|date',
                'date_fin' => 'required|date|after_or_equal:date_debut',
            ]);

            // Ajouter l'user_id de l'utilisateur authentifié
            $validatedData['user_id'] = Auth::id();

            // Création de la matière
            $matiere = Matiere::create($validatedData);

            return response()->json([
                'status' => true,
                'data' => $matiere,
                'message' => 'Matière créée avec succès',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la création de la matière : ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Affiche une matière spécifique.
     */
    public function show(Matiere $matiere)
    {
        try {
            // Vérifier si l'utilisateur est autorisé à accéder à cette matière
            if (!Auth::id()) {
                return response()->json([
                    'status' => false,
                    'error_message' => 'Vous n\'êtes pas autorisé à accéder à cette matière.',
                ], 403);
            }

            return response()->json([
                'status' => true,
                'data' => $matiere,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la récupération de la matière : ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Met à jour une matière existante.
     */
    public function update(Request $request, Matiere $matiere)
    {
        try {
            // Vérifier si l'utilisateur est autorisé à modifier cette matière
            if (!Auth::id()) {
                return response()->json([
                    'status' => false,
                    'error_message' => 'Vous n\'êtes pas autorisé à modifier cette matière.',
                ], 403);
            }

            // Validation des données
            $validatedData = $request->validate([
                'libelle' => 'required|string|max:255',
                'date_debut' => 'required|date',
                'date_fin' => 'required|date|after_or_equal:date_debut',
            ]);

            // Mettre à jour la matière
            $matiere->update($validatedData);

            return response()->json([
                'status' => true,
                'data' => $matiere,
                'message' => 'Matière mise à jour avec succès',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la mise à jour de la matière : ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Supprime une matière spécifique.
     */
    public function destroy(Matiere $matiere)
    {
        try {
            // Vérifier si l'utilisateur est autorisé à supprimer cette matière
            if (!Auth::id()) {
                return response()->json([
                    'status' => false,
                    'error_message' => 'Vous n\'êtes pas autorisé à supprimer cette matière.',
                ], 403);
            }

            // Supprimer la matière
            $matiere->delete();

            return response()->json([
                'status' => true,
                'message' => 'Matière supprimée avec succès',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la suppression de la matière : ' . $e->getMessage(),
            ], 500);
        }
    }
}
