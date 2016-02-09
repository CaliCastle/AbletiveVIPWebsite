@extends('layouts.app')

@section('content')
<!-- Bottom bar with filter and collection info -->
<div class="bar">
    <div class="filter">
        <span class="filter__label">排序: </span>
        <button class="action filter__item filter__item--selected" data-filter="*">全部</button>
        <button class="action filter__item" data-filter=".1星"><i class="icon icon--jacket"></i><span class="action__text">1星</span></button>
        <button class="action filter__item" data-filter=".2星"><i class="icon icon--shirt"></i><span class="action__text">2星</span></button>
        <button class="action filter__item" data-filter=".3星"><i class="icon icon--dress"></i><span class="action__text">3星</span></button>
        <button class="action filter__item" data-filter=".4星"><i class="icon icon--trousers"></i><span class="action__text">4星</span></button>
        <button class="action filter__item" data-filter=".5星"><i class="icon icon--shoe"></i><span class="action__text">5星</span></button>
        <button class="action filter__item" data-filter=".6星"><i class="icon icon--shoe"></i><span class="action__text">6星</span></button>
        <button class="action filter__item" data-filter=".tutorial"><i class="icon icon--shoe"></i><span class="action__text">教程轨</span></button>
    </div>
    <button class="search" onclick="searchDidClick()">
        <a href="javascript:;" title="搜索">
            <i class="search__icon fa fa-search"></i>
            <span class="text-hidden">搜索</span>
        </a>
    </button>
    <button class="collection">
        <a href="{{ url('projects/starred') }}">
            <i class="collection__icon fa fa-star"></i>
            <span class="text-hidden">收藏夹</span>
            <span class="collection__count">{{ Auth::user()->projects->count() }}</span>
        </a>
    </button>
</div>
<div class="container">
    <div class="row text-center helper">
        <h2>{{ $title }}</h2>
        <div class="helper-text">
            <p>帮助: <br><i class="fa fa-paw baidu-btn"></i> 代表百度网盘 &nbsp; <i class="fa fa-cloud-download qiniu-btn"></i> 代表社区云盘 &nbsp; <i class="fa fa-globe details-link"></i> 代表社区原帖地址
                <br>
                <i class="fa fa-television online-video"></i> 代表在线视频 &nbsp; <i class="fa fa-file-video-o"></i> 代表视频下载 &nbsp; <i class="fa fa-book tutorial-video"></i> 代表教学视频
                <br>
                <i class="fa fa-smile-o universal-proj"></i> 代表工程S, Mini, RGB/Pro通用
            </p>
            <p class="developer">
                点击工程的图片右上角有收藏功能,收藏后可以在站点右下角的『我的收藏』页面中查看
            </p>
        </div>
    </div>
    {{--@unless(url()->current() == url('/projects/starred'))--}}
    {{--<div class="row">--}}
    {{--<div class="pagination-wrapper text-center">--}}
    {{--<p>{!! $projects->links() !!}</p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--@endunless--}}
    <div class="row">
        <p>{{ str_contains($title,"搜索结果") ? "相关" : "本页" }}工程: {{ count($projects) }}个
            {{--@unless(url()->current() == url('/projects/starred'))--}}
            {{--, 所有工程 {{ $projects->total() }}个--}}
            {{--@endunless--}}
        </p>
    </div>
</div>

<div class="view">
    @if(count($projects))
    <!-- Grid -->
    <section class="grid grid--loading">
        <!-- Loader -->
        <img class="grid__loader" src="{{ url('images/grid.svg') }}" width="60" alt="Loader image" />
        <!-- Grid sizer for a fluid Isotope (Masonry) layout -->
        <div class="grid__sizer"></div>
        @foreach($projects as $project)
                <!-- Grid items -->
        <div class="grid__item {{ $project->difficulty }}{{ $project->has_tutorial ? " tutorial" : "" }}">
            <div class="slider">
                <div class="slider__item">
                    <img class="preload-images" data-src="{{ $project->thumbnail }}"
                         src="{{ url("images/placeholder.jpg") }}" alt="{{ $project->title }}"/>
                </div>
                @if($project->description)
                    <div class="slider__item">
                        <p>介绍/备注: {{ $project->description }}</p>
                    </div>
                @endif
            </div>
            <div class="meta">
                <h3 class="meta__title{{ $project->has_tutorial ? " has__tutorial" : "" }}">{{ $project->title }}</h3>
                @if($project->maker)
                    <span class="meta__author">作者: {{ $project->maker }}</span>
                @endif
                <span class="meta__difficulty" title="难度星级">难{{ substr($project->difficulty, 0, 1) }}
                    <i class="fa fa-star"></i>{!! $project->is_universal ? ' &nbsp; <i class="fa fa-smile-o universal-proj"></i>' : '' !!}
                    @if(Auth::user()->isManager())
                        <br>
                        <a class="edit-link" href="{{ action('ManageController@editProject', ["id" => $project->id]) }}" title="编辑"><i class="fa fa-edit"></i></a>
                    @endif
                    </span>

                <div class="actions">
                    @if($project->baidu_link)
                        <a href="{{ $project->baidu_link }}" title="百度网盘" class="baidu-btn" target="_blank"><i class="fa fa-paw"></i></a>
                    @endif

                    @if($project->qiniu_link)
                        <a href="{{ $project->qiniu_link }}" title="社区云盘" class="qiniu-btn" target="_blank"><i class="fa fa-cloud-download"></i></a>
                    @endif

                    @if($project->video_link)
                        <a href="{{ $project->video_link }}" title="在线视频" class="online-video" target="_blank"><i class="fa fa-television"></i></a>
                    @endif

                    @if($project->video_download)
                        <a href="{{ $project->video_download }}" title="视频下载" target="_blank"><i class="fa fa-file-video-o"></i></a>
                    @endif

                    @if($project->tutorial_link)
                        <a href="{{ $project->tutorial_link }}" title="教学视频" class="tutorial-video" target="_blank"><i class="fa fa-book"></i></a>
                    @endif

                    @if($project->details_link)
                        <a href="{{ $project->details_link }}" title="原帖地址" class="details-link" target="_blank"><i class="fa fa-globe"></i></a>
                    @endif
                </div>
            </div>
            <button class="action action--button action--star{{ $project->hasStarred() ? " has-starred" : "" }}" title="{{ $project->hasStarred() ? "已" : "添加" }}收藏" data-id="{{ $project->id }}"><i class="fa"></i><span class="text-hidden">Add to collection</span></button>
        </div>
        @endforeach
    </section>
    <!-- /grid-->
    @else
    <section class="no-results">
        <div class="container">
            <div class="row text-center">
                <p><img src="{{ url('/images/No_Result.png') }}" alt=""></p>
            </div>
        </div>
    </section>
    @endif
</div>

{{--@unless(url()->current() == url('/projects/starred'))--}}
{{--<div class="pagination-wrapper text-center">--}}
{{--<p>--}}
{{--{!! $projects->links() !!}--}}
{{--</p>--}}
{{--</div>--}}
{{--@endunless--}}
@stop

