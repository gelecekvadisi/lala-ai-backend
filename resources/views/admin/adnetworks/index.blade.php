@extends('layouts.master')

@section('title')
    {{ __('Adnetworks') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{ __('Adnetworks') }}</h4>
            </div>
            <div class="order-form-section">
                <form action="{{ route('admin.adnetworks.update') }}" method="POST" enctype="multipart/form-data" class="ajaxform radio-switcher">
                    @csrf
                    @method('put')
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label>{{ __('Admob App Id') }}</label>
                                <div class="form-control d-flex justify-content-between align-items-center ">
                                    <div class="col-10">
                                        <input type="text" name="admob_app_id" class="form-control" value="{{ $adnetwork->value['admob_app_id'] ?? '' }}" aria-describedby="basic-addon2" placeholder="Enter Admob App Id" required>
                                    </div>
                                    <div class="col-2 text-end">
                                        <label class="switch m-0">
                                            <input type="checkbox" name="admob_app_id_status" class="change-text" @checked($adnetwork->value['admob_app_id_status'] ?? false)>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label>{{ __('Video Ad Id') }}</label>
                                <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                    <div class="col-10">
                                        <input type="text" name="video_ad_id" class="form-control" value="{{ $adnetwork->value['video_ad_id'] ?? '' }}" aria-describedby="basic-addon2" placeholder="Enter Video Ad Id" required>
                                    </div>
                                    <div class="col-2 text-end">
                                        <label class="switch m-0">
                                            <input type="checkbox" name="video_ad_status" class="change-text" @checked($adnetwork->value['video_ad_status'] ?? false)>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
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
