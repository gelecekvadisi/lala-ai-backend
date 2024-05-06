@extends('layouts.master')

@section('title')
    {{ __('Text Generates Settings') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{ __('Text Generates Settings') }}</h4>
            </div>
            <div class="order-form-section mt-3">
                <form action="{{ route('admin.text-generates.update') }}" method="POST" class="ajaxform">
                    @csrf
                    @method('put')
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-2">
                                <label>{{ __('Maximum Tokens') }}</label>
                                <input type="number" name="max_tokens" required class="form-control" value="{{ $text_generate['max_tokens'] ?? '' }}" placeholder="Enter Maximum Tokens">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-2">
                                <label>{{ __('Temperature') }}</label>
                                <input type="number" name="temperature" required class="form-control" value="{{ $text_generate['temperature'] ?? '' }}" placeholder="Enter Temperature">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-2">
                                <label>{{ __('Model') }}</label>
                                <input type="text" name="model" required class="form-control" value="{{ $text_generate['model'] ?? '' }}" placeholder="Enter Model">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-2">
                                <label>{{ __('Charge Per Generate (Credit)') }}</label>
                                <input type="number" name="charge" required class="form-control" value="{{ $text_generate['charge'] ?? '' }}" placeholder="Enter Charge Per Generate">
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
