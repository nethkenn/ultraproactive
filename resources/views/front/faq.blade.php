@extends('front.layout')
@section('content')
@if($type == "product")
<section id="title_breadcrumbs_bar" class="rw" style="margin: 0 -15px; background-image: none; background-color: #2774DA; margin-top: -70px;">
    <div class="container">
        <div class="row">
            <div class="span12">
                <h1>F.A.Q.</h1>
            </div>
        </div>
    </div>
</section>

<section class="dzen_section_DD section_title_left" style="background-color: #fff; margin: 0 -15px;">
    <header>
        <div class="dzen_container">
            <h3>F.A.Q for Products</h3>
        </div>
    </header>
    <div class="dzen_section_content">
        <div class="dzen_container">
            <div class="dzen_column_DD_span12 ">
                <div class="dzen-accordion" data-expanded="2" role="tablist">
                    @foreach($_product as $product)
                    <h3 class="ui-accordion-header" style="margin-bottom: 0;" role="tab" id="ui-accordion-1-header-0" aria-controls="ui-accordion-1-panel-{{ $product->faq_id }}" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon-triangle-1-e"></span>{{ $product->faq_title }}
                    </h3>
                    <div class="ui-accordion-content" id="ui-accordion-1-panel-0" aria-labelledby="ui-accordion-1-header-{{ $product->faq_id }}" role="tabpanel" aria-expanded="false" aria-hidden="true" style="white-space: pre-wrap !important;">
                        {{ $product->faq_content }}
                    </div>
                    @endforeach
                    <!-- <h3 class="ui-accordion-header ui-accordion-header-active" role="tab" id="ui-accordion-1-header-1" aria-controls="ui-accordion-1-panel-1" aria-selected="true" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon-triangle-1-s"></span>Accordion Title Two
                    </h3>
                    <div class="ui-accordion-content" id="ui-accordion-1-panel-1" aria-labelledby="ui-accordion-1-header-1" role="tabpanel" aria-expanded="true" aria-hidden="false">
                        Never in all their history have men been able truly to conceive of the world as one: a single sphere, a globe, having the qualities of a globe, a round earth in which all the directions eventually meet, in which there is no center because every point, or none, is center — an equal earth which all men occupy as equals. The airman’s earth, if free men make it, will be truly round: a globe in practice, not in theory.
                    </div>
                    <h3 class="ui-accordion-header" role="tab" id="ui-accordion-1-header-2" aria-controls="ui-accordion-1-panel-2" aria-selected="false" tabindex="-1">
                        <span class="ui-accordion-header-icon ui-icon-triangle-1-e"></span>Accordion Title Three
                    </h3>
                    <div class="ui-accordion-content" id="ui-accordion-1-panel-2" aria-labelledby="ui-accordion-1-header-2" role="tabpanel" aria-expanded="false" aria-hidden="true">
                        Donec turpis massa, accumsan sit amet lobortis scelerisque, vehicula a ante. Nulla ac nulla vitae enim imperdiet aliquam ac nec enim. Ut viverra metus nec dolor elementum faucibus. Donec scelerisque pellentesque odio, non vulputate est mattis sit amet. Nullam pharetra, mi sed lacinia dapibus, nulla urna congue neque, vel dictum libero tortor vitae elit. Duis sagittis eu ligula in blandit.
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@if($type == "mindsync")
<section id="title_breadcrumbs_bar" class="rw" style="margin: 0 -15px; background-image: none; background-color: #2774DA; margin-top: -70px;">
    <div class="container">
        <div class="row">
            <div class="span8">
                <h1>F.A.Q.</h1>
            </div>
            <div class="span4 right_aligned">
                                      
            </div>
        </div>
    </div>
</section>

<section class="dzen_section_DD section_title_left" style="margin: 0 -15px; background-color: #fff;">
    <header>
        <div class="dzen_container">
            <h3>F.A.Q for Mind Sync</h3>
        </div>
    </header>
    <div class="dzen_section_content">
        <div class="dzen_container">
            <div class="dzen_column_DD_span12 ">
                <div class="dzen-accordion" data-expanded="2" role="tablist">
                    @foreach($_mindsync as $mindsync)
                    <h3 class="ui-accordion-header" style="margin-bottom: 0;" role="tab" id="ui-accordion-1-header-0" aria-controls="ui-accordion-1-panel-{{ $mindsync->faq_id }}" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon-triangle-1-e"></span>{{ $mindsync->faq_title }}
                    </h3>
                    <div class="ui-accordion-content" id="ui-accordion-1-panel-0" aria-labelledby="ui-accordion-1-header-{{ $mindsync->faq_id }}" role="tabpanel" aria-expanded="false" aria-hidden="true" style="white-space: pre-wrap !important;">
                        {{ $mindsync->faq_content }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@if($type == "opportunity")
<section id="title_breadcrumbs_bar" class="rw" style="margin: 0 -15px; background-image: none; background-color: #2774DA; margin-top: -70px;">
    <div class="container">
        <div class="row">
            <div class="span8">
                <h1>F.A.Q.</h1>
            </div>
            <div class="span4 right_aligned">
                                      
            </div>
        </div>
    </div>
</section>

<section class="dzen_section_DD section_title_left" style="background-color: #fff; margin: 0 -15px;">
    <header>
        <div class="dzen_container">
            <h3>F.A.Q for Opportunity</h3>
        </div>
    </header>
    <div class="dzen_section_content">
        <div class="dzen_container">
            <div class="dzen_column_DD_span12 ">
                <div class="dzen-accordion" data-expanded="2" role="tablist">
                    @foreach($_opportunity as $opportunity)
                    <h3 class="ui-accordion-header" style="margin-bottom: 0;" role="tab" id="ui-accordion-1-header-0" aria-controls="ui-accordion-1-panel-{{ $opportunity->faq_id }}" aria-selected="false" tabindex="0">
                        <span class="ui-accordion-header-icon ui-icon-triangle-1-e"></span>{{ $opportunity->faq_title }}
                    </h3>
                    <div class="ui-accordion-content" id="ui-accordion-1-panel-0" aria-labelledby="ui-accordion-1-header-{{ $opportunity->faq_id }}" role="tabpanel" aria-expanded="false" aria-hidden="true" style="white-space: pre-wrap !important;">
                        {{ $opportunity->faq_content }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection 