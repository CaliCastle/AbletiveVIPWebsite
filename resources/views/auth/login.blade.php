@extends('layouts.app')

@section('styles')
    <style>
        body {
            /*background: #2f3238;*/
        }
    </style>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 login-form">
                <div class="panel">
                    <img src="images/Abletive LOGO Light Transparent.png" alt="">
                    <h2 class="welcome-message">欢迎光临 Abletive 会员专属站点</h2>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}

                        <span class="input input--abletive">
                            <input class="input__field input__field--abletive" type="text" id="username" name="name"
                                   {{ old('name') ? ' value='. old('name') : '' }} required autofocus>
                            <label class="input__label input__label--abletive" for="username">
                                <svg class="graphic graphic--abletive" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
                                    <path d="m0,0l404,0l0,77l-404,0l0,-77z"></path>
                                </svg>
                                <span class="input__label-content input__label-content--abletive">用户名</span>
                            </label>
                        </span>

                        <span class="input input--abletive">
                            <input class="input__field input__field--abletive" type="password" id="password" name="password" required>
                            <label class="input__label input__label--abletive" for="password">
                                <svg class="graphic graphic--abletive" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
                                    <path d="m0,0l404,0l0,77l-404,0l0,-77z"></path>
                                </svg>
                                <span class="input__label-content input__label-content--abletive">密码</span>
                            </label>
                        </span>


                        <input type="checkbox" name="remember" class="hidden" checked>

                        <button class="btn btn-login">登录</button>
                    </form>
                    <div class="panel-footer login-footer" style="background-color: transparent;border: none;">
                        <div class="col-lg-6 text-center">
                            <a href="http://abletive.com/wp-login.php?action=lostpassword" target="_blank">忘记密码?</a>
                        </div>
                        <div class="col-lg-6 text-center">
                            <a href="http://abletive.com" target="_blank">访问社区</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    <script>
        (function() {
            // trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
            if (!String.prototype.trim) {
                (function() {
                    // Make sure we trim BOM and NBSP
                    var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
                    String.prototype.trim = function() {
                        return this.replace(rtrim, '');
                    };
                })();
            }

            [].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
                // in case the input is already filled..
                if( inputEl.value.trim() !== '' ) {
                    classie.add( inputEl.parentNode, 'input--filled' );
                }

                // events:
                inputEl.addEventListener( 'focus', onInputFocus );
                inputEl.addEventListener( 'blur', onInputBlur );
            } );

            function onInputFocus( ev ) {
                classie.add( ev.target.parentNode, 'input--filled' );
            }

            function onInputBlur( ev ) {
                if( ev.target.value.trim() === '' ) {
                    classie.remove( ev.target.parentNode, 'input--filled' );
                }
            }

            @if($errors->has('name'))
                // create the notification
                var notification = new NotificationFx({
                    message : '<span class="fa fa-bell-o"></span> <p>{{ $errors->first('name') }}</p>',
                    layout : 'bar',
                    effect : 'slidetop',
                    type : 'error',
                    onClose : function() {

                    }
                });

                // show the notification
                notification.show();
            @endif
        })();
    </script>
@stop
