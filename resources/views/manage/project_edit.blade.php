@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('manage.partials.sidebar')
            <div class="col-lg-10 main-content">
                <div class="projects-panel">
                    <form action="{{ $action == "创建" ? action('ManageController@addProject') : action('ManageController@saveProject', ["id" => $project->id]) }}" method="POST" role="form" class="form-horizontal">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="col-sm-2"><i class="fa fa-asterisk delete-btn"></i>&nbsp;工程标题</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $project->title }}" name="title" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">工程作者</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $project->maker }}" name="maker">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">百度网盘</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $project->baidu_link }}" name="baidu_link">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">社区云盘</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $project->qiniu_link }}" name="qiniu_link">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">图片地址</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $project->thumbnail }}" name="thumbnail">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">在线视频</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $project->video_link }}" name="video_link">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">教程视频地址</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $project->tutorial_link }}" name="tutorial_link">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">视频下载</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $project->video_download }}" name="video_download">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">社区原帖地址</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $project->details_link }}" name="details_link">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2"><i class="fa fa-asterisk delete-btn"></i>&nbsp;难度评级</label>
                            <div class="col-sm-10 radio-group">
                                <input type="radio" value="1星"{{ $project->difficulty == "1星" ? " checked" : "" }} name="difficulty"> 1 <i class="fa fa-star"></i>&nbsp;
                                <input type="radio" value="2星"{{ $project->difficulty == "2星" ? " checked" : "" }} name="difficulty"> 2 <i class="fa fa-star"></i>&nbsp;
                                <input type="radio" value="3星"{{ $project->difficulty == "3星" ? " checked" : "" }} name="difficulty"> 3 <i class="fa fa-star"></i>&nbsp;
                                <input type="radio" value="4星"{{ $project->difficulty == "4星" ? " checked" : "" }} name="difficulty"> 4 <i class="fa fa-star"></i>&nbsp;
                                <input type="radio" value="5星"{{ $project->difficulty == "5星" ? " checked" : "" }} name="difficulty"> 5 <i class="fa fa-star"></i>&nbsp;
                                <input type="radio" value="6星"{{ $project->difficulty == "6星" ? " checked" : "" }} name="difficulty"> 6 <i class="fa fa-star"></i>&nbsp;
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <input type="checkbox"{{ $project->has_tutorial ? " checked" : "" }} name="has_tutorial"> 有教学轨
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <input type="checkbox"{{ $project->is_universal ? " checked" : "" }} name="is_universal"> S\RGB\Pro通用
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">
                                备注/介绍
                            </label>
                            <div class="col-sm-10">
                                <textarea name="description" id="" rows="3">{{ $project->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <input type="submit" value="{{ $action }}">
                            </div>
                            @unless($action == "创建")
                                <div class="col-sm-4">
                                    <a href="javascript:;" class="delete" onclick="deleteThisDidClick()" data-id="{{ $project->id }}">删除</a>
                                </div>
                            @endunless
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer-scripts')
    @unless($action == "创建")
    <script>
        function deleteThisDidClick() {
            swal({
                title: "确定要删除该工程吗?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                cancelButtonText: "取消",
                confirmButtonText: "删除!",
                showLoaderOnConfirm: true,
                closeOnConfirm: false
            }, function(){
                $.ajax({
                    url: "{{ url('/manage/project/') }}/{{ $project->id }}",
                    type: "DELETE",
                    data: {_token:"{{ csrf_token() }}"},
                    success: function (json) {
                        swal({title:json.message, type:"success",timer: 1000,showConfirmButton: false});
                        setTimeout(function () {
                            window.location.href = "{{ url('/manage/projects') }}";
                        }, 500);
                    }
                });
            });
        }
    </script>
    @endunless
@stop