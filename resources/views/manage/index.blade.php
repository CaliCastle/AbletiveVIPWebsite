@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('manage.partials.sidebar')
        <div class="col-lg-10 main-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 dashboard-sign">
                        <h3>工程总数</h3>
                        <p>{{ \App\Project::all()->count() }}个</p>
                    </div>
                    <div class="col-md-4 dashboard-sign">
                        <h3>用户总数</h3>
                        <p>{{ \App\User::all()->count() }}个</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@stop