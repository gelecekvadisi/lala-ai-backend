@extends('layouts.master')

@section('title')
    {{ __('Generate') }}
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="card new-card mt-3 border-0 shadow-sm">
            <div class="card-body pb-4">
                <div class="row justify-content-between py-3">
                    <div class="col align-self-center">
                        <h4>{{ __('View generate') }}</h4>
                    </div>
                    @can('generates-read')
                    <div class="col align-self-center text-end">
                        <a href="{{ route('admin.generates.index') }}" class="theme-btn print-btn btn-sm text-light"><i class="far fa-list" aria-hidden="true"></i>{{__('Generate List')}}</a>
                    </div>
                    @endcan
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable">
                        <thead>
                        <tr>
                            <th>User</th>
                            {{-- <th>Category</th> --}}
                            <th>Title</th>
                            <th>Type</th>
                            <th>Credits Cost</th>
                            <th>Created At</th>
                        </tr>
                        </thead>
                        <tbody class="searchResults">
                            <td>{{ optional($generate->user)->name }}</td>
                            {{-- <td>{{ optional($generate->category)->name ?? 'N/A' }}</td> --}}
                            <td>{{ $generate->title }}</td>
                            <td>
                                <div class="badge bg-{{ $generate->type == 'text' ? 'success' : 'danger' }}">
                                    {{ ucfirst($generate->type) }}
                                </div>
                            </td>
                            <td class="text-danger fw-bold">-{{ $generate->cost_credits }}</td>
                            <td>{{ formatted_date($generate->created_at) }}</td>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-4 generates-view">
                    <div class="col-12">
                        <h6 class="mb-3">{{ __('Generated '. ucfirst($generate->type)) }}</h6>
                        <table class="table">
                            @if ($generate->type == 'text')
                                @foreach ($generate->data as $key => $data)
                                    <tr>
                                        <th>{{ $data }}</th>
                                    </tr>
                                @endforeach
                            @else
                                <div class="row">
                                    @foreach ($generate->data as $key => $data)
                                        <div class="col-sm-4 col-md-3">
                                            <a href="{{ asset($data) }}" target="_blank">
                                                <img src="{{ asset($data) }}" alt="">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
