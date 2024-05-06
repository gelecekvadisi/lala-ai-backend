@extends('layouts.master')

@section('title')
    {{ ucfirst(request('type') ?? request('type')) }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{ ucfirst(request('type') ?? request('type')) }} {{__('List')}}</h4>
                @can('users-create')
                <a href="{{ route('admin.users.create', ['type' => request('type')]) }}" class="add-order-btn rounded-2 {{ Route::is('admin.users.create') ? 'active' : '' }}"><i class="fas fa-plus-circle"></i> {{ __('Add New') }} {{ __(ucfirst(request('type'))) }}</a>
                @endcan
            </div>
            <div class="table-top-form">
                <form class="searchForm" action="{{ route('admin.users.index', ['type' => request('type')]) }}" method="get">
                    <div class="table-search">
                        <input class="form-control searchInput" type="text" placeholder="Search..." value="{{ request('search') }}">
                        <button type="submit"><i class="far fa-search" aria-hidden="true"></i></button>
                        <button type="button" class="text-danger clearSearchInput d-none"> <i class="far fa-times" aria-hidden="true"></i></button>
                    </div>
                </form>
            </div>
            <div class="responsive-table rounded-image">
                <table class="table" id="erp-table">
                    <thead>
                    <tr>
                        <th class="w-60">
                            <div class="d-flex align-items-center gap-3" >
                                <input type="checkbox" class="selectAllCheckbox">
                                <i class="fal fa-trash-alt delete-selected"></i>
                            </div>
                        </th>
                        <th>SL</th>
                        <th>Registered Date	</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        @if(request('type') === 'user')
                        <th>{{ __('Current Plan') }}</th>
                        @endif
                        <th>Status</th>
                        <th>action</th>
                    </tr>
                    </thead>
                    <tbody class="searchResults">
                        @include('admin.users.search')
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $users->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="view-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">{{ __('User View') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="personal-info">
                        <div class="row mt-3">
                            <div class="col-md-5"><p>{{ __('Registered Date') }}</p></div>
                            <div class="col-md-7"><p id="user_view_created_at"></p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>{{ __('Image') }}</p></div>
                            <div class="col-md-7 d-flex align-items-center gap-2"><div class="table-user-icon"><img src="" alt="" id="user_view_image"></div></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>{{ __('Name') }}</p></div>
                            <div class="col-md-7"><p id="user_view_name"></p></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>{{ __('Email') }}</p></div>
                            <div class="col-md-7"><p id="user_view_email"></p></div>
                        </div>
                        <hr>
                        @if(request('type') === 'user')
                            <div class="row">
                                <div class="col-md-5"><p>{{ __('Subscription Plan') }}</p></div>
                                <div class="col-md-7"><p id="user_view_plan"></p></div>
                            </div>
                        @endif
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><p>{{ __('Status') }}</p></div>
                            <div class="col-md-7"><p id="user_view_status"></p></div>
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
