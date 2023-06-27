<?php

namespace App\Http\Controllers;

use App\Models\Userclient;
use Illuminate\Http\Request;

class UserclientController extends Controller
{
    public function index()
    {
        $users = Userclient::all();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'Phone' => 'required',
            'cin' => 'required',
            'image_path' => 'required',
            'image' => 'required',
        ]);

        $user = Userclient::create($validatedData);

        return redirect()->route('users.show', $user->id);
    }

    public function show(Userclient $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(Userclient $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, Userclient $user)
    {
        // Validate the input
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'Phone' => 'required',
            'cin' => 'required',
            'image_path' => 'required',
            'image' => 'required',
        ]);

        // Update the user
        $user->update($validatedData);

        // Redirect to the user's profile or any other appropriate page
        return redirect()->route('users.show', $user->id);
    }

    public function destroy(Userclient $user)
    {
        // Delete the user
        $user->delete();

        // Redirect to the users' listing page or any other appropriate page
        return redirect()->route('users.index');
    }
}
