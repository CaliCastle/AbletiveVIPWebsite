<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "首页";

        $expired_date = Auth::user()->expired_at->format('Y年m月d日');

        return view('home', compact('title', 'expired_date'));
    }

    /**
     * Refresh the current user's membership information
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refresh()
    {
        $expired_at = $this->checkMembershipExpired(Auth::user()->user_id);
        if ($expired_at) {
            Auth::user()->expired_at = $expired_at;
            Auth::user()->save();
            return redirect('/home')->with("status", "会员信息已更新");
        } else {
            Auth::logout();
            return redirect('/login')->with("status", "您的会员已过期");
        }
    }

    /**
     * Check to see if the user membership has expired
     *
     * @param $user_id
     * @return bool|Carbon
     */
    protected function checkMembershipExpired($user_id)
    {
        $ch = curl_init("http://abletive.com/api/user/membership/?user_id=" . $user_id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($result);

        $user = Auth::user();
        $user->avatar = $json->avatar;
        $user->save();

        if ($json->status == "ok" && $json->member->endTime != "N/A") {
            $expired_at = Carbon::parse($json->member->endTime);
            if ($expired_at >= Carbon::now()) {
                return $expired_at;
            }
        }
        return false;
    }
}
