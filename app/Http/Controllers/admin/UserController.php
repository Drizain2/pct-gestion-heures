<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    public function index(){
        $users = User::with("roles")->orderBy('name')->paginate(10);
        $roles =Role::all();

        return view("admin.users.index",compact("users","roles"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name"=>"required|string|max:255",
            "email"=>"required|email|unique:users,email",
            "password"=>"required|min:8|confirmed",
            "role"=>"required|exists:roles,name",
        ]);

        $user = User::create([
            "name"=>$request->input("name"),
            "email"=>$request->input("email"),
            "password"=>bcrypt($request->input("password")),
        ]);
        
        // créér un compte enseignant
        if($request->input("role") === "enseignant"){
            Enseignant::create([
                "user_id"=>$user->id,
                "nom"=>$request->input("name"),
                "email"=>$request->input("email"),
            ]);
        }

        $user->assignRole($request->input("role"));

        return back()->with("success", "Utilisateur ajouté avec succès");
    }

    public function updateRole(Request $request,User $user){
        $request->validate([
            "role"=>"required|exists:roles,name",
        ]);

        // empecher de changer son propre role
        if($user->id === auth()->id()){
            return back()->with("error", "Vous ne pouvez pas changer votre propre rôle");
        }

        $user->syncRoles($request->input("role"));

        return back()->with("success", "Rôle mis à jour avec succès");
    }

    public function resetPassword(Request $request,User $user){
        $request->validate([
            "password"=>"required|min:8|confirmed",
        ]);
        $user->update(["password"=>$request->input("password")]);

        return back()->with("success", "Mot de passe réinitialisé avec succès");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if($user->id === auth()->id()){
            return back()->with("error", "vous ne pouvez pas supprimer votre propre compte");
        }
        $user->delete();
        return back()->with("success", "Utilisateur supprimé avec succès");
    }

}
