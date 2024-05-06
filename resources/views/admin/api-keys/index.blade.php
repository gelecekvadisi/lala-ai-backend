@extends('layouts.master')

@section('title')
    {{ __('Api Keys') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{ __('Api Keys') }}</h4>
                @can('api-keys-create')
                <a href="{{ route('admin.api-keys.create') }}" class="theme-btn print-btn text-light">
                    <i class="far fa-plus" aria-hidden="true"></i>
                    Add Api Key
                </a>
                @endcan
            </div>
            <div class="table-top-form">
                <form class="searchForm" action="{{ route('admin.api-keys.index') }}" method="get">
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
                        @can('api-keys-delete')
                            <th class="w-60">
                                <div class="d-flex align-items-center gap-3" >
                                    <input type="checkbox" class="selectAllCheckbox">
                                    <i class="fal fa-trash-alt delete-selected"></i>
                                </div>
                            </th>
                        @endcan
                        <th>{{ __('SL.') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Key') }}</th>
                        <th class="text-center">{{ __('Status') }}</th>
                        <th class="text-center">{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody class="searchResults">
                        @include('admin.api-keys.search')
                    </tbody>
                </table>
            </div>
            <nav>
                <ul class="pagination">
                    <li class="page-item">{{ $api_keys->links() }}</li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="modal fade" id="view-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Api Key View</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="personal-info">
                        <div class="row mt-3">
                            <div class="col-md-5"><p>Key</p></div>
                            <div class="col-md-7"><p id="api_view_key"></p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>Title</p></div>
                            <div class="col-md-7"><p id="api_view_title"></p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>Status</p></div>
                            <div class="col-md-7"><p id="api_view_status"></p></div>
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
