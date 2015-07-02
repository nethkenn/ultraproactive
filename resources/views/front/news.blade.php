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
                <h1 class="title">News and Updates</h1>
          
            </div>
        </div>
        <section id="content" class="normal" style=background:#ffffff>
            <div class="container" id="blog">
                <div class="row">
                    
                    <div class="span9">
                        @foreach($_news as $news)
                        <article id="post-3049" class="post-3049 post type-post status-publish format-standard has-post-thumbnail hentry category-new row-fluid blog-article v2 normal">
                            <div class="span12">
                                <div class="span6">
                                    <div class="media">
                                        <img src="{{ $news->image }}" alt="">
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="content post_format_standart">
                                        <h1><a href="/news_content?id={{ $news->news_id }}">{{ $news->news_title }}</a></h1>
                                        <ul class="info">
                                            <li><i class="linecon-icon-user"></i>Posted by Prolife</li>
                                            {{-- <li><i class="linecon-icon-bubble"></i>1 Comments</li> --}}
                                        </ul>
                                        <div class="blog-content">{!! substr($news->news_description, 0, 290) !!}</div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        @endforeach
                        <div class="p_pagination">
                            <div class="pull-right">
                                <div class="nav-previous"></div>
                                <div class="nav-next"></div>
                            </div>
                        </div>
                    </div>
                    <aside class="span3 sidebar" id="widgetarea-sidebar">
                        <div id="widget_flickr-2" class="widget widget_flickr">
                            <h5 class="widget-title">Recent Products</h5>
                            <div class="flickr_container">
                                <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=6&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=52617155@N08"></script>
                            </div>
                        </div>
                        <div id="recent-posts-2" class="widget widget_recent_entries">
                            <h5 class="widget-title">Recent News</h5>
                            <ul>
                                <li>
                                    <a href="post.html">First Post with Featured Image</a>
                                </li>
                                <li>
                                    <a href="post.html">Second Post with Featured Image</a>
                                </li>
                                <li>
                                    <a href="post.html">New Post with Featured Image</a>
                                </li>
                                <li>
                                    <a href="post.html">Quis lectus elemvolu euismod atras</a>
                                </li>
                                <li>
                                    <a href="post.html">Another Post with Preview picture</a>
                                </li>
                            </ul>
                        </div>
                        
                    </aside>
                </div>
            </div>
        </section>
        <!-- Social Profiles -->
        <!-- Footer -->
    </div>
@endsection