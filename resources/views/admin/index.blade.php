@section('title')
    {{trans('general.dashboard')}} {{trans('general.siteName')}}
@stop
@extends('admin.general.master')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Dashboard Analytics Start -->
                <section id="dashboard-analytics">
                    <div class="row">
                        <!-- Website Analytics Starts-->
                        <div class="col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title"><a href="{{asset('admin/user')}}">{{trans('general.user')}}</a></h4>
                                    <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                                </div>
                                <div class="card-content">
                                    <div class="card-body pb-1">
                                        <div class="d-flex justify-content-around align-items-center flex-wrap">
                                            <div class="user-analytics">
                                                <i class="bx bx-user mr-25 align-middle"></i>
                                                <span class="align-middle text-muted">{{trans('invoice.total')}}</span>
                                                <div class="d-flex">
                                                    <div id="radial-success-chart"></div>
                                                    <h3 class="mt-1 ml-50">{{number_format($totalUser,2)}}</h3>
                                                </div>
                                            </div>
                                            <div class="sessions-analytics">
                                                <i class="bx bx-user align-middle mr-25"></i>
                                                <span class="align-middle text-muted">{{trans('general.active')}}</span>
                                                <div class="d-flex">
                                                    <div id="radial-warning-chart"></div>
                                                    <h3 class="mt-1 ml-50">{{number_format($totalUserActive,2)}}</h3>
                                                </div>
                                            </div>
                                            <div class="bounce-rate-analytics">
                                                <i class="bx bx-user align-middle mr-25"></i>
                                                <span class="align-middle text-muted">{{trans('general.locked')}}</span>
                                                <div class="d-flex">
                                                    <div id="radial-danger-chart"></div>
                                                    <h3 class="mt-1 ml-50">{{number_format($totalUserLocked,2)}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                        </div>
                

                    </div>
                    
                    </div>
                </section>
                <!-- Dashboard Analytics end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@stop