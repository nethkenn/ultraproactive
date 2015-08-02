@extends('front.layout')
@section('content')
<div class="top_wrapper   no-transparent">
        <!-- .header -->
        <!-- Page Head -->
        <div class="header_page basic background_image colored_bg" style="background-image:url();background-repeat: no-repeat;background:#f6f6f6; -webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover; color:#2f383d; ">
            <div class="container">
                
                <h1 class="title">About Us</h1>
                
            </div>
        </div>
        <section id="content" class="composer_content">
            <div id="fws_556c47c7c0707" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el standard_section    " style="padding-top: 0px !important; padding-bottom: 0px !important; ">
                <div class="container  dark">
                    <div class="section_clear">
                        <div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
                            <div class="wpb_wrapper">
                                <div class="wpb_content_element dynamic_page_header style_2">
                                    <h1 style="font-size:30px; color:#3a3a3a">WE ARE INTRODUCING YOU TO PROLIFE</h1></div>
                                <div class="wpb_text_column wpb_content_element ">
                                    <div class="wpb_wrapper">
                                        <p style="word-break: keep-all !important;">{{ $about->about_description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="fws_556c47c7c1e59" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el section-style    " style="background-color: #f6f6f6; padding-top: 30px !important; padding-bottom: 0px !important; ">
                <div class="container  dark">
                    <div class="section_clear">
                        <div class="vc_col-sm-4 wpb_column column_container" style="" data-animation="" data-delay="0">
                            <div class="wpb_wrapper">
                                <div class=" services_small wpb_content_element">
                                    <div class="services_small_container">
                                        <div class=" services_small_icon yes" style=""><i class="fa fa-flag"></i></div>
                                        <div class="services_small_title">
                                            <h4><a href="#">Mission</a></h4>
                                            <p style="word-break: keep-all !important;">{{ $mission->about_description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="vc_col-sm-4 wpb_column column_container" style="" data-animation="" data-delay="0">
                            <div class="wpb_wrapper">
                                <div class=" services_small wpb_content_element">
                                    <div class="services_small_container">
                                        <div class=" services_small_icon yes" style=""><i class="fa fa-eye"></i> </div>
                                        <div class="services_small_title">
                                            <h4><a href="#">Vision</a></h4>
                                            <p style="word-break: keep-all !important;">{{ $vision->about_description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="vc_col-sm-4 wpb_column column_container" style="" data-animation="" data-delay="0">
                            <div class="wpb_wrapper">
                                <div class=" services_small wpb_content_element">
                                    <div class="services_small_container">
                                        <div class=" services_small_icon yes" style=""><i class="fa fa-book"></i></div>
                                        <div class="services_small_title">
                                            <h4><a href="#">Philosophy</a></h4>
                                            <p style="word-break: keep-all !important;">{!! $philosophy->about_description !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div id="fws_556c47c7c4569" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el section-style    borders  " style="background-image: url(/resources/assets/ausart/assets/uploads/2015/01/shutterstock_178717754.jpg); background-position: center center; background-repeat: no-repeat; padding-top: 100px !important; padding-bottom: 100px !important; ">
                <div class="bg-overlay" style="background:rgba(247, 247, 247, 0.5);z-index:1;"></div>
                <div class="container  dark">
                    <div class="section_clear">
                        <div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
                            <div class="wpb_wrapper">
                                <div class="wpb_content_element block_skill">
                                    <div class="skill animate_onoffset" data-percentage="75">
                                        <h6 class="skill_title">User Interface Design</h6>
                                        <div class="prog" style="width:0%; background:#94e0fe;"><span style="float:right">75%</span></div>
                                    </div>
                                    <div class="skill animate_onoffset" data-percentage="90">
                                        <h6 class="skill_title">Branding &amp; Indentity</h6>
                                        <div class="prog" style="width:0%; background:#23d5ff;"><span style="float:right">90%</span></div>
                                    </div>
                                    <div class="skill animate_onoffset" data-percentage="50">
                                        <h6 class="skill_title">Project Managment</h6>
                                        <div class="prog" style="width:0%; background:#0baaff;"><span style="float:right">50%</span></div>
                                    </div>
                                    <div class="skill animate_onoffset" data-percentage="60">
                                        <h6 class="skill_title">Project Managment</h6>
                                        <div class="prog" style="width:0%; background:#0a81cd;"><span style="float:right">60%</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div id="fws_556c47c7c5bef" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el section-style    " style="padding-top: 30px !important; padding-bottom: 60px !important; ">
                <div class="container  dark">
                    <div class="section_clear">
                        <div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
                            <div class="wpb_wrapper">
                                <div class="header " style="">
                                    <h2>Team Members</h2></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="fws_556866fa6eded" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el section-style    " style="padding-top: 0px !important; padding-bottom: 90px !important; ">
                <div class="container  dark">
                    <div class="section_clear">
                        @foreach($_team as $team)
                        <div class="vc_col-sm-3 wpb_column column_container" style="" data-animation="" data-delay="0">
                            <div class="wpb_wrapper">
                                <div class="wpb_content_element">
                                    <div class="one-staff">
                                        <div class="img_staff"><img src="{{ $team->image }}" alt=""></div>
                                        <div class="content ">
                                            <h6>{{ $team->team_title }}</h6>
                                            <div class="position_title"><span class="position">{{ $team->team_role }}</span></div>
                                            <p>{{ $team->team_description }}</p>
                                        </div>
                                        <div class="social_widget">
                                            <ul>
                                                <li class="facebook"><a href="#" title="Facebook"><i class="moon-facebook"></i></a></li>
                                                <li class="twitter"><a href="#" title="Twitter"><i class="moon-twitter"></i></a></li>
                                                <li class="google_plus"><a href="#" title="Google Plus"><i class="moon-google_plus"></i></a></li>
                                                <li class="pinterest"><a href="#" title="Pinterest"><i class="moon-pinterest"></i></a></li>
                                                <li class="linkedin"><a href="#" title="Linkedin"><i class="moon-linkedin"></i></a></li>
                                                <li class="main"><a href="#" title="Mail"><i class="moon-mail"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- Social Profiles -->
        <!-- Footer -->
    </div>
@endsection