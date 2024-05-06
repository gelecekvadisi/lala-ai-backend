@extends('layouts.master')

@section('title')
    {{ __('FAQs') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('FAQs List')}}</h4>
                @can('faqs-create')
                    <a href="{{ route('admin.faqs.create') }}" class="add-order-btn rounded-2 {{ Route::is('admin.faqs.create') ? 'active' : '' }}"><i class="fas fa-plus-circle"></i> {{ __('Add New FAQs') }}</a>
                @endcan
            </div>
            <div class="table-top-form">
                <form class="searchForm" action="{{ route('admin.faqs.index') }}" method="get">
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
                        @can('faqs-delete')
                            <th class="w-60">
                                <div class="d-flex align-items-center gap-3" >
                                    <input type="checkbox" class="selectAllCheckbox">
                                    <i class="fal fa-trash-alt delete-selected"></i>
                                </div>
                            </th>
                        @endcan
                        <th class="w-60">{{ __('SL.') }}</th>
                        <th>{{ __('Question') }}</th>
                        <th >{{ __('Answer') }} </th>
                        <th class="text-center">{{ __('Status') }}</th>
                        <th class="text-center">{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody class="searchResults">
                    @include('admin.faqs.search')
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $faqs->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="view-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">FAQs View</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="personal-info">
                        <div class="row mt-3">
                            <div class="col-md-5"><p>Question</p></div>
                            <div class="col-md-7"><p id="faqs_view_question"> </p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>Answer</p></div>
                            <div class="col-md-7"><p id="faqs_view_answer"> </p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>Status</p></div>
                            <div class="col-md-7"><p id="faqs_view_status"> </p></div>
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
