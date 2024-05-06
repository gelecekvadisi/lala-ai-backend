@extends('layouts.master')

@section('title')
    {{ __('Credits Plan') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Credits Plan')}}</h4>
                <a href="{{ route('admin.buy-credits.index') }}" class="theme-btn print-btn text-light">
                    <i class="far fa-list" aria-hidden="true"></i>
                    {{__('Credits Plans')}}
                </a>
            </div>
            <div class="order-form-section mt-3">
                <form action="{{ route('admin.buy-credits.store') }}" method="post" class="ajaxform_instant_reload" novalidate="novalidate">
                    @csrf
                    <div class="add-suplier-modal-wrapper d-block">
                        <div class="row">

                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Title') }}</label>
                                <input type="text" name="title" required class="form-control" placeholder="{{ __('Enter Title') }}">
                            </div>

                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Price') }}</label>
                                <input type="number" step="any" name="price" required class="form-control" placeholder="{{ __('Enter Price') }}">
                            </div>

                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Credits') }}</label>
                                <input type="number" step="any" name="reward" required class="form-control" placeholder="{{ __('Enter reward amount') }}">
                            </div>

                            <div class="col-lg-6 mt-0">
                                <label>{{__('Status')}}</label>
                                <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                    <p class="dynamic-text">{{ __('Active') }}</p>
                                    <label class="switch m-0">
                                        <input type="checkbox" name="status" class="change-text" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-2">
                                <label>{{__('Description')}}</label>
                                <textarea name="description" class="form-control" placeholder="{{ __('Enter description here') }}"></textarea>
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
