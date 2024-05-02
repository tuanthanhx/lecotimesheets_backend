<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the users based on filters.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Start with a query for all users in group 2
        $query = User::where('group', 2);

        // Check if a keyword was provided
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                  ->orWhere('username', 'like', "%$keyword%")
                  ->orWhere('address', 'like', "%$keyword%")
                  ->orWhere('phone', 'like', "%$keyword%");
            });
        }

        // Check if a status was provided

        if ($request->filled('status')) {
            // Log::debug('$request->status ' . $request->status);
            $query->where('status', $request->status);
        }

        // Execute the query
        $users = $query->get();

        return response()->json($users);
    }

    /**
     * Activate the specified user in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update(['status' => 1]);

        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    /**
     * Deactivate the specified user in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update(['status' => 2]);

        return response()->json(['message' => 'User deleted successfully'], 200);
    }


    /**
     * Remove the specified user from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
