<div class="col-lg-2 sidebar">
    <ul class="list-unstyled text-center">
        <li>
            <a href="{{ url('/manage') }}" class="{{ url()->current() == url('/manage') ? "active" : "" }}"><i class="fa fa-dashboard"></i> 后台首页</a>
        </li>
        <li>
            <a href="{{ url('/manage/projects') }}" class="{{ url()->current() == url('/manage/projects') ? "active" : "" }}"><i class="fa fa-cog"></i> 工程管理</a>
        </li>
        <li>
            <a href="{{ url('/manage/users') }}" class="{{ url()->current() == url('/manage/users') ? "active" : "" }}"><i class="fa fa-users"></i> 用户管理</a>
        </li>
    </ul>
</div>