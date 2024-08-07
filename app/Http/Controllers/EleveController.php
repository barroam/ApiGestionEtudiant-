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
        //
        return Eleve::all();
    }


    /**
     * Store a newly created resource in storage.
     */





     public function store(Request $request)
     {
         // Vérifier si l'utilisateur est authentifié
         if (!Auth::check()) {
             return response()->json([
                 'status' => false,
                 'error_message' => 'Utilisateur non authentifié. Connectez-vous pour ajouter un étudiant.',
             ], 401);
         }

         // Validation des données
         $validatedData = $request->validate([
             'nom' => 'required|string|max:255',
             'prenom' => 'required|string|max:255',
             'adresse' => 'required|string|max:255',
             'telephone' => 'required|string|max:20',
             'matricule' => 'required|string|max:50',
             'date_naissance' => 'required|date',
             'email' => 'required|string|email|max:255|unique:users',
             'photo_path' => 'nullable|string',
             // Ajoutez d'autres règles de validation selon vos besoins
         ]);

         // Ajouter l'user_id de l'utilisateur authentifié
         $validatedData['user_id'] = Auth::id();

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
    public function show(Eleve $eleve)
    {
        //
        $eleve = Eleve::find($eleve);
        if(!$eleve){
           return response()->json(['message' => 'Etudiant non trouvé'], 404);
        }
        return $eleve;
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Vérifier si l'utilisateur est authentifié
        if (!Auth::check()) {
            return response()->json([
                'status' => false,
                'error_message' => 'Utilisateur non authentifié. Connectez-vous pour mettre à jour un étudiant.',
            ], 401);
        }

        // Validation des données
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'matricule' => 'required|string|max:50',
            'date_naissance' => 'required|date',
            'email' => 'required|string|email|max:255',
            'photo_path' => 'nullable|string',
            // Ajoutez d'autres règles de validation selon vos besoins
        ]);

        try {
            DB::beginTransaction();

            // Trouver l'étudiant à mettre à jour
            $eleve = Eleve::findOrFail($id);

            // Vérifier si l'e-mail est modifié et s'il est unique
            if ($eleve->email !== $validatedData['email']) {
                $existingEleve = Eleve::where('email', $validatedData['email'])->first();
                if ($existingEleve && $existingEleve->id !== $id) {
                    return response()->json([
                        'status' => false,
                        'error_message' => 'L\'adresse e-mail est déjà utilisée par un autre étudiant.',
                    ], 400);
                }
            }

            // Mettre à jour l'étudiant
            $eleve->update($validatedData);

            DB::commit();

            // Retourner la réponse JSON
            return response()->json([
                'status' => true,
                'data' => $eleve,
                'message' => 'Étudiant mis à jour avec succès',
            ], 200);

        } catch (\Exception $e) {
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
    public function destroy(Eleve $eleve)
    {
        // Vérifier si l'utilisateur est authentifié
        if (!Auth::check()) {
            return response()->json([
                'status' => false,
                'error_message' => 'Utilisateur non authentifié. Connectez-vous pour supprimer un étudiant.',
            ], 401);
        }

        try {
            // Supprimer l'étudiant de la base de données
            $eleve->delete();

            return response()->json([
                'status' => true,
                'message' => 'Étudiant supprimé avec succès',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => 'Erreur lors de la suppression de l\'étudiant : ' . $e->getMessage(),
            ], 500);
        }
    }
}
 