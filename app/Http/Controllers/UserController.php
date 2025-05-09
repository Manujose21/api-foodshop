<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\UserRole; // Ensure this is the correct namespace for UserRole

class UserController extends Controller
{
    //

    public function index()
    {
        return new UserCollection(User::paginate(10));
    }


    public function delete(Request $request, User $user)
    {
        // check if user is admin
        if ($request->user()->role !== UserRole::ADMIN) {
            return response()->json([
                'message' => 'You are not authorized to delete this user',
            ], 403);
        }

        // delete user
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }

}
