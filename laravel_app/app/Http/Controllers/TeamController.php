<?php

namespace App\Http\Controllers;

use App\Models\User;

class TeamController extends Controller
{
    public function index()
    {
        $director = User::teamMembers()->where('team_rank', 'director')->first();
        $associates = User::teamMembers()->where('team_rank', 'associate')->get();

        return view('equipo', compact('director', 'associates'));
    }
}
