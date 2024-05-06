@extends('layouts.master')

@section('title')
    {{__('Plans List') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Subscription Plan List')}}</h4>
                <a href="{{ route('admin.plans.create') }}" class="theme-btn print-btn text-light">
                    <i class="far fa-plus" aria-hidden="true"></i>
                    {{ __('Add new plan') }}
                </a>
            </div>
            <div class="table-top-form">
                <form class="searchForm" action="{{ route('admin.plans.index') }}" method="get">
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
                            @can('plans-delete')
                            <th class="w-60">
                                <div class="d-flex align-items-center gap-3" >
                                    <input type="checkbox" class="selectAllCheckbox">
                                    <i class="fal fa-trash-alt delete-selected"></i>
                                </div>
                            </th>
                            @endcan
                            <th>{{ __('SL.') }}</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Sub Title') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Duration') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th class="text-center">{{ __('Status') }}</th>
                            <th class="text-center">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="searchResults">
                        @include('admin.plans.search')
                    </tbody>
                </table>
            </div>
            <nav>
                <ul class="pagination">
                    <li class="page-item">{{ $plans->links() }}</li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="modal fade" id="view-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Subscription Plan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="personal-info">
                        <div class="row mt-3">
                            <div class="col-md-5"><p>Title</p></div>
                            <div class="col-md-7"><p id="plan_view_title"></p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>Sub Title</p></div>
                            <div class="col-md-7"><p id="plan_view_subtitle"></p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>{{ __('Price') }}</p></div>
                            <div class="col-md-7"><p id="plan_view_price"></p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>{{ __('Duration') }}</p></div>
                            <div class="col-md-7"><p id="plan_view_duration"></p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>Status</p></div>
                            <div class="col-md-7"><p id="plan_view_status"></p></div>
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
