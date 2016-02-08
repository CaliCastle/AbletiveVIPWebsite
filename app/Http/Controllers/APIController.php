<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class APIController extends Controller
{
    /**
     * Application Interface for getting projects
     *
     * @param string $difficulty
     * @return array
     */
    public function showProjects($difficulty = '1')
    {
        $projects = Project::where('difficulty', $difficulty . '星')->get();

        return [
            "current_count" => $projects->count(),
            "total_count" => Project::all()->count(),
            "list" => $projects
        ];
    }
}
