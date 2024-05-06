@extends('layouts.master')

@section('title')
    {{ ucfirst(request('type') ?? request('type')) }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Add New ')}}{{ ucfirst(request('type') ?? request('type')) }} </h4>
                <a href="{{ route('admin.users.index', ['type' => request('type')]) }}" class="add-order-btn rounded-2 {{ Route::is('admin.users.create') ? 'active' : '' }}"><i class="far fa-list" aria-hidden="true"></i> {{ __(ucfirst(request('type'))) }} {{ __(' List') }}</a>
            </div>
            <div class="order-form-section">
                <form action="{{ route('admin.users.store', ['type' => request('type')]) }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                    @csrf

                    <div class="add-suplier-modal-wrapper">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>Image</label>
                                <div class="upload-img-v2">
                                    <label class="upload-v4 image-height">
                                        <div class="img-wrp">
                                            <img src="{{ asset('assets/images/icons/upload-icon.svg') }}" alt="user" id="profile-img">
                                        </div>
                                        <input type="file" name="image" class="d-none" onchange="document.getElementById('profile-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <div class="col-lg-12 mt-2">
                                    <label>{{('Name')}}</label>
                                    <input type="text" name="name" required class="form-control" placeholder="Enter Name">
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <label>{{__('User Name')}}</label>
                                    <input type="text" name="username" required class="form-control" placeholder="Enter Email Address">
                                </div>
                            </div>

                            <div class="col-lg-6 mt-2 {{ request('type') == 'admin' ? '':'d-none' }}">
                                <label>{{__('Role')}}</label>
                                <div class="gpt-up-down-arrow position-relative">
                                    <select name="role" required class="form-control table-select w-100 role">
                                        <option value=""> {{__('Select a role')}}</option>
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" @selected(request('users') == $role->name)> {{ ucfirst($role->name) }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>                            
                            <div class="col-lg-6 mt-2">
                                <label>{{__('Email')}}</label>
                                <input type="email" name="email" required class="form-control" placeholder="Enter Password">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>{{__('Phone')}}</label>
                                <input type="number" name="phone" class="form-control" placeholder="Enter Phone Number">
                            </div>
                            <div class="col-lg-6 mt-2 {{ request('type') == 'admin' ? 'd-none':'' }}">
                                <label>{{ __('Active Subscription Plans') }}</label>
                                <select name="plan_id" class="form-control table-select w-100 plan-duration-input">
                                    <option value="">{{ __('Select a Plan') }}</option>
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6 mt-2">
                                <label>{{__('Password')}}</label>
                                <input type="password" name="password" required class="form-control" placeholder="Enter Password">
                            </div>

                            <div class="col-lg-12">
                                <div class="button-group text-center mt-5">
                                    <a href="{{ route('admin.users.index', ['type' => request('type')]) }}" class="theme-btn border-btn m-2">{{ __('Cancel') }}</a>
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
