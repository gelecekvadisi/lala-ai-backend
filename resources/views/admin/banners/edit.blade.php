@extends('layouts.master')

@section('title')
    {{ __('Banner') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Edit Banner')}}</h4>
                @can('banners-read')
                <a href="{{ route('admin.banners.index') }}" class="add-order-btn rounded-2 {{ Route::is('admin.banners.create') ? 'active' : '' }}"><i class="far fa-list" aria-hidden="true"></i> {{ __('Banner List') }}</a>
                @endcan
            </div>
            <div class="order-form-section">
                <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="ajaxform_instant_reload">
                    @csrf
                    @method('put')
                    <div class="add-suplier-modal-wrapper">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="col-lg-12 mt-2">
                                    <label>{{__('Category')}}</label>
                                    <div class="gpt-up-down-arrow position-relative">
                                        <select name="category_id" required class="form-control table-select w-100">
                                            <option value="">{{ __('Select Category') }}</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" @selected($category->id == $banner->category_id ?? '' )>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <span></span>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <label>{{__('Title')}}</label>
                                    <input type="text" name="title" value="{{ $banner->title  }}" class="form-control" placeholder="Enter your title">
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <label>{{ __('Status') }}</label>
                                    <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                        <p class="dynamic-text">{{ $banner->status == 1 ? 'Active' : 'Deactive' }}</p>
                                        <label class="switch m-0">
                                            <input type="checkbox" name="status" class="change-text" {{ $banner->status == 1 ? 'checked' : '' }}>
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
                                            <img src="{{ asset($banner->image ?? 'assets/images/icons/upload-icon.svg') }}" alt="user" id="profile-img">
                                        </div>
                                        <input type="file" name="image" class="d-none" onchange="document.getElementById('profile-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="button-group text-center mt-5">
                                    <a href="{{ route('admin.banners.index') }}"
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
