<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    // Afficher tous les contacts
    public function index()
    {
        $contacts = Contact::all();  // Récupérer tous les contacts
        return response()->json($contacts);
    }

    // Afficher un contact par ID
    public function show($id)
    {
        $contact = Contact::find($id);  // Trouver le contact par ID

        if (!$contact) {
            return response()->json(['message' => 'Contact non trouvé.'], 404);
        }

        return response()->json($contact);
    }

    // Ajouter un contact (POST)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|digits:10',
            'message' => 'required|string|max:1000',
        ]);

        // Ajouter un contact avec un statut par défaut "Pas encore"
        $contact = Contact::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'message' => $validatedData['message'],
            'contact_date' => now(),
            'status' => 'Pas encore',  // Valeur par défaut
        ]);

        return response()->json([
            'message' => 'Contact enregistré avec succès.',
            'contact' => $contact,
        ], 201);
    }

    // Supprimer un contact par ID
    public function destroy($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json(['message' => 'Contact non trouvé.'], 404);
        }

        $contact->delete();  // Supprimer le contact

        return response()->json(['message' => 'Contact supprimé avec succès.']);
    }
}
