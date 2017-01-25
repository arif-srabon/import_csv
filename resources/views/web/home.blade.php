<?php
/**
 * Layout: Home Page
 *
 * @package  adr_dgda
 * @author   Mayeenul Islam
 */
?>

@extends('layouts.web')

<!-- display page title -->
@section('page_title', trans('web/common.site_title'))

<!-- make menu active -->
@section('menu_home','active')

@section('content')

    <div id="content">

        <section id="hero" class="front-page-sections">
            <div class="container-fluid content-wrapper">
                <div class="row">
                    <div class="col-sm-7">
                        <img src="{{ asset('assets/images/adr-image.png') }}" alt="ADR - DGDA">
                    </div>
                    <!-- /.col-sm-7 -->
                    <div class="col-sm-5">
                        <div id="adr-checker">
                            <h3>{{ trans('web/home.fake_checker_title') }}</h3>
                            <p>{{ trans('web/home.fake_checker_desc') }}</p>
                            
                            <form action="/web/check-fake-medicine" method="post" id="check-fake-medicine-form">
                                <div class="form-group">
                                    <label for="medicine-unique-id">{{ trans('web/home.label_checker_field') }}</label>
                                    <input type="text" class="form-control" id="medicine-unique-id" name="medicine_unique_id" placeholder="e.g. 4654212113548" autocomplete="off" required>
                                </div>
                                <button type="submit" class="btn btn-danger"><i class="fa fa-bullseye"></i> {{ trans('web/home.checker_btn') }}</button>
                            </form>

                            <!-- Display the result of Fake Medicine Checker using AJAX -->
                            <div id="fake-checker-result"></div>
                        </div>
                        <!-- /#adr-cheker -->
                    </div>
                    <!-- /.col-sm-5 -->
                </div>
            </div>
            <!-- /.container-fluid content-wrapper -->
        </section>
        <!-- /#hero.front-page-sections -->

        <section id="intro" class="front-page-sections text-center">
            <div class="container-fluid content-wrapper">
    			<div class="row">
    				<div class="col-sm-12">
    					<h1 class="section-head">Welcome to Adverse Drug Reaction Reporting</h1>
    					<p>Adverse Drug Reaction Reporting enthusiastically repurpose turnkey processes through world-class deliverables. Competently supply strategic ROI with sustainable leadership. Objectively transform quality partnerships through open-source growth strategies. Collaboratively impact interactive.</p>
    					<a href="#" class="btn btn-primary text-uppercase"><i class="fa fa-paper-plane"></i> Learn more</a>
    				</div>
    				<!-- /.col-sm-12 -->
    			</div>
            </div>
            <!-- /.container-fluid content-wrapper -->
        </section>
        <!-- /#intro.front-page-sections -->

        <section id="boxes" class="front-page-sections fps-min-padding text-center">
            <div class="container-fluid content-wrapper">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="front-box">
                            <i class="fa fa-dot-circle-o box-icon"></i>
                            <h3 class="box-head">Adverse Drug Reaction Reporting</h3>
                            <p>Conveniently monetize resource maximizing users rather than multimedia based manufactured products. Distinctively facilitate cross-platform content vis-a-vis 2.0 total linkage.</p>
                            <a href="{{ url('/complaints/adr') }}" class="btn btn-around text-uppercase"><i class="fa fa-flag"></i> Report</a>
                        </div>
                        <!-- /.front-box -->
                    </div>
                    <!-- /.col-sm-4 -->
                    <div class="col-sm-4">
                        <div class="front-box">
                            <i class="fa fa-frown-o box-icon"></i>
                            <h3 class="box-head">Complain</h3>
                            <p>Efficiently engage empowered methods of empowerment and 24/365 ROI. Holisticly promote top-line ROI whereas e-business data. Distinctively matrix frictionless ideas vis-a-vis cost effective niche markets.</p>
                            <a href="{{ url('/complaints/complain') }}" class="btn btn-around text-uppercase"><i class="fa fa-flag"></i> Complain</a>
                        </div>
                        <!-- /.front-box -->
                    </div>
                    <!-- /.col-sm-4 -->
                    <div class="col-sm-4">
                        <div class="front-box">
                            <i class="fa fa-sun-o box-icon"></i>
                            <h3 class="box-head">Counterfeit Reporting</h3>
                            <p>Synergistically harness sustainable solutions before cross functional mindshare. Objectively supply proactive convergence before enterprise mindshare. Credibly strategize clicks-and-mortar technology.</p>
                            <a href="{{ url('/complaints/counterfeit') }}" class="btn btn-around text-uppercase"><i class="fa fa-flag"></i> Report</a>
                        </div>
                        <!-- /.front-box -->
                    </div>
                    <!-- /.col-sm-4 -->
                </div>
            </div>
            <!-- /.container-fluid content-wrapper -->
        </section>
        <!-- /#boxes.front-page-sections -->


        <section id="supplementary" class="front-page-sections text-center">
            <div class="container-fluid content-wrapper">
                <h1 class="section-head">Disclaimer</h1>
                <p>We cannot give you medical advice. If you are worried about your health, please either talk to a doctor, pharmacist, nurse, or, call to an emergency number of any hospital, or clinic</p>
            </div>
            <!-- /.container-fluid content-wrapper -->
        </section>
        <!-- /#supplementary.front-page-sections -->

    </div>
    <!-- /#content -->

    <script>

        $(document).ready(function() {
            var options = {
                target:        '#fake-checker-result',
                beforeSubmit:  showRequest,  // pre-submit callback
                success:       showResponse  // post-submit callback
            };

            // bind to the form's submit event
            $('#check-fake-medicine-form').submit(function() {
                $(this).ajaxSubmit(options);
                return false;
            });
        });

        function showRequest(){}
        function showResponse(){}

    </script>
@endsection
