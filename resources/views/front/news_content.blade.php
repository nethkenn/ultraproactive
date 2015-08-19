@extends('front.layout')
@section('content')
<section id="title_breadcrumbs_bar">
    <div class="container">
        <div class="row">
            <div class="span8">
                <h1>News Content</h1>
            </div>
            <div class="span4 right_aligned">
                <div class="breadcrumbs">
                    
                </div>                                  
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="span12 content_with_right_sidebar">
                <div class="post_content">
                    <div class="post post_main" style="border-bottom: 0;">
                        <img src="{{ $news->image }}" alt="">                               
                        <div class="postmeta-above clearfix">
                            <p class="post_meta_date"><i class="ABdev_icon-time"></i>{{ $news->month }} {{ $news->day }}, {{ $news->year }}</p>
                            <p class="post_meta_author"><i class="ABdev_icon-user"></i>
                                <a href="right_sidebar_blog.html" title="Posts by Connell Zane" rel="author">UltraProactive</a>
                            </p>
                            <!-- <p class="post_meta_category"><i class="ABdev_icon-pen"></i>
                                <a href="fullwidth_blog.html" title="View all posts in Fullwidth Blog" rel="category">Fullwidth Blog</a>, 
                                <a href="left_sidebar_blog.html" title="View all posts in Left Sidebar Blog" rel="category">Left Sidebar Blog</a>, 
                                <a href="right_sidebar_blog.html" title="View all posts in Right Sidebar Blog" rel="category">Right Sidebar Blog</a>, 
                                <a href="timeline_blog.html" title="View all posts in Timeline Blog" rel="category">Timeline Blog</a>
                            </p> -->
                            <!-- <p class="post_meta_comments"><i class="ABdev_icon-comment"></i>3</p> -->
                        </div>
                        <h2>{{ $news->news_title }}</h2>                               
                        <p>
                            {{ $news->news_description }}
                        </p>    
                    </div>
                </div>
            </div>
            <!-- <aside class="span4 sidebar sidebar_right">
                <div class="widget widget_search">
                    <div class="widget_search">
                        <form name="search" id="search" method="get" action="#">
                            <input name="s" placeholder="Search" type="text">
                            <a class="submit"><i class="ABdev_icon-search"></i></a>
                        </form>
                    </div>
                </div>
                <div class="widget widget_categories">
                    <div class="sidebar-widget-heading">
                        <h3>Categories</h3>
                    </div>      
                    <ul>
                        <li><a href="fullwidth_blog.html" title="View all posts filed under Fullwidth Blog">Fullwidth Blog</a></li>
                        <li><a href="left_sidebar_blog.html" title="View all posts filed under Left Sidebar Blog">Left Sidebar Blog</a></li>
                        <li><a href="right_sidebar_blog.html" title="View all posts filed under Right Sidebar Blog">Right Sidebar Blog</a></li>
                        <li><a href="timeline_blog.html" title="View all posts filed under Timeline Blog">Timeline Blog</a></li>
                    </ul>
                </div>
                <div class="widget">
                    <div class="sidebar-widget-heading">
                        <h3>Recent posts</h3>
                    </div>
                    <div class="rpwe-block">
                        <ul>
                            <li>
                                <a href="blog_post.html" title="Permalink to Created especially for you" rel="bookmark">
                                    <img src="/resources/assets/path/images/blog2-1-150x150.jpg" class="rpwe-thumb wp-post-image" alt="Created especially for you" title="Created especially for you">                             
                                </a>
                                <h3 class="rpwe-title">
                                    <a href="blog_post.html" title="Permalink to Created especially for you" rel="bookmark">Created especially for you</a>
                                </h3>
                                <time class="rpwe-time" datetime="2013-10-01T12:03:57+00:00">October 1, 2013</time>
                            </li>
                            <li>
                                <a href="blog_post.html" title="Permalink to Awesome theme with endless possibilities." rel="bookmark">
                                    <img src="/resources/assets/path/images/blog1-1-150x150.jpg" class="rpwe-thumb wp-post-image" alt="Awesome theme with endless possibilities." title="Awesome theme with endless possibilities.">                               
                                </a>
                                <h3 class="rpwe-title">
                                    <a href="blog_post.html" title="Permalink to Awesome theme with endless possibilities." rel="bookmark">Awesome theme with endless possibilities.</a>
                                </h3>
                                <time class="rpwe-time" datetime="2013-08-28T08:16:34+00:00">August 28, 2013</time>
                            </li>
                            <li>
                                <a href="blog_post.html" title="Permalink to So many great places" rel="bookmark">
                                    <img src="/resources/assets/path/images/item_0006_9913190443_cb17108aad_h-e1393843274377-150x150.jpg" class="rpwe-thumb wp-post-image" alt="So many great places" title="So many great places">                                
                                </a>
                                <h3 class="rpwe-title">
                                    <a href="blog_post.html" title="Permalink to So many great places" rel="bookmark">So many great places</a>
                                </h3>
                                <time class="rpwe-time" datetime="2013-08-27T08:12:31+00:00">August 27, 2013</time>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="widget widget_tag_cloud">
                    <div class="sidebar-widget-heading">
                        <h3>Tags</h3>
                    </div>
                    <div class="tagcloud">
                        <a href="blog_post.html" title="2 topics" >eco-friendly</a>
                        <a href="blog_post.html" title="3 topics" >ecology</a>
                        <a href="blog_post.html" title="2 topics" >electric</a>
                        <a href="blog_post.html" title="1 topic" >energy</a>
                        <a href="blog_post.html" title="1 topic" >finance</a>
                        <a href="blog_post.html" title="2 topics" >fun</a>
                        <a href="blog_post.html" title="9 topics" >future</a>
                        <a href="blog_post.html" title="2 topics" >global</a>
                        <a href="blog_post.html" title="7 topics" >green</a>
                        <a href="blog_post.html" title="3 topics" >innovation</a>
                        <a href="blog_post.html" title="1 topic" >market</a>
                        <a href="blog_post.html" title="2 topics" >new</a>
                        <a href="blog_post.html" title="2 topics" >oil</a>
                        <a href="blog_post.html" title="2 topics" >snow</a>
                        <a href="blog_post.html" title="1 topic" >stock</a>
                        <a href="blog_post.html" title="2 topics" >transport</a>
                        <a href="blog_post.html" title="2 topics" >warming</a>
                        <a href="blog_post.html" title="2 topics" >warning</a>
                    </div>
                </div>
                <div class="widget flickr-stream">
                    <div class="sidebar-widget-heading">
                        <h3>Flickr Stream</h3>
                    </div>
                    <div class="flickr_stream clearfix">
                        <a href="#" target="_blank"><img src="/resources/assets/path/images/14596923138_d4d46d271c_s.jpg" alt=""></a>
                        <a href="#" target="_blank"><img src="/resources/assets/path/images/14760569666_7c6c02da27_s.jpg" alt=""></a>
                        <a href="#" target="_blank"><img src="/resources/assets/path/images/14783568265_90657d440f_s.jpg" alt=""></a>
                        <a href="#" target="_blank"><img src="/resources/assets/path/images/14781214704_955df76638_s.jpg" alt=""></a>
                        <a href="#" target="_blank"><img src="/resources/assets/path/images/14471910420_cf12dd0a16_s.jpg" alt=""></a>
                        <a href="#" target="_blank"><img src="/resources/assets/path/images/13090561633_e9c5d3c072_s.jpg" alt=""></a>
                        <a href="#" target="_blank"><img src="/resources/assets/path/images/13090570003_021f405fbf_s.jpg" alt=""></a>
                        <a href="#" target="_blank"><img src="/resources/assets/path/images/13090762874_5f9d99f4e5_s.jpg" alt=""></a>
                    </div>
                </div>          
            </aside> -->
        </div>
    </div>
</section>
@endsection