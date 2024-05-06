@extends('layouts.master')

@section('title')
    {{ __('Buy / Earned Credits') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Buy / Earned Credits List')}}</h4>
            </div>
            <div class="table-top-form">
                <form class="searchForm" action="{{ route('admin.credits-earning.index') }}" method="get">
                    <div class="table-search">
                        <input class="form-control searchInput" type="text" placeholder="Search..." value="{{ request('search') }}">
                        <button type="submit"><i class="far fa-search" aria-hidden="true"></i></button>
                        <button type="button" class="text-danger clearSearchInput d-none"> <i class="far fa-times" aria-hidden="true"></i></button>
                    </div>
                </form>
            </div>
            <div class="responsive-table">
                <table class="table" id="datatable">
                    <thead>
                    <tr>
                        @can('credits_earnings-delete')
                            <th class="w-60">
                                <div class="d-flex align-items-center gap-3" >
                                    <input type="checkbox" class="selectAllCheckbox">
                                    <i class="fal fa-trash-alt delete-selected"></i>
                                </div>
                            </th>
                        @endcan
                        <th>{{ __('SL.') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Platform') }}</th>
                        <th>{{ __('Credits') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Created At') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody class="searchResults">
                    @include('admin.credits-earning.search')
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $credits_earnings->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="view-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">{{ __('Buy / Earned Credits List') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="personal-info">
                        <div class="row mt-3">
                            <div class="col-md-5"><p>{{ __('User') }}</p></div>
                            <div class="col-md-7"><p id="credits_earning_view_user"></p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>{{ __('Platform') }}</p></div>
                            <div class="col-md-7"><p id="credits_earning_view_platform"></p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>{{ __('Credits') }}</p></div>
                            <div class="col-md-7"><p id="credits_earning_view_credits"></p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>{{ __('Price') }}</p></div>
                            <div class="col-md-7"><p id="credits_earning_view_price"></p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>{{ __('Created At	') }}</p></div>
                            <div class="col-md-7"><p id="credits_earning_view_created_at"></p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('modal')
    @include('admin.components.multi-delete-modal')
@endpush
