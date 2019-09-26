@extends('layouts.index')
@section('title')
    Microfinance Management Solution | About Us
@endsection

@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/stylesheet.css') }}"> --}}
@endsection

@section('content')
    <!-- head section -->
    <section class="content-top-margin page-title page-title-small bg-gray">
      <div class="container">
          <div class="row">
              <div class="col-lg-8 col-md-7 col-sm-12 wow fadeInUp" data-wow-duration="300ms">
                  <!-- page title -->
                  <h1 class="black-text">About</h1>
                  <!-- end page title -->
              </div>
              <div class="col-lg-4 col-md-5 col-sm-12 breadcrumb text-uppercase wow fadeInUp xs-display-none" data-wow-duration="600ms">
                  <!-- breadcrumb -->
                  <ul>
                     {{--  <li><a href="{{ route('index.index') }}">Home</a></li>
                      <li><a href="#">About</a></li> --}}
                  </ul>
                  <!-- end breadcrumb -->
              </div>
          </div>
      </div>
    </section>

    <!-- content section -->
    <section class="bg-black wow fadeIn">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-8 text-center center-col">
                    <div class="about-year text-uppercase white-text"><span class="clearfix">15</span> Years</div>
                    <p class="title-small letter-spacing-1 white-text font-weight-100">Open since 2000, we're digital
                        natives with a pioneering approach to open-source development.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="padding-three">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-md-6 col-sm-6">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 agency-title">Our
                        Strategy</span>
                </div>
                <!-- end section title -->
                <!-- section highlight text -->
                <div class="col-md-6 col-sm-6 text-right xs-text-left">
                </div>
                <!-- end section highlight text -->
            </div>
        </div>
    </section>
    <section class="cover-background" style="background-image:url('images/strategy.jpg');">
        <div class="opacity-full bg-dark-gray"></div>
        <div class="container position-relative">
            <div class="row">
                <div class="col-md-6 col-sm-11 center-col text-center">
                    <p class="text-large white-text margin-five no-margin-bottom">Lorem Ipsum is simply dummy text of
                        the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and
                        typesetting industry.<p>
                </div>
            </div>
        </div>

    </section>
    <!-- services section -->
    <section class="padding-three">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-md-6 col-sm-6 xs-margin-bottom-four">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">Key
                        components of our strategy</span>
                </div>
                <!-- end section title -->
                <!-- section highlight text -->
                <div class="col-md-6 col-sm-6 text-right xs-text-left">
                </div>
                <!-- end section highlight text -->
            </div>
        </div>
    </section>
    <!-- section text -->
    <section class="bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 text-center xs-margin-bottom-ten">
                    <p class="text-uppercase letter-spacing-2 black-text font-weight-600 margin-five no-margin-bottom">
                        Web Interactive</p>
                    <p class="margin-two text-med width-90 center-col">Lorem Ipsum is simply dummy text of the printing
                        &amp; typesetting industry.</p>
                </div>
                <div class="col-md-4 col-sm-4 text-center xs-margin-bottom-ten">
                    <p class="text-uppercase letter-spacing-2 black-text font-weight-600 margin-five no-margin-bottom">
                        Logo and Identity</p>
                    <p class="margin-two text-med width-90 center-col">Lorem Ipsum is simply dummy text of the printing
                        &amp; typesetting industry.</p>
                </div>
                <div class="col-md-4 col-sm-4 text-center">
                    <p class="text-uppercase letter-spacing-2 black-text font-weight-600 margin-five no-margin-bottom">
                        Graphic Design</p>
                    <p class="margin-two text-med width-90 center-col">Lorem Ipsum is simply dummy text of the printing
                        &amp; typesetting industry.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- end section text -->

    <!-- services section -->
    <section class="padding-three">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-md-6 col-sm-6 xs-margin-bottom-four">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">Our
                        People</span>
                </div>
                <!-- end section title -->
                <!-- section highlight text -->
                <div class="col-md-6 col-sm-6 text-right xs-text-left">
                </div>
                <!-- end section highlight text -->
            </div>
        </div>
    </section>
    <section class="bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 pull-left text-center sm-margin-bottom-eight wow fadeInUp" data-wow-duration="300ms">
                    <p class="center-col width-90 text-med">Lorem Ipsum is simply dummy text of the printing and typesetting
                        industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                        unknown printer took a galley.</p>
                    <div class="margin-two"><i class="fa fa-star yellow-text"></i><i
                            class="fa fa-star yellow-text"></i><i class="fa fa-star yellow-text"></i><i
                            class="fa fa-star yellow-text"></i><i class="fa fa-star yellow-text"></i></div>
                    <span class="name black-text">Alexander Harvard-CEO</span>
                </div>
                <div class="col-md-6 col-sm-12 pull-right text-center wow fadeInUp" data-wow-duration="600ms">
                    <p class="margin-right-seven no-margin-bottom  text-med">Lorem Ipsum is simply dummy text of the printing and
                        typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy
                        text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing
                        and typesetting industry. Lorem Ipsum has been the standard dummy text.</p>
                        <a href="{{ route('index.directors') }}" class="margin-three highlight-button-dark btn-big btn-round button xs-margin-bottom-five">Find all our staff and board of directors</a>

                </div>
            </div>
        </div>
    </section>
    <section class="padding-three">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-md-6 col-sm-6 xs-margin-bottom-four">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">Research Expertise</span>
                </div>
                <!-- end section title -->
                <!-- section highlight text -->
                <div class="col-md-6 col-sm-6 text-right xs-text-left">
                </div>
                <!-- end section highlight text -->
            </div>
        </div>
    </section>    
@endsection

@section('js')
   
@endsection