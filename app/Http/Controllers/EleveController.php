<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Eleve;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EleveController extends Controller
{

    /**
     * Display a listing of the resource.
     */
     /**
     * Afficher la liste des élèves
     */
    public function index()
    {
        try {
            $eleves = Eleve::withTrashed()
                          ->with('user')
                          ->orderBy('created_at', 'desc')
                          ->get();

            return response()->json([
                'status' => true,
                'data' => $eleves,
                'message' => 'Liste des élèves récupérée avec succès'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la récupération des élèves',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enregistrer un nouvel élève
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'matricule' => 'required|string|max:50|unique:eleves,matricule',
            'date_naissance' => 'required|date|before:today',
            'email' => 'required|string|email|max:255|unique:eleves',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // Gestion de la photo si présente
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $fileName = time() . '_' . Str::slug($request->nom) . '_' . Str::slug($request->prenom) . '.' . $photo->getClientOriginalExtension();
                $photoPath = $photo->storeAs('photos/eleves', $fileName, 'public');
                $validatedData['photo'] = $photoPath;
            }

            // Ajout de l'user_id de l'utilisateur authentifié
            $validatedData['user_id'] = auth()->id();

            $eleve = Eleve::create($validatedData);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Élève créé avec succès',
                'data' => $eleve->load('user')
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();

            // Si une photo a été uploadée mais qu'il y a eu une erreur, on la supprime
            if (isset($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }

            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la création de l\'élève',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher un élève spécifique
     */
    public function show($id)
    {
        try {
            $eleve = Eleve::withTrashed()
                         ->with('user')
                         ->findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $eleve
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Élève non trouvé',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Mettre à jour un élève
     */
    public function update(Request $request, $id)
    {
        try {
            $eleve = Eleve::withTrashed()->findOrFail($id);

            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'adresse' => 'required|string|max:255',
                'telephone' => 'required|string|max:20',
                'matricule' => ['required', 'string', 'max:50', Rule::unique('eleves')->ignore($id)],
                'date_naissance' => 'required|date|before:today',
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('eleves')->ignore($id)],
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            DB::beginTransaction();

            // Gestion de la photo
            if ($request->hasFile('photo')) {
                // Supprimer l'ancienne photo si elle existe
                if ($eleve->photo) {
                    Storage::disk('public')->delete($eleve->photo);
                }

                $photo = $request->file('photo');
                $fileName = time() . '_' . Str::slug($request->nom) . '_' . Str::slug($request->prenom) . '.' . $photo->getClientOriginalExtension();
                $photoPath = $photo->storeAs('photos/eleves', $fileName, 'public');
                $validatedData['photo'] = $photoPath;
            }

            $eleve->update($validatedData);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Élève mis à jour avec succès',
                'data' => $eleve->fresh('user')
            ]);

        } catch (Exception $e) {
            DB::rollBack();

            // Si une nouvelle photo a été uploadée mais qu'il y a eu une erreur, on la supprime
            if (isset($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }

            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la mise à jour de l\'élève',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un élève (soft delete)
     */
    public function destroy($id)
    {
        try {
            $eleve = Eleve::findOrFail($id);
            $eleve->delete();

            return response()->json([
                'status' => true,
                'message' => 'Élève supprimé avec succès'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la suppression de l\'élève',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restaurer un élève supprimé
     */
    public function restore($id)
    {
        try {
            $eleve = Eleve::onlyTrashed()->findOrFail($id);
            $eleve->restore();

            return response()->json([
                'status' => true,
                'message' => 'Élève restauré avec succès'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la restauration de l\'élève',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
