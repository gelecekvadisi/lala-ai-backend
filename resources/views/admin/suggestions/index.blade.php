@extends('layouts.master')

@section('title')
    {{ __('Suggestion') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Suggestion List')}}</h4>
                @can('suggestions-create')
                <a href="{{ route('admin.suggestions.create') }}" class="add-order-btn rounded-2 {{ Route::is('admin.suggestions.create') ? 'active' : '' }}"><i class="fas fa-plus-circle"></i> {{ __('Add New Suggestion') }}</a>
                @endcan
            </div>
            <div class="table-top-form">
                <form class="searchForm" action="{{ route('admin.suggestions.index') }}" method="get">
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
                            @can('suggestions-delete')
                            <th class="w-60">
                                <div class="d-flex align-items-center gap-3" >
                                    <input type="checkbox" class="selectAllCheckbox">
                                    <i class="fal fa-trash-alt delete-selected"></i>
                                </div>
                            </th>
                            @endcan
                            <th>{{ __('SL.') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Image Name') }}</th>
                            <th>{{ __('Suggestion') }}</th>
                            <th >{{ __('Category') }}</th>
                            <th >{{ __('Assistant ID') }}</th>
                            <th class="text-center">{{ __('Status') }}</th>
                            <th class="text-center">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="searchResults">
                        @include('admin.suggestions.search')
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $suggestions->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="view-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Suggestions View</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="personal-info">
                        <div class="row mt-3">
                            <div class="col-md-5"><p>Name</p></div>
                            <div class="col-md-7"><p id="suggestion_view_name"></p></div>
                        </div>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-md-5"><p>Image Name</p></div>
                            <div class="col-md-7"><p id="suggestion_view_image_name"></p></div>
                        </div>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-md-5"><p>Suggestion</p></div>
                            <div class="col-md-7"><p id="suggestion_view_suggestion"></p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>Category</p></div>
                            <div class="col-md-7"><p id="suggestion_view_category"></p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>Assistant ID</p></div>
                            <div class="col-md-7"><p id="suggestion_view_assistant_id"></p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>Status</p></div>
                            <div class="col-md-7"><p id="suggestion_view_status"></p></div>
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
