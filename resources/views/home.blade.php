@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="home-panel">
                <div class="text-center">
                    <h2>欢迎光临Abletive会员专属站 2.0</h2>
                    <p>由 <span class="laravel">Cali</span> 全新开发打造的VIP站点</p>
                    <p class="developer">
                        左上角有『菜单』选择, 右上角可以『注销』.
                    </p>
                    <br>
                    <p>您的会员将在 {{ $expired_date }} 过期</p>
                    <a href="{{ url('/refresh') }}" class="refresh-btn"><i class="fa fa-refresh"></i>&nbsp;刷新会员信息</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
