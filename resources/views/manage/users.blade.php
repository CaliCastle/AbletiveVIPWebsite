@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('manage.partials.sidebar')
            <div class="col-lg-10 main-content">
                <div class="projects-panel">
                    <div class="col-sm-2 navbar-right">
                        <a class="create-btn" href="javascript:;" onclick="searchUserDidClick()"><i class="fa fa-search"></i>&nbsp;搜索用户</a>
                    </div>
                    @if(count($users))
                        <table class="table">
                            <thead>
                            <tr>
                                <td>#</td>
                                <td>用户名</td>
                                <td>昵称</td>
                                <td>过期时间</td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr data-id="{{ $user->id }}">
                                    <td>{{ $user->id }}</td>
                                    <td{{ $user->isManager() ? ' class=manager' : '' }}>{{ mb_strlen($user->name, "UTF-8") > 25 ? mb_substr($user->name, 0, 25, "UTF-8") . "..." : $user->name }}</td>
                                    <td>{{ $user->display_name }}</td>
                                    <td>{{ $user->expired_at->format("Y年m月d日") }}</td>
                                    <td>
                                    @unless(Auth::user()->id == $user->id)
                                        <a href="javascript:;" class="edit-btn" data-id="{{ $user->id }}" data-title="{{ $user->name }}" onclick="promoteDidClick($(this))">{{ $user->isManager() ? "取消管理员" : "认命管理员" }}</a>
                                        <a href="javascript:;" class="delete-btn" data-id="{{ $user->id }}" data-title="{{ $user->name }}" onclick="deleteDidClick($(this))">删除</a>
                                    @else
                                        自己
                                    @endunless
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="no-results">
                            <div class="container">
                                <div class="row text-center">
                                    <p><img src="http://vip.abletive.dev/images/No_Result.png" alt=""></p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="pagination-wrapper text-center">
                    <p>
                        {!! $users->links() !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer-scripts')
    <script>
        @if(session('status'))
            showStatusMessage("{{ session('status') }}");
        @endif

        function searchUserDidClick() {
            swal({
                title: "输入关键字",
                text: "查找相关昵称/用户名的用户:",
                type: "input",
                inputType: "search",
                showCancelButton: true,
                closeOnConfirm: true,
                cancelButtonText: "取消",
                confirmButtonText: "查找",
                animation: "slide-from-bottom",
                inputPlaceholder: "查找用户..."
            }, function (inputValue) {
                if (inputValue === false) return;
                if (inputValue === "") {
                    swal.showInputError("最起码输入点什么吧");
                    return;
                }
                window.location.href = "{{ url('/manage/users/search/') }}/" + inputValue;
            });
        }

        function promoteDidClick(el) {
            swal({
                title: "确定此操作吗?",
                text: "将改变" + el.attr('data-title') + "的权限?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                cancelButtonText: "取消",
                confirmButtonText: "确定!",
                showLoaderOnConfirm: true,
                closeOnConfirm: false
            }, function(){
                $.ajax({
                    url: "{{ url('/manage/user/promote') }}/" + el.attr('data-id'),
                    type: "POST",
                    data: {_token:"{{ csrf_token() }}"},
                    success: function (json) {
                        swal({title:json.message, type:"success",timer: 1000,showConfirmButton: false});
                        var selector = 'tr[data-id="' + el.attr('data-id') + '"] a.edit-btn';
                        $(selector).text($(selector).text() == "取消管理员" ? "认命管理员" : "取消管理员");
                    }
                });
            });
        }

        function deleteDidClick(el) {
            swal({
                title: "确定要删除该用户吗?",
                text: "删除<" + el.attr('data-title') + ">?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                cancelButtonText: "取消",
                confirmButtonText: "删除!",
                showLoaderOnConfirm: true,
                closeOnConfirm: false
            }, function(){
                $.ajax({
                    url: "{{ url('/manage/user') }}/" + el.attr('data-id'),
                    type: "DELETE",
                    data: {_token:"{{ csrf_token() }}"},
                    success: function (json) {
                        swal({title:json.message, type:"success",timer: 1000,showConfirmButton: false});
                        var selector = 'tr[data-id="' + el.attr('data-id') + '"]';
                        $(selector).fadeOut(1000,function() {$(this).remove()});
                    }
                });
            });
        }
    </script>
@stop