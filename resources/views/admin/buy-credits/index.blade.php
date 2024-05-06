@extends('layouts.master')

@section('title')
    {{__('Credits Plan List') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Credits Plan List')}}</h4>
                @can('buy-credits-create')
                <a href="{{ route('admin.buy-credits.create') }}" class="theme-btn print-btn text-light">
                    <i class="far fa-plus" aria-hidden="true"></i>
                    {{ __('Add new plan') }}
                </a>
                @endcan
            </div>
            <div class="table-top-form">
                <form class="searchForm" action="{{ route('admin.buy-credits.index') }}" method="get">
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
                        @can('buy-credits-delete')
                            <th>
                                <div class="d-flex align-items-center gap-3" >
                                    <input type="checkbox" class="selectAllCheckbox">
                                    <i class="fal fa-trash-alt delete-selected"></i>
                                </div>
                            </th>
                        @endcan
                        <th>{{ __('SL.') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Credits') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody class="searchResults">
                        @include('admin.buy-credits.search')
                    </tbody>
                </table>
            </div>
            <nav>
                <ul class="pagination">
                    <li class="page-item">{{ $buy_credits->links() }}</li>
                </ul>
            </nav>
        </div>
    </div>

@endsection

@push('modal')
    @include('admin.components.multi-delete-modal')
@endpush
