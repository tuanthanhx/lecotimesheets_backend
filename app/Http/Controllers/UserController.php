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
                  ->orWhere('username', 'like', "%$keyword%");
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
     * Store a newly created user in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'hourly_rate' => 'required|numeric',
            'language' => 'nullable|string|max:2',
            'status' => 'nullable|integer',
        ]);

        // Create and save the new user
        $user = User::create([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'password' => bcrypt($validatedData['password']),
            'group' => 2,
            'dob' => isset($validatedData['dob']) ? date('Y-m-d', strtotime($validatedData['dob'])) : null,
            'address' => $validatedData['address'] ?? null,
            'phone' => $validatedData['phone'] ?? null,
            'hourly_rate' => $validatedData['hourly_rate'],
            'language' => $validatedData['language'] ?? null,
            'status' => $validatedData['status'] ?? null,
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }


    /**
     * Update the specified user in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'password' => 'sometimes|string|min:6',
            'hourly_rate' => 'numeric',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:2',
            'status' => 'nullable|integer',
        ]);

        // Only update fields that are provided
        if ($request->has('dob')) {
            $validatedData['dob'] = date('Y-m-d', strtotime($validatedData['dob']));
        }
        if ($request->has('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
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
