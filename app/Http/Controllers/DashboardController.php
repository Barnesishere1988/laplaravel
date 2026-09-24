<?php

namespace App\Http\Controllers;

use App\Models\Todo;

class DashboardController extends Controller
{
    public function index()
    {
        $todos = Todo::orderBy('is_done')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.dashboard', [
            'title' => 'Dashboard',
            'todos' => $todos,
        ]);
    }
}