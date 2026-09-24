<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ['title' => 'Einloggen'];
        return view('pages.auth.signin', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = ['title' => 'Registrieren'];
        return view('pages.auth.signup', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'fname' => 'required|min:3|max:30',
            'lname' => 'required|min:3|max:30',
            'email' => 'required|min:3|max:30|email',
            'password' => 'required|min:8|max:30',
        ],
        [
            'fname.required' => 'Bitte einen Vornamen eingeben.',
            'fname.min' => 'Mindestens 3 Zeichen beim Vornamen eingeben.',
            'fname.max' => 'Maximal 30 Zeichen beim Vornamen eingeben.',
            'lname.required' => 'Bitte einen Nachnamen eingeben.',
            'lname.min' => 'Mindestens 3 Zeichen beim Nachnamen eingeben.',
            'lname.max' => 'Maximal 30 Zeichen beim Nachnamen eingeben.',
            'email.required' => 'Bitte eine Email eingeben.',
            'email.min' => 'Mindestens 3 Zeichen bei Email eingeben.',
            'email.max' => 'Maximal 30 Zeichen bei Email eingeben.',
            'email.email' => 'Gib eine gültige Emailadresse ein.',
            'password.required' => 'Bitte ein Passwort eingeben.',
            'password.min' => 'Mindestens 8 Zeichen beim Passwort eingeben.',
            'password.max' => 'Maximal 30 Zeichen beim Passwort eingeben.',
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = user::where('email', $data['email'])->first();

        if($user) {
            return back()
                ->withErrors(['email' => 'Benutzer mit dieser Mail gibt es bereits!']);
        }

        User::create($data);

        return redirect()
            ->route('signin')
            ->with('success', 'Registrierung erfolgreich!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($data)) {

            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email oder Passwort ist falsch.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('signin');
    }
}
