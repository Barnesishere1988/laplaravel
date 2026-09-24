<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.account', [
            'title' => 'Mein Account',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, User $user)
    {
        $user = $request->user();

        $data = $request->validate([
            'fname' => [
                'required',
                'string',
                'min:3',
                'max:30',
            ],
            'lname' => [
                'required',
                'string',
                'min:3',
                'max:30',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],
        ]);

        $user->update($data);

        return redirect()
            ->route('account')
            ->with(
                'succes',
                'Accountdaten wurden aktualisiert.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => [
                'required',
                'current_password',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],
        ]);

        $user = $request->user();

        $user->password = hash::make(
            $data['password']
        );

        $user->save();

        return redirect()
            ->route('account')
            ->with(
                'success',
                'Passwort wurde aktualisiert.'
            );
    }

    public function updateImage(Request $request)
    {
        $data = $request->validate([
            'user_image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $user = $request->user();

        $image = $data['user_image'];

        $extension = $image->extension();

        $filename = Str::uuid()
            . '.'
            . $extension;

        $path = $image->storeAs(
            'avatars',
            $filename,
            'public'
        );

        if ($path === false) {
            return back()->withErrors([
                'user_image' =>
                    'Das Bild konnte nicht gespeichert werden.'
            ]);
        }

        $oldImage = $user->user_image;

        $user->user_image = $filename;

        try {
            $user->save();
        } catch(\Throwable $exception) {
            Storage::disk('public')->delete($path);

            throw $exception;
        }

        if ($oldImage) {
            Storage::disk('public')->delete(
                'avatars/' . $oldImage
            );
        }

        return redirect()
            ->route('account')
            ->with(
                'success',
                'Profilbild wurde aktualisiert.'
            );
    }

    public function deleteImage(Request $request)
    {
        $user = $request->user();

        $oldImage = $user->user_image;

        if ($oldImage) {
            $user->user_image = null;
            $user->save();

            Storage::disk('public')->delete(
                'avatars/' . $oldImage
            );
        }

        return redirect()
            ->route('account')
            ->with(
                'success',
                'Profilbild wurde gelöscht.'
            );
    }
}
