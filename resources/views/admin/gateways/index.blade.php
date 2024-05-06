@extends('layouts.master')

@section('title')
    {{__('Gateway Settings') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Payment Gateway')}}</h4>
            </div>
            <div class="order-form-section mt-3">
                <form action="{{ route('admin.gateways.store') }}" method="post" class="ajaxform" novalidate="novalidate">
                    @csrf

                    <div class="add-suplier-modal-wrapper payment-gateway d-block">
                        <div class="row">

                            
                            <div class="col-md-12 col-lg-6 mt-4">
                                <div class="col-12">
                                    <h4>Stripe Gateway Settings</h4>
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <label>{{ __('Stripe Client ID') }}</label>
                                    <input type="text" name="stripe_client_id" value="{{ $gateways['stripe_client_id'] ?? '' }}" class="form-control" placeholder="{{ __('Enter gateway name') }}">
                                </div>

                                <div class="col-lg-12 mb-2">
                                    <label>{{ __('Stripe Client Secret') }}</label>
                                    <input type="text" name="stripe_client_secret" value="{{ $gateways['stripe_client_secret'] ?? '' }}" class="form-control" placeholder="{{ __('Enter client id') }}">
                                </div>

                                <div class="col-lg-12 my-2">
                                    <label>{{__('Stripe is live')}}</label>
                                    <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                        <p class="is-live-text">{{ $gateways['stripe_is_live'] ?? null == 1 ? 'Yes' : 'No' }}</p>
                                        <label class="switch m-0">
                                            <input type="checkbox" value="1" @checked($gateways['stripe_is_live'] ?? false) name="stripe_is_live" class="cnge-text">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12 col-lg-6 mt-4">
                                <div class="col-12 mt-2">
                                    <h4>Sslcommerz Gateway Settings</h4>
                                </div>

                                <div class="col-lg-12 mb-2">
                                    <label>{{ __('Sslcommerz Client ID') }}</label>
                                    <input type="text" name="sslcommerz_client_id" value="{{ $gateways['sslcommerz_client_id'] ?? '' }}" class="form-control" placeholder="{{ __('Enter gateway name') }}">
                                </div>

                                <div class="col-lg-12 mb-2">
                                    <label>{{ __('Sslcommerz Client Secret') }}</label>
                                    <input type="text" name="sslcommerz_client_secret" value="{{ $gateways['sslcommerz_client_secret'] ?? '' }}" class="form-control" placeholder="{{ __('Enter client id') }}">
                                </div>

                                <div class="col-lg-12 my-2">
                                    <label>{{__('Sslcommerz Is Live')}}</label>
                                    <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                        <p class="is-live-text">{{ $gateways['sslcommerz_is_live'] ?? null == 1 ? 'Yes' : 'No' }}</p>
                                        <label class="switch m-0">
                                            <input type="checkbox" value="1" @checked($gateways['sslcommerz_is_live'] ?? false) name="sslcommerz_is_live" class="cnge-text">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <div class="col-12">
                                    <h4>Paypal Gateway Settings</h4>
                                </div>

                                <div class="col-lg-12 mb-2">
                                    <label>{{ __('Paypal Client ID') }}</label>
                                    <input type="text" name="paypal_client_id"  value="{{ $gateways['paypal_client_id'] ?? '' }}" class="form-control" placeholder="{{ __('Enter gateway name') }}">
                                </div>

                                <div class="col-lg-12 mb-2">
                                    <label>{{ __('Paypal Client Secret') }}</label>
                                    <input type="text" name="paypal_client_secret"  value="{{ $gateways['paypal_client_secret'] ?? '' }}" class="form-control" placeholder="{{ __('Enter client id') }}">
                                </div>

                                <div class="col-lg-12 my-2">
                                    <label>{{__('Paypal is live')}}</label>
                                    <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                        <p class="is-live-text">{{ $gateways['paypal_is_live'] ?? null == 1 ? 'Yes' : 'No' }}</p>
                                        <label class="switch m-0">
                                            <input type="checkbox" value="1" @checked($gateways['paypal_is_live'] ?? false) name="paypal_is_live" class="cnge-text">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="button-group text-center mt-4">
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
