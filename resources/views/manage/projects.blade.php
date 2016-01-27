@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('manage.partials.sidebar')
            <div class="col-lg-10 main-content">
                <div class="projects-panel">
                    <div class="col-sm-2 navbar-right">
                        <a class="create-btn" href="{{ url('/manage/projects/add') }}"><i class="fa fa-plus"></i>&nbsp;创建工程</a>
                    </div>
                    <div class="col-sm-2 navbar-right">
                        <a href="javascript:;" class="create-btn" onclick="searchManageDidClick()"><i class="fa fa-search"></i>&nbsp;搜索</a>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>工程名</td>
                                <td>难度</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                                <tr data-id="{{ $project->id }}">
                                    <td>{{ $project->id }}</td>
                                    <td>{{ mb_strlen($project->title, "UTF-8") > 25 ? mb_substr($project->title, 0, 25, "UTF-8") . "..." : $project->title }}</td>
                                    <td>{{ $project->difficulty }}</td>
                                    <td><a href="{{ url('/manage/project/') }}/{{ $project->id }}" class="edit-btn">编辑</a>
                                        <a href="javascript:;" class="delete-btn" data-id="{{ $project->id }}" data-title="{{ $project->title }}" onclick="deleteDidClick($(this))">删除</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination-wrapper text-center">
                    <p>
                        {!! $projects->links() !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer-scripts')
    <script>
        function deleteDidClick(el) {
            swal({
                title: "确定要删除该工程吗?",
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
                    url: "{{ url('/manage/project/') }}/" + el.attr('data-id'),
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

        function searchManageDidClick() {
            swal({
                title: "输入关键字",
                text: "查找相关的工程:",
                type: "input",
                inputType: "search",
                showCancelButton: true,
                closeOnConfirm: true,
                cancelButtonText: "取消",
                confirmButtonText: "查找",
                animation: "slide-from-bottom",
                inputPlaceholder: "查找工程..."
            }, function (inputValue) {
                if (inputValue === false) return;
                if (inputValue === "") {
                    swal.showInputError("最起码输入点什么吧");
                    return;
                }
                window.location.href = "{{ url('/manage/projects/search/') }}/" + inputValue;
            });
        }
    </script>
@stop