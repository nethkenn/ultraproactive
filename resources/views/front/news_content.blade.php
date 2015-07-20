@extends('front.layout')
@section('content')
<div class="top_wrapper   no-transparent">
    <!-- .header -->
    <!-- Page Head -->
    <div class="header_page basic background_image colored_bg" style="background-image:url();background-repeat: no-repeat;background:#f6f6f6; -webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover; color:#2f383d; ">
        <div class="container">
            <style>
            .breadcrumbs_c {
            color: #000000;
            font-size: 13px;
            }
            h1.title {
            color: #000000 !important;
            font-size: 50px
            }
            </style>
            <h1 class="title">News Content</h1>
        </div>
    </div>
    <section id="content" class="normal" style=background:#ffffff>
        <div class="container" id="blog">
            <div class="row">
                <div class="span12">
                    <article id="post-3049" class="post-3049 post type-post status-publish format-standard has-post-thumbnail hentry category-new blog-article v1 normal">
                        <div class="media">
                            <img src="{{ $news->image }}" alt="">
                        </div>
                        <div class="content post_format_standart">
                            <dl class="dl-horizontal">
                                <dt>
                                <div class="dt"><span class="date">{{ $news->day }}</span><span class="month">{{ $news->month }}</span></div>
                                <div class="icon_"><i class="moon-pencil"></i></div>
                                </dt>
                                <dd>
                                <h1><a href="javascript:" style="padding: 0 20px;">{{ $news->news_title }}</a></h1>
                                <div class="blog-content" style="white-space: pre-wrap;">{!! $news->news_description !!}</div>.
                                <ul class="info">
                                    <li><i class="moon-user"></i>Posted by Prolife&nbsp; <i class="moon-calendar"></i> Posted on {{ $news->day }} {{ $news->month }}&nbsp; </li>
                                    <li></li>
                                </ul>
                                </dd>
                            </dl>
                        </article>
                        <div class="p_pagination">
                            <div class="pull-right">
                                <div class="nav-previous"></div>
                                <div class="nav-next"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Social Profiles -->
        <!-- Footer -->
    </div>
@endsection