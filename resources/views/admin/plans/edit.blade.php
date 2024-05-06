@extends('layouts.master')

@section('title')
    {{ __('Edit Subscription Plans') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{ __('Edit Subscription Plan') }}</h4>
                <a href="{{ route('admin.plans.index') }}" class="theme-btn print-btn text-light">
                    <i class="far fa-list" aria-hidden="true"></i>
                    {{ __('Plan List') }}
                </a>
            </div>
            <div class="order-form-section mt-3">
                <form action="{{ route('admin.plans.update', $plan->id) }}" method="POST" enctype="multipart/form-data" class="ajaxform_instant_reload">
                    @csrf
                    @method('put')
                    <div class="add-suplier-modal-wrapper d-block">
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Title') }}</label>
                                <input type="text" name="title" value="{{ $plan->title }}" required class="form-control" placeholder="{{ __('Enter plan title') }}">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Sub Title') }}</label>
                                <input type="text" name="subtitle" value="{{ $plan->subtitle }}" class="form-control" placeholder="{{ __('Enter plan subtitle') }}">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Price') }}</label>
                                <input type="number" step="any" name="price" value="{{ $plan->price }}" class="form-control" placeholder="{{ __('Enter Plan Price') }}">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Duration') }}</label>
                                <div class="gpt-up-down-arrow position-relative">
                                    <select name="duration" required class="form-control select-dropdown">
                                        <option value="">{{ __('Select a duration') }}</option>
                                        <option @selected($plan->duration == 'weekly') value="weekly">{{ __('Weekly') }}</option>
                                        <option @selected($plan->duration == '15_days') value="15_days">{{ __('15 Days') }}</option>
                                        <option @selected($plan->duration == 'monthly') value="monthly">{{ __('Monthly') }}</option>
                                        <option @selected($plan->duration == '3_monthly') value="3_monthly">{{ __('3-Monthly') }}</option>
                                        <option @selected($plan->duration == '6_monthly') value="6_monthly">{{ __('6-Monthly') }}</option>
                                        <option @selected($plan->duration == 'yearly') value="yearly">{{ __('Yearly') }}</option>
                                    </select>
                                    <span></span>
                                </div>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>{{__('Status')}}</label>
                                <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                    <p class="dynamic-text">{{ $plan->status == 1 ? 'Active' : 'Deactive' }}</p>
                                    <label class="switch m-0">
                                        <input type="checkbox" name="status" class="change-text" {{ $plan->status == 1 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="button-group text-center mt-5">
                                    <button type="reset" class="theme-btn border-btn m-2">Reset</button>
                                    <button class="theme-btn m-2 submit-btn">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
