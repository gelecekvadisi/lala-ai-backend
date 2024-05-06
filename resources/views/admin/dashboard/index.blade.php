@extends('layouts.master')

@section('title')
    {{__('Dashboard') }}
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="gpt-dashboard-card grid-5 mt-30 mb-30">
            <div class="couter-box">
                <div class="icons bg-violet-light">
                    <img src="{{ asset('assets/img/icon/user.svg') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="dashboard_app_user"></h5>
                    <p>Total App Users</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons bg-orange-light">
                    <img src="{{ asset('assets/img/icon/subscription.svg') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="dashboard_subscription"></h5>
                    <p>Total Subscriptions</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons bg-green2-light">
                    <img src="{{ asset('assets/img/icon/user1.png') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="dashboard_free_user"></h5>
                    <p>Total Free Users</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons bg-violet-light">
                    <img src="{{ asset('assets/img/icon/category.svg') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="dashboard_category"></h5>
                    <p>Total Category</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons bg-violet-light">
                    <img src="{{ asset('assets/img/icon/crown-king.svg') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="dashboard_subscribers"></h5>
                    <p>Total Subscribers</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons bg-violet-light">
                    <img src="{{ asset('assets/img/icon/banner.svg') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="dashboard_banner"></h5>
                    <p>Total Banner</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons bg-orange-light">
                    <img src="{{ asset('assets/img/icon/support-faq.svg') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="dashboard_fags"></h5>
                    <p>Total Faqs</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons bg-green2-light">
                    <img src="{{ asset('assets/img/icon/suggestions.svg') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="dashboard_suggestions"></h5>
                    <p>Total Suggestions</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons bg-violet-light">
                    <img src="{{ asset('assets/img/icon/credit.svg') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="dashboard_credit"></h5>
                    <p>Earned/Buy Credits</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons bg-violet-light">
                    <img src="{{ asset('assets/img/icon/reward.svg') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="cost_credits"></h5>
                    <p>Credits Used</p>
                </div>
            </div>
        </div>

        <div class="row gpt-dashboard-chart">
            <div class="row gpt-dashboard-chart">
                <div class="col-xxl-8 col-xl-7 col-lg-7 mb-30">
                    <div class="card new-card">
                        <div class="card-header subscription-header">
                            <h4>Texts Generates Vs Images Generates</h4>
                            <div class="gpt-up-down-arrow position-relative">
                                <select class="form-control generates-statistics">
                                    @for ($i = date('Y'); $i >= 2022; $i--)
                                        <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <span></span>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <canvas id="monthly-statistics" class="chart-css"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-5 col-lg-5 mb-30">
                    <div class="card new-card">
                        <div class="card-header overview-header">
                            <h4>User Overview</h4>
                            <div class="gpt-up-down-arrow position-relative">
                                <select class="form-control overview-year">
                                    @for ($i = date('Y'); $i >= 2022; $i--)
                                        <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <span></span>
                            </div>
                        </div>
                        <div class="card-body ShareProfit-body">
                            <canvas id="ShareProfit" class="chart-css"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-12 mb-30">
                    <div class="card new-card">
                        <div class="card-header users-header">
                            <h4>New Registered Users</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive border-1 rounded-3 rounded-image">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Plan (Duration)</th>
                                        <th>Expire Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img class="table-img rounded-circle" src="{{ asset($user->image ?? 'assets/images/icons/default-user.png') }}" alt=""></td>
                                            <td>{{ ucwords($user->name) }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <p>{{ optional($user->plan)->title }} (<small>{{ optional($user->plan)->duration ?? 'N/A' }}</small>)</p>
                                            </td>
                                            <td>{{ formatted_date($user->will_expire) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" value="{{ route('admin.dashboard.data') }}" id="get-dashboard">
    <input type="hidden" value="{{ route('admin.dashboard.user-overview') }}" id="get-user-overview">
    <input type="hidden" value="{{ route('admin.dashboard.generates') }}" id="yearly-generates-url">

@endsection

@push('js')
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/dashboard.js') }}"></script>
@endpush
