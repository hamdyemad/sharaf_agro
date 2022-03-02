@extends('layouts.master')

@section('title') لوحة التحكم @endsection

@section('content')

    @if(Auth::user()->type == 'admin')
        <!-- start page title -->
        <div class="row">

            @component('common-components.breadcrumb')
                @slot('title') لوحة التحكم @endslot
            @endcomponent

            {{-- @component('common-components.chart')
                @slot('chart1_id') header-chart-1 @endslot
                @slot('chart1_title') Balance $ 2,317 @endslot
                @slot('chart2_id') header-chart-2 @endslot
                @slot('chart3_title') Item Sold 1230 @endslot
            @endcomponent --}}


        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12 col-md-6 col-lg-3">
                @component('common-components.widget')
                    @slot('route') {{ route('branches.index') }} @endslot
                    @slot('icons') mdi mdi-source-branch float-right @endslot
                    @slot('title') الفروع @endslot
                    @slot('price') {{ $branchesCount }} @endslot
                    @slot('badgeClass') badge-warning @endslot
                @endcomponent
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                @component('common-components.widget')
                    @slot('route') {{ route('categories.index') }} @endslot
                    @slot('icons') mdi mdi-inbox-multiple float-right @endslot
                    @slot('title') الأصناف @endslot
                    @slot('price') {{ $categoriesCount }} @endslot
                    @slot('badgeClass') badge-danger @endslot
                @endcomponent
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                @component('common-components.widget')
                    @slot('route') {{ route('products.index') }} @endslot
                    @slot('icons') mdi mdi-food float-right @endslot
                    @slot('title') الأكلات @endslot
                    @slot('price') {{ $productsCount }} @endslot
                    @slot('badgeClass') badge-info @endslot
                @endcomponent
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                @component('common-components.widget')
                    @slot('route') {{ route('products.index') }} @endslot
                    @slot('icons') mdi mdi-cart-outline float-right @endslot
                    @slot('title') الطلبات @endslot
                    @slot('price') {{ $ordersCount }} @endslot
                    @slot('badgeClass') badge-info @endslot
                @endcomponent
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">عدد طلبات الحالات</h4>
                        <div id="morris-donut-example" class="morris-charts morris-charts-height" dir="ltr"></div>
                    </div>
                </div>
            </div>

            {{-- <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Email Sent</h4>

                        <div class="row text-center mt-4">
                            <div class="col-4">
                                <h5 class="font-size-20">$ 89425</h5>
                                <p class="text-muted">Marketplace</p>
                            </div>
                            <div class="col-4">
                                <h5 class="font-size-20">$ 56210</h5>
                                <p class="text-muted">Total Income</p>
                            </div>
                            <div class="col-4">
                                <h5 class="font-size-20">$ 8974</h5>
                                <p class="text-muted">Last Month</p>
                            </div>
                        </div>

                        <div id="morris-area-example" class="morris-charts morris-charts-height" dir="ltr"></div>
                    </div>
                </div>
            </div> --}}

                {{-- <div class="col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Monthly Earnings</h4>

                            <div class="row text-center mt-4">
                                <div class="col-6">
                                    <h5 class="font-size-20">$ 2548</h5>
                                    <p class="text-muted">Marketplace</p>
                                </div>
                                <div class="col-6">
                                    <h5 class="font-size-20">$ 6985</h5>
                                    <p class="text-muted">Total Income</p>
                                </div>
                            </div>

                            <div id="morris-bar-stacked" class="morris-charts morris-charts-height" dir="ltr"></div>
                        </div>
                    </div>
                </div> --}}

        </div>
        <!-- end row -->

        {{-- <div class="row">

            <div class="col-xl-4 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Inbox</h4>
                        <div class="inbox-wid">
                            <a href="#" class="text-dark">
                                <div class="inbox-item">
                                    <div class="inbox-item-img float-left mr-3"><img
                                            src="{{ URL::asset('/images/users/user-1.jpg') }}"
                                            class="avatar-sm rounded-circle" alt=""></div>
                                    <h6 class="inbox-item-author mt-0 mb-1 font-size-16">Misty</h6>
                                    <p class="inbox-item-text text-muted mb-0">Hey! there I'm available...</p>
                                    <p class="inbox-item-date text-muted">13:40 PM</p>
                                </div>
                            </a>
                            <a href="#" class="text-dark">
                                <div class="inbox-item">
                                    <div class="inbox-item-img float-left mr-3"><img
                                            src="{{ URL::asset('/images/users/user-2.jpg') }}"
                                            class="avatar-sm rounded-circle" alt=""></div>
                                    <h6 class="inbox-item-author mt-0 mb-1 font-size-16">Melissa</h6>
                                    <p class="inbox-item-text text-muted mb-0">I've finished it! See you so...</p>
                                    <p class="inbox-item-date text-muted">13:34 PM</p>
                                </div>
                            </a>
                            <a href="#" class="text-dark">
                                <div class="inbox-item">
                                    <div class="inbox-item-img float-left mr-3"><img
                                            src="{{ URL::asset('/images/users/user-3.jpg') }}"
                                            class="avatar-sm rounded-circle" alt=""></div>
                                    <h6 class="inbox-item-author mt-0 mb-1 font-size-16">Dwayne</h6>
                                    <p class="inbox-item-text text-muted mb-0">This theme is awesome!</p>
                                    <p class="inbox-item-date text-muted">13:17 PM</p>
                                </div>
                            </a>
                            <a href="#" class="text-dark">
                                <div class="inbox-item">
                                    <div class="inbox-item-img float-left mr-3"><img
                                            src="{{ URL::asset('/images/users/user-4.jpg') }}"
                                            class="avatar-sm rounded-circle" alt=""></div>
                                    <h6 class="inbox-item-author mt-0 mb-1 font-size-16">Martin</h6>
                                    <p class="inbox-item-text text-muted mb-0">Nice to meet you</p>
                                    <p class="inbox-item-date text-muted">12:20 PM</p>
                                </div>
                            </a>
                            <a href="#" class="text-dark">
                                <div class="inbox-item">
                                    <div class="inbox-item-img float-left mr-3"><img
                                            src="{{ URL::asset('/images/users/user-5.jpg') }}"
                                            class="avatar-sm rounded-circle" alt=""></div>
                                    <h6 class="inbox-item-author mt-0 mb-1 font-size-16">Vincent</h6>
                                    <p class="inbox-item-text text-muted mb-0">Hey! there I'm available...</p>
                                    <p class="inbox-item-date text-muted">11:47 AM</p>
                                </div>
                            </a>

                            <a href="#" class="text-dark">
                                <div class="inbox-item">
                                    <div class="inbox-item-img float-left mr-3"><img
                                            src="{{ URL::asset('/images/users/user-6.jpg') }}"
                                            class="avatar-sm rounded-circle" alt=""></div>
                                    <h6 class="inbox-item-author mt-0 mb-1 font-size-16">Robert Chappa</h6>
                                    <p class="inbox-item-text text-muted mb-0">Hey! there I'm available...</p>
                                    <p class="inbox-item-date text-muted">10:12 AM</p>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xl-4 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Recent Activity Feed</h4>

                        <ol class="activity-feed mb-0">
                            <li class="feed-item">
                                <div class="feed-item-list">
                                    <span class="date">Jun 25</span>
                                    <span class="activity-text">Responded to need “Volunteer Activities”</span>
                                </div>
                            </li>
                            <li class="feed-item">
                                <div class="feed-item-list">
                                    <span class="date">Jun 24</span>
                                    <span class="activity-text">Added an interest “Volunteer Activities”</span>
                                </div>
                            </li>
                            <li class="feed-item">
                                <div class="feed-item-list">
                                    <span class="date">Jun 23</span>
                                    <span class="activity-text">Joined the group “Boardsmanship Forum”</span>
                                </div>
                            </li>
                            <li class="feed-item">
                                <div class="feed-item-list">
                                    <span class="date">Jun 21</span>
                                    <span class="activity-text">Responded to need “In-Kind Opportunity”</span>
                                </div>
                            </li>
                        </ol>

                        <div class="text-center">
                            <a href="#" class="btn btn-sm btn-primary">Load More</a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xl-4">
                <div class="card widget-user">
                    <div class="widget-user-desc p-4 text-center bg-primary position-relative">
                        <i class="fas fa-quote-left h2 text-white-50"></i>
                        <p class="text-white mb-0">The European languages are members of the same family. Their separate
                            existence is a myth. For science, music, sport, etc, Europe the same vocabulary. The languages only
                            in their grammar.</p>
                    </div>
                    <div class="p-4">
                        <div class="float-left mt-2 mr-3">
                            <img src="{{ URL::asset('/images/users/user-2.jpg') }}" alt="" class="rounded-circle avatar-sm">
                        </div>
                        <h6 class="mb-1 font-size-16 mt-2">Marie Minnick</h6>
                        <p class="text-muted mb-0">Marketing Manager</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Yearly Sales</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div>
                                    <h3>52,345</h3>
                                    <p class="text-muted">The languages only differ grammar</p>
                                    <a href="#" class="text-primary">Learn more <i
                                            class="mdi mdi-chevron-double-right"></i></a>
                                </div>
                            </div>
                            <div class="col-md-8 text-right">
                                <div id="sparkline"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div> --}}
        <!-- end row -->
        {{-- <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Latest Transactions</h4>

                        <div class="table-responsive">
                            <table class="table table-centered table-vertical table-nowrap">

                                <tbody>
                                    <tr>
                                        <td>
                                            <img src="{{ URL::asset('/images/users/user-2.jpg') }}" alt="user-image"
                                                class="avatar-xs rounded-circle mr-2" /> Herbert C. Patton
                                        </td>
                                        <td><i class="mdi mdi-checkbox-blank-circle text-success"></i> Confirm</td>
                                        <td>
                                            $14,584
                                            <p class="m-0 text-muted font-14">Amount</p>
                                        </td>
                                        <td>
                                            5/12/2016
                                            <p class="m-0 text-muted font-14">Date</p>
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-secondary btn-sm waves-effect waves-light">Edit</button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <img src="{{ URL::asset('/images/users/user-3.jpg') }}" alt="user-image"
                                                class="avatar-xs rounded-circle mr-2" /> Mathias N. Klausen
                                        </td>
                                        <td><i class="mdi mdi-checkbox-blank-circle text-warning"></i> Waiting payment</td>
                                        <td>
                                            $8,541
                                            <p class="m-0 text-muted font-14">Amount</p>
                                        </td>
                                        <td>
                                            10/11/2016
                                            <p class="m-0 text-muted font-14">Date</p>
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-secondary btn-sm waves-effect waves-light">Edit</button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <img src="{{ URL::asset('/images/users/user-4.jpg') }}" alt="user-image"
                                                class="avatar-xs rounded-circle mr-2" /> Nikolaj S. Henriksen
                                        </td>
                                        <td><i class="mdi mdi-checkbox-blank-circle text-success"></i> Confirm</td>
                                        <td>
                                            $954
                                            <p class="m-0 text-muted font-14">Amount</p>
                                        </td>
                                        <td>
                                            8/11/2016
                                            <p class="m-0 text-muted font-14">Date</p>
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-secondary btn-sm waves-effect waves-light">Edit</button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <img src="{{ URL::asset('/images/users/user-5.jpg') }}" alt="user-image"
                                                class="avatar-xs rounded-circle mr-2" /> Lasse C. Overgaard
                                        </td>
                                        <td><i class="mdi mdi-checkbox-blank-circle text-danger"></i> Payment expired</td>
                                        <td>
                                            $44,584
                                            <p class="m-0 text-muted font-14">Amount</p>
                                        </td>
                                        <td>
                                            7/11/2016
                                            <p class="m-0 text-muted font-14">Date</p>
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-secondary btn-sm waves-effect waves-light">Edit</button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <img src="{{ URL::asset('/images/users/user-6.jpg') }}" alt="user-image"
                                                class="avatar-xs rounded-circle mr-2" /> Kasper S. Jessen
                                        </td>
                                        <td><i class="mdi mdi-checkbox-blank-circle text-success"></i> Confirm</td>
                                        <td>
                                            $8,844
                                            <p class="m-0 text-muted font-14">Amount</p>
                                        </td>
                                        <td>
                                            1/11/2016
                                            <p class="m-0 text-muted font-14">Date</p>
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-secondary btn-sm waves-effect waves-light">Edit</button>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Latest Orders</h4>

                        <div class="table-responsive">
                            <table class="table table-centered table-vertical table-nowrap mb-1">

                                <tbody>
                                    <tr>
                                        <td>#12354781</td>
                                        <td>
                                            <img src="{{ URL::asset('/images/users/user-1.jpg') }}" alt="user-image"
                                                class="avatar-xs mr-2 rounded-circle" /> Riverston Glass Chair
                                        </td>
                                        <td><span class="badge badge-pill badge-success">Delivered</span></td>
                                        <td>
                                            $185
                                        </td>
                                        <td>
                                            5/12/2016
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-secondary btn-sm waves-effect waves-light">Edit</button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>#52140300</td>
                                        <td>
                                            <img src="{{ URL::asset('/images/users/user-2.jpg') }}" alt="user-image"
                                                class="avatar-xs mr-2 rounded-circle" /> Shine Company Catalina
                                        </td>
                                        <td><span class="badge badge-pill badge-success">Delivered</span></td>
                                        <td>
                                            $1,024
                                        </td>
                                        <td>
                                            5/12/2016
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-secondary btn-sm waves-effect waves-light">Edit</button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>#96254137</td>
                                        <td>
                                            <img src="{{ URL::asset('/images/users/user-3.jpg') }}" alt="user-image"
                                                class="avatar-xs mr-2 rounded-circle" /> Trex Outdoor Furniture Cape
                                        </td>
                                        <td><span class="badge badge-pill badge-danger">Cancel</span></td>
                                        <td>
                                            $657
                                        </td>
                                        <td>
                                            5/12/2016
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-secondary btn-sm waves-effect waves-light">Edit</button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>#12365474</td>
                                        <td>
                                            <img src="{{ URL::asset('/images/users/user-4.jpg') }}" alt="user-image"
                                                class="avatar-xs mr-2 rounded-circle" /> Oasis Bathroom Teak Corner
                                        </td>
                                        <td><span class="badge badge-pill badge-warning">Shipped</span></td>
                                        <td>
                                            $8451
                                        </td>
                                        <td>
                                            5/12/2016
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-secondary btn-sm waves-effect waves-light">Edit</button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>#85214796</td>
                                        <td>
                                            <img src="{{ URL::asset('/images/users/user-5.jpg') }}" alt="user-image"
                                                class="avatar-xs mr-2 rounded-circle" /> BeoPlay Speaker
                                        </td>
                                        <td><span class="badge badge-pill badge-success">Delivered</span></td>
                                        <td>
                                            $584
                                        </td>
                                        <td>
                                            5/12/2016
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-secondary btn-sm waves-effect waves-light">Edit</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#12354781</td>
                                        <td>
                                            <img src="{{ URL::asset('/images/users/user-6.jpg') }}" alt="user-image"
                                                class="avatar-xs mr-2 rounded-circle" /> Riverston Glass Chair
                                        </td>
                                        <td><span class="badge badge-pill badge-success">Delivered</span></td>
                                        <td>
                                            $185
                                        </td>
                                        <td>
                                            5/12/2016
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-secondary btn-sm waves-effect waves-light">Edit</button>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- end row -->
    @endif
@endsection

@section('footerScript')
    <!--Morris Chart-->
    <script src="{{ URL::asset('/libs/morris.js/morris.js.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/raphael/raphael.min.js') }}"></script>
    {{-- <script src="{{ URL::asset('/js/pages/dashboard.init.js') }}"></script> --}}
    <script>
        /*
Template Name: Lexa - Responsive Bootstrap 4 Admin Dashboard
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Dashboard
*/

!(function($) {
    "use strict";

    var Dashboard = function() {};

    //creates area chart
    (Dashboard.prototype.createAreaChart = function(
        element,
        pointSize,
        lineWidth,
        data,
        xkey,
        ykeys,
        labels,
        lineColors
    ) {
        Morris.Area({
            element: element,
            pointSize: 0,
            lineWidth: 1,
            data: data,
            xkey: xkey,
            ykeys: ykeys,
            labels: labels,
            resize: true,
            gridLineColor: "rgba(108, 120, 151, 0.1)",
            hideHover: "auto",
            lineColors: lineColors,
            fillOpacity: 0.9,
            behaveLikeLine: true
        });
    }),
        //creates Donut chart
        (Dashboard.prototype.createDonutChart = function(
            element,
            data,
            colors
        ) {
            Morris.Donut({
                element: element,
                data: data,
                resize: true,
                colors: colors
            });
        }),
        //creates Stacked chart
        (Dashboard.prototype.createStackedChart = function(
            element,
            data,
            xkey,
            ykeys,
            labels,
            lineColors
        ) {
            Morris.Bar({
                element: element,
                data: data,
                xkey: xkey,
                ykeys: ykeys,
                stacked: true,
                labels: labels,
                hideHover: "auto",
                resize: true, //defaulted to true
                gridLineColor: "rgba(108, 120, 151, 0.1)",
                barColors: lineColors
            });
        }),
        $("#sparkline").sparkline(
            [8, 6, 4, 7, 10, 12, 7, 4, 9, 12, 13, 11, 12],
            {
                type: "bar",
                height: "130",
                barWidth: "10",
                barSpacing: "7",
                barColor: "#7A6FBE"
            }
        );

    (Dashboard.prototype.init = function() {
        //creating area chart
        var $areaData = [
            { y: "2011", a: 0, b: 0, c: 0 },
            { y: "2012", a: 150, b: 45, c: 15 },
            { y: "2013", a: 60, b: 150, c: 195 },
            { y: "2014", a: 180, b: 36, c: 21 },
            { y: "2015", a: 90, b: 60, c: 360 },
            { y: "2016", a: 75, b: 240, c: 120 },
            { y: "2017", a: 30, b: 30, c: 30 }
        ];
        // this.createAreaChart(
        //     "morris-area-example",
        //     0,
        //     0,
        //     $areaData,
        //     "y",
        //     ["a", "b", "c"],
        //     ["Series A", "Series B", "Series C"],
        //     ["#ccc", "#7a6fbe", "#28bbe3"]
        // );


        //creating donut chart
        var $donutData = [
            @foreach(\App\Models\Status::orderBy('default_val', 'DESC')->get() as $status)
                { label: "{{ $status->name }}", value: "{{ \App\Models\Order::where('status_id', $status->id)->get()->count() }}" },
            @endforeach
        ];
        this.createDonutChart("morris-donut-example", $donutData, [
            "#7a6fbe",
            "#eeda92",
            "#28bbe3",
            "#717190",
            "#90718f",
            "#371024",
            "#1c493d",
            "#4b2b0f"
        ]);

        var $stckedData = [
            { y: "2005", a: 45, b: 180 },
            { y: "2006", a: 75, b: 65 },
            { y: "2007", a: 100, b: 90 },
            { y: "2008", a: 75, b: 65 },
            { y: "2009", a: 100, b: 90 },
            { y: "2010", a: 75, b: 65 },
            { y: "2011", a: 50, b: 40 },
            { y: "2012", a: 75, b: 65 },
            { y: "2013", a: 50, b: 40 },
            { y: "2014", a: 75, b: 65 },
            { y: "2015", a: 100, b: 90 },
            { y: "2016", a: 80, b: 65 }
        ];
        // this.createStackedChart(
        //     "morris-bar-stacked",
        //     $stckedData,
        //     "y",
        //     ["a", "b"],
        //     ["Series A", "Series B"],
        //     ["#28bbe3", "#f0f1f4"]
        // );
    }),
        //init
        ($.Dashboard = new Dashboard()),
        ($.Dashboard.Constructor = Dashboard);
})(window.jQuery),
    //initializing
    (function($) {
        "use strict";
        $.Dashboard.init();
    })(window.jQuery);

    </script>
@endsection
