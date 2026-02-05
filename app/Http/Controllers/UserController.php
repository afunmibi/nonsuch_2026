<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hcp_hospitals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hospitals = Hcp_hospitals::orderBy('hcp_name')->get();
        return view('users.create', compact('hospitals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'max:50'],
            'hcp_id' => ['nullable', 'exists:hcp_hospitals,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'hcp_id' => $request->hcp_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $hospitals = Hcp_hospitals::orderBy('hcp_name')->get();
        return view('users.edit', compact('user', 'hospitals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // 1. Prevent GMs and MDs from editing Administrators
        if ($user->role === 'admin' && in_array(auth()->user()->role, ['gm', 'md'])) {
            return redirect()->route('users.index')->with('error', 'GMs and MDs do not have permission to modify an Administrator account.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'string', 'max:50'],
            'hcp_id' => ['nullable', 'exists:hcp_hospitals,id'],
        ]);

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // 1. Prevent GMs and MDs from deleting Administrators
        if ($user->role === 'admin' && in_array(auth()->user()->role, ['gm', 'md'])) {
            return redirect()->route('users.index')->with('error', 'GMs and MDs do not have permission to delete an Administrator.');
        }

        // 2. Prevent users from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
