<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EleveController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retourne tous les élèves, y compris ceux supprimés (soft deleted)
        return Eleve::withTrashed()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'matricule' => 'required|string|max:50',
            'date_naissance' => 'required|date',
            'email' => 'required|string|email|max:255|unique:eleves',
            'photo' => 'nullable|string',
            // Ajoutez d'autres règles de validation selon vos besoins
        ]);

        // Ajouter l'user_id de l'utilisateur authentifié
        $validatedData['user_id'] = auth()->id(); // Utilisez JWT pour obtenir l'ID de l'utilisateur

        // Tenter de créer l'étudiant (Eleve)
        try {
            DB::beginTransaction();

            $eleve = Eleve::create($validatedData);

            DB::commit();

            return response()->json([
                'status' => true,
                'data' => $eleve,
                'message' => 'Étudiant créé avec succès',
            ], 201);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la création de l\'étudiant : ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Trouver l'étudiant, y compris ceux supprimés
        $eleve = Eleve::withTrashed()->find($id);

        if (!$eleve) {
            return response()->json(['message' => 'Étudiant non trouvé'], 404);
        }

        return response()->json($eleve);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'matricule' => 'required|string|max:50',
            'date_naissance' => 'required|date',
            'email' => 'required|string|email|max:255|unique:eleves,email,' . $id, // Ignorer l'e-mail actuel lors de la validation
            'photo' => 'nullable|string',
            // Ajoutez d'autres règles de validation selon vos besoins
        ]);

        try {
            DB::beginTransaction();

            // Trouver l'étudiant à mettre à jour
            $eleve = Eleve::withTrashed()->findOrFail($id);

            // Mettre à jour l'étudiant
            $eleve->update($validatedData);

            DB::commit();

            return response()->json([
                'status' => true,
                'data' => $eleve,
                'message' => 'Étudiant mis à jour avec succès',
            ], 200);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la mise à jour de l\'étudiant : ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Trouver l'étudiant à supprimer
            $eleve = Eleve::findOrFail($id);

            // Supprimer l'étudiant de la base de données (soft delete)
            $eleve->delete();

            return response()->json([
                'status' => true,
                'message' => 'Étudiant supprimé avec succès',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la suppression de l\'étudiant : ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        try {
            // Restaurer l'étudiant à partir de la suppression douce
            $eleve = Eleve::onlyTrashed()->findOrFail($id);
            $eleve->restore();

            return response()->json([
                'status' => true,
                'message' => 'Étudiant restauré avec succès',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la restauration de l\'étudiant : ' . $e->getMessage(),
            ], 500);
        }
    }
}
