@extends('layouts.master')

@section('title')
    {{ __('Add Api Key') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Add Api Key')}}</h4>
                <a href="{{ route('admin.api-keys.index') }}" class="theme-btn print-btn text-light">
                    <i class="far fa-list" aria-hidden="true"></i>
                    {{ __('Api Key List') }}
                </a>
            </div>
            <div class="order-form-section mt-3">
                <form action="{{ route('admin.api-keys.store') }}" method="POST" class="ajaxform_instant_reload radio-switcher">
                    @csrf

                    <div class="row">
                        <div class="mb-2 col-lg-6">
                            <label>{{ __('Key') }}</label>
                            <input name="key" required class="form-control" placeholder="{{ __('Enter Key') }}">
                        </div>
                        <div class="mb-2 col-lg-6">
                            <label>{{ __('Title') }}</label>
                            <input name="title" class="form-control" placeholder="{{ __('Enter Title') }}">
                        </div>
                        <div class="mb-2 col-lg-6">
                            <label>{{ __('Status') }}</label>
                            <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                <p class="dynamic-text">{{ __('Active') }}</p>
                                <label class="switch m-0">
                                    <input type="checkbox" name="status" class="change-text" checked>
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
                </form>
            </div>
        </div>
    </div>
@endsection