@section('footer-scripts')
    <script>
        ;(function(window) {

            'use strict';

            var support = { animations : Modernizr.cssanimations },
                    animEndEventNames = { 'WebkitAnimation' : 'webkitAnimationEnd', 'OAnimation' : 'oAnimationEnd', 'msAnimation' : 'MSAnimationEnd', 'animation' : 'animationend' },
                    animEndEventName = animEndEventNames[ Modernizr.prefixed( 'animation' ) ],
                    onEndAnimation = function( el, callback ) {
                        var onEndCallbackFn = function( ev ) {
                            if( support.animations ) {
                                if( ev.target != this ) return;
                                this.removeEventListener( animEndEventName, onEndCallbackFn );
                            }
                            if( callback && typeof callback === 'function' ) { callback.call(); }
                        };
                        if( support.animations ) {
                            el.addEventListener( animEndEventName, onEndCallbackFn );
                        }
                        else {
                            onEndCallbackFn();
                        }
                    };

            // from http://www.sberry.me/articles/javascript-event-throttling-debouncing
            function throttle(fn, delay) {
                var allowSample = true;

                return function(e) {
                    if (allowSample) {
                        allowSample = false;
                        setTimeout(function() { allowSample = true; }, delay);
                        fn(e);
                    }
                };
            }

            // sliders - flickity
            var sliders = [].slice.call(document.querySelectorAll('.slider')),
            // array where the flickity instances are going to be stored
                    flkties = [],
            // grid element
                    grid = document.querySelector('.grid'),
            // isotope instance
                    iso,
            // filter ctrls
                    filterCtrls = [].slice.call(document.querySelectorAll('.filter > button')),
            // collection
                    collection = document.querySelector('.collection'),
                    collectionItems = collection.querySelector('.collection__count');

            function init() {
                // preload images
                imagesLoaded(grid, function() {
                    initFlickity();
                    initIsotope();
                    initEvents();
                    classie.remove(grid, 'grid--loading');
                });
            }

            function initFlickity() {
                sliders.forEach(function(slider){
                    var flkty = new Flickity(slider, {
                        prevNextButtons: false,
                        wrapAround: true,
                        cellAlign: 'left',
                        contain: true,
                        resize: false
                    });

                    // store flickity instances
                    flkties.push(flkty);
                });
            }

            function initIsotope() {
                iso = new Isotope( grid, {
                    isResizeBound: false,
                    itemSelector: '.grid__item',
                    percentPosition: true,
                    masonry: {
                        // use outer width of grid-sizer for columnWidth
                        columnWidth: '.grid__sizer'
                    },
                    transitionDuration: '0.6s'
                });
            }

            function initEvents() {
                filterCtrls.forEach(function(filterCtrl) {
                    filterCtrl.addEventListener('click', function() {
                        classie.remove(filterCtrl.parentNode.querySelector('.filter__item--selected'), 'filter__item--selected');
                        classie.add(filterCtrl, 'filter__item--selected');
                        iso.arrange({
                            filter: filterCtrl.getAttribute('data-filter')
                        });
                        recalcFlickities();
                        iso.layout();
                    });
                });

                // window resize / recalculate sizes for both flickity and isotope/masonry layouts
                window.addEventListener('resize', throttle(function(ev) {
                    recalcFlickities()
                    iso.layout();
                }, 50));

                // add to collection
                [].slice.call(grid.querySelectorAll('.grid__item')).forEach(function(item) {
                    item.querySelector('.action--star').addEventListener('click', addTocollection);
                });
            }

            function addTocollection() {
                var el = $(this);
                // Star button clicked
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/projects/star/') }}/" + $(this).attr('data-id'),
                    data: {_token:"{{ csrf_token() }}"},
                    success: function (data) {
                        if (el.hasClass("has-starred")) {
                            el.removeClass("has-starred");
                            el.attr('title', '添加收藏');
                        } else {
                            el.addClass("has-starred");
                            el.attr('title', '已收藏');
                        }
                        classie.add(collection, 'collection--animate');
                        setTimeout(function() {
                            collectionItems.innerHTML = el.hasClass("has-starred") ? (Number(collectionItems.innerHTML) + 1) : (Number(collectionItems.innerHTML) - 1);
                        }, 200);
                        // create the notification
                        var notification = new NotificationFx({
                            //message : '<span class="fa fa-smile-o"></span><p>' + data.message + '</p>',
                            message : '<div class="ns-thumb"><img src="' + AVATAR_URL + '"/></div><div class="ns-content"><p>' +
                            data.message + '.</p></div>',
                            layout : 'other',
                            ttl: 3000,
                            effect : 'thumbslider',
                            type : 'notice',
                            onClose : function() {

                            }
                        });

                        // show the notification
                        notification.show();

                        onEndAnimation(collectionItems, function() {
                            classie.remove(collection, 'collection--animate');
                        });
                    },
                    dataType: 'json'
                });
            }

            function recalcFlickities() {
                for(var i = 0, len = flkties.length; i < len; ++i) {
                    flkties[i].resize();
                }
            }

            function preloadImages() {
                $('.preload-images').each(function (i, element) {
                    if ($(element).attr('data-src') != "") {
                        $.ajax({
                            url: $(element).attr('data-src'),
                            success: function (data) {
                                $(element).attr('src', $(element).attr('data-src'));
                                setTimeout(function () {
                                    flkties[i].resize();
                                    iso.layout();
                                }, 50);
                            }
                        });
                    }
                });
            }

            init();
            preloadImages();

        })(window);

        function searchDidClick() {
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
                window.location.href = "{{ url('/projects/search/') }}/" + inputValue;
            });
        }
    </script>
@stop