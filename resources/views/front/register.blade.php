@extends('front.layout')
@section('content')
<div class="header_page basic background_image" style="background-image:url(/resources/assets/ausart/assets/img/default_header.jpg);background-repeat: no-repeat; -webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover; color:#2f383d; ">
            <div class="container">
                <style>
                .breadcrumbs_c {
                    color: #fff;
                    font-size: 13px;
                }
                
                h1.title {
                    color: #fff !important;
                    font-size: 50px
                }
                </style>
                <h1 class="title">Register</h1>
                <div class="breadcrumbss">
      
                </div>
            </div>
        </div>
<div class="top_wrapper   no-transparent">
<div class="container" style="margin: 50px auto;">
    <div class="row">
        <div id="fws_556c6ed542363" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el section-style    " style="padding-top: 60px !important; padding-bottom: 60px !important; ">
                <div class="container  dark">
                    <div class="section_clear">
                        <div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
                            <div class="wpb_wrapper">
                                <div class="contact_form wpb_content_element">
                                    <div class="row-fluid">
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <form name="contactForm" class="standard-form row-fluid" action="http://newthemes.themeple.co/ausart_html/contact.php" method="post">
                                                    <label>Name</label>
                                                    <input class="span6" name="themeple_name" placeholder="Name" type="text" id="themeple_name" value="" />
                                                    <input class="span6" name="themeple_email" placeholder="E-Mail" type="text" id="themeple_email" value="" />
                                                    <input class="span6" name="themeple_subject" placeholder="Subject" type="text" id="themeple_subject" value="" />
                                                    <select class="span12" placeholder="Priority" name="themeple_priority" id="themeple_priority">
                                                        <option value='Low'>Low</option>
                                                        <option value='Medium'>Medium</option>
                                                        <option value='High'>High</option>
                                                        <option value='Urgent as Hell'>Urgent as Hell</option>
                                                        <option value='ASAP DUDE!!!'>ASAP DUDE!!!</option>
                                                    </select>
                                                    <textarea class="span12" placeholder="Message" name="themeple_message" cols="40" rows="7" id="themeple_message"></textarea>
                                                    <p class="perspective">
                                                        <input type="submit" value="Submit" class="btn-system normal default" />
                                                    </p>
                                                </form>
                                                <div id="ajaxresponse"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
</div>
@endsection 