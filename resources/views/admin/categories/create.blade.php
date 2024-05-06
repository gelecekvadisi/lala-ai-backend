@extends('layouts.master')

@section('title')
    {{ __('Category') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Add New Category')}}</h4>
                @can('categories-read')
                <a href="{{ route('admin.categories.index') }}" class="add-order-btn rounded-2 {{ Route::is('admin.categories.create') ? 'active' : '' }}"><i class="far fa-list" aria-hidden="true"></i> {{ __('Categories List') }}</a>
                @endcan
            </div>
            <div class="order-form-section">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="ajaxform_instant_reload">
                    @csrf
                    <div class="add-suplier-modal-wrapper">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="col-lg-12 mt-2">
                                    <label>{{('Name')}}</label>
                                    <input type="text" name="name" class="form-control" placeholder="{{ __('Enter Category Name') }}">
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <label>{{__('Status')}}</label>
                                    <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                        <p class="dynamic-text">{{ __('Active') }}</p>
                                        <label class="switch m-0">
                                            <input type="checkbox" name="status" class="change-text" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
    
                            </div>
                            <div class="col-lg-6">
                                <label>Image</label>
                                <div class="upload-img-v2">
                                    <label class="upload-v4">
                                        <div class="img-wrp">
                                            <img src="{{ asset('assets/images/icons/upload-icon.svg') }}" alt="user" id="profile-img">
                                        </div>
                                        <input type="file" name="image" class="d-none" onchange="document.getElementById('profile-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="button-group text-center mt-5">
                                    <a href="{{ route('admin.categories.index') }}"
                                       class="theme-btn border-btn m-2">{{__('Cancel')}}</a>
                                    <button class="theme-btn m-2 submit-btn">{{__('Save')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
