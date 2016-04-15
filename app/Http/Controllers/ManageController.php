<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ManageController extends Controller
{
    /**
     * Manage index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $title = "后台管理";
        $manage = true;

        return view('manage.index', compact('title', 'manage'));
    }

    /**
     * Show the manage page for projects
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function projects()
    {
        $title = "工程管理";
        $manage = true;

        $projects = Project::latest()->paginate(50);

        return view('manage.projects', compact('title', 'manage', 'projects'));
    }

    /**
     * Show the create page for projects
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createProject()
    {
        $title = "创建新工程";
        $manage = true;
        $action = "创建";

        $project = new Project;

        return view('manage.project_edit', compact('title', 'manage', 'action', 'project'));
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function addProject(Request $request)
    {
        $params = $this->filterRequest($request);
        $project = Project::create($params);

        if ($project) {
            return redirect('/manage/projects')->with('status', '工程创建成功');
        } else {
            return redirect()->back()->withInput($params)->withErrors([
                "error" => "工程创建出错, 请重试"
            ]);
        }
    }

    /**
     * Show the edit page for a given project
     *
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editProject(Project $project)
    {
        $title = "编辑" . $project->title;
        $manage = true;
        $action = "保存";

        return view('manage.project_edit', compact('title', 'manage', 'project', 'action'));
    }

    /**
     * Save a project from a POST request
     *
     * @param Project $project
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveProject(Project $project, Request $request)
    {
        $params = $this->filterRequest($request);
        if ($project->update($params)) {
            return redirect()->back()->with('status', '工程已更新!');
        } else {
            return redirect()->back()->with('status', '工程更新出错!');
        }
    }


    public function deleteProject(Project $project)
    {
        $project->delete();
        return ["message" => "删除成功"];
    }

    /**
     * Filter through a request and get the parameters in the right format
     *
     * @param Request $request
     * @return array
     */
    private function filterRequest(Request $request)
    {
        $params = $request->except('_token');
        $params['has_tutorial'] = isset($params['has_tutorial']) ? 1 : 0;
        $params['is_universal'] = isset($params['is_universal']) ? 1 : 0;

        return $params;
    }

    /**
     * Display all the users
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function users()
    {
        $title = "用户管理";
        $manage = true;
        $users = User::managersFirst()->paginate(50);

        return view('manage.users', compact('title', 'manage', 'users'));
    }


    /**
     * Search projects in the manage page
     *
     * @param $keyword
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchProjects($keyword)
    {
        $projects = Project::search($keyword);
        $title = $keyword . "的相关工程";
        $manage = true;

        return view('manage.projects', compact('title', 'manage', 'projects'));
    }

    /**
     * Promote/demote a user from a POST request
     *
     * @param User $user
     * @return array
     */
    public function promoteUser(User $user)
    {
        $role = $user->changeRole();

        return ["message" => $role];
    }

    /**
     * Deletes a user from a DELETE request
     *
     * @param User $user
     * @return array
     * @throws \Exception
     */
    public function deleteUser(User $user)
    {
        $name = $user->name;
        $user->delete();

        return ["message" => $name."已被删除"];
    }

    /**
     * Display a searched user list by given keywords
     *
     * @param $keywords
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchUsers($keywords)
    {
        $manage = true;
        $users = User::search($keywords);

        $title = count($users) ? $keywords."的相关用户" : "无相关用户";

        return view('manage.users', compact('title', 'manage', 'users'));
    }
}
