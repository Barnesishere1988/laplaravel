<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'beschreibung' => 'required|string|max:1000',
        ]);

        Todo::create([
            'beschreibung' => $data['beschreibung'],
            'is_done' => false,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Aufgabe wurde erstellt.');
    }

    public function update(Request $request, Todo $todo)
    {
        $data = $request->validate([
            'beschreibung' => 'sometimes|required|string|max:1000',
            'is_done' => 'sometimes|required|boolean',
        ]);

        $todo->update($data);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Aufgabe wurde aktualisiert.');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Aufgabe wurde gelöscht.');
    }

    
}