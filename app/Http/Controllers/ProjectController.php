<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{

    protected $itemPerPage = 50;

    /**
     * ProjectController constructor.
     */
    public function __construct()
    {

    }

    /**
     * Show all the projects
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProjects()
    {
        $projects = Project::alphabetically()->paginate($this->itemPerPage);
//        $projects = Project::alphabetically()->get();
        $title = "Launchpad工程列表";

        return view('projects.show', compact('projects', 'title'));
    }

    /**
     *
     * @param $keyword
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchProjects($keyword)
    {
        $projects = Project::search($keyword);
        $title = $keyword . "的搜索结果";

        return view('projects.show', compact('projects', 'title'));
    }

    /**
     * Show the projects that starred by given user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showStarred()
    {
        $projects = Auth::user()->projects;
        $title = "我收藏的工程";

        return view('projects.show', compact('projects', 'title'));
    }

    /**
     * User stars/un-stars a project (POST)
     *
     * @param Project $project
     * @return array JSON response
     */
    public function postStar(Project $project)
    {
        $response = array();
        $response['project'] = $project->toArray();

        if (!in_array(Auth::user()->id,$project->users()->lists('id')->toArray())) {
            Auth::user()->projects()->attach($project->id);
            $response['message'] = "成功收藏&nbsp;<span>" . $project->title . "</span>";
        } else {
            Auth::user()->projects()->detach($project->id);
            $response['message'] = "已取消收藏&nbsp;<span>" . $project->title . "</span>";
        }

        return $response;
    }
}
