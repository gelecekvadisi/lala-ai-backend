@extends('layouts.master')

@section('title')
    {{ __('Banner') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Banner List')}}</h4>
                @can('banners-create')
                <a href="{{ route('admin.banners.create')}}" class="add-order-btn rounded-2 {{ Route::is('admin.banners.create') ? 'active' : '' }}"><i class="fas fa-plus-circle"></i> {{ __('Add New Banner') }}</a>
                @endcan
            </div>
            <div class="table-top-form">
                <form class="searchForm" action="{{ route('admin.banners.index') }}" method="get">
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
                        @can('banners-delete')
                            <th>
                                <div class="d-flex align-items-center gap-3">
                                    <input type="checkbox" class="selectAllCheckbox">
                                    <i class="fal fa-trash-alt delete-selected"></i>
                                </div>
                            </th>
                        @endcan
                        <th>SL.</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="searchResults">
                    @include('admin.banners.search')
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $banners->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

@push('modal')
    @include('admin.components.multi-delete-modal')
@endpush
