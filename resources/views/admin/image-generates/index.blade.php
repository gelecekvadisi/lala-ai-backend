@extends('layouts.master')

@section('title')
    {{ __('Image Generate') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{ __('Image Generates') }}</h4>
            </div>
            <div class="order-form-section mt-3">
                <form action="{{ route('admin.image-generates.update') }}" method="POST" class="ajaxform">
                    @csrf
                    @method('put')

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-2">
                                <label>{{ __('Number of Image (Per Generate)') }}</label>
                                <input type="number" name="no_of_image" required class="form-control" value="{{ $image_generate['no_of_image'] ?? '' }}" placeholder="Enter Number of Image">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-2">
                                <label>{{ __('Charge Per Generate (Credit)') }}</label>
                                <input type="number" name="charge" required class="form-control" value="{{ $image_generate['charge'] ?? '' }}" placeholder="Enter Charge Per Generate">
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