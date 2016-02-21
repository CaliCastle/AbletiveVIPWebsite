<nav class="navigation-bar">
    <div class="container">
        <ul class="nav-list">
            <div class="navbar-left">
                <li><a href="{{ url('/') }}"><i class="fa fa-home"></i>&nbsp;主页</a></li>
                <li><a href="{{ url('/projects') }}"><i class="fa fa-cloud-download"></i>&nbsp;工程下载</a></li>
                <li><a href="http://v.abletive.com" target="_blank"><i class="fa fa-book"></i>&nbsp;教学视频</a></li>
                @if(url()->previous())
                    <li><a href="{{ url()->previous() }}"><i class="fa fa-chevron-circle-left"></i>&nbsp;返回</a></li>
                @endif
            </div>
            <div class="navbar-right">
                @unless(Auth::check())
                    <li>请先登录</li>
                @else
                    <div class="img-circle avatar">
                        <img src="{{ Auth::user()->avatar ? Auth::user()->avatar : url('/images/default-avatar.png') }}" alt="{{ Auth::user()->display_name }}">
                    </div>
                    <li title="会员将在{{ Auth::user()->expired_at }}到期"><i class="fa fa-fort-awesome"></i>&nbsp;欢迎尊贵的会员,&nbsp; <span class="user-name">{{ Auth::user()->display_name }}</span>.</li>
                    @if(Auth::user()->isManager() && !isset($manage))
                        <li><a href="{{ url('/manage') }}"><i class="fa fa-dashboard"></i>&nbsp;后台管理</a></li>
                    @endif
                    <li><a href="javascript:;" onclick="logoutDidClick()" style="outline: none;"><i class="fa fa-power-off"></i>&nbsp;注销</a></li>
                @endunless
            </div>
        </ul>
    </div>
</nav>