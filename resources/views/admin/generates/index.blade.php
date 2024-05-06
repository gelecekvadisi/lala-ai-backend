@extends('layouts.master')

@section('title')
    {{ __('Generate') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Generate List')}}</h4>
            </div>
            <div class="table-top-form">
                <form class="searchForm" action="{{ route('admin.generates.index') }}" method="get">
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
                        @can('generates-delete')
                            <th class="w-60">
                                <div class="d-flex align-items-center gap-3" >
                                    <input type="checkbox" class="selectAllCheckbox">
                                    <i class="fal fa-trash-alt delete-selected"></i>
                                </div>
                            </th>
                        @endcan
                        <th>{{ __('SL.') }}</th>
                        <th>{{ __('User') }}</th>
                        {{-- <th>{{ __('Category') }}</th> --}}
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Credits Cost') }}</th>
                        <th>{{ __('Created At') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody class="searchResults">
                    @include('admin.generates.search')
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $generates->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

@endsection
@push('modal')
    @include('admin.components.multi-delete-modal')
@endpush
