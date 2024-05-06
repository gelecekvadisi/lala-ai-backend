@extends('layouts.master')

@section('title')
    {{__ ('Currency') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Currency List')}}</h4>
            </div>
            <div class="responsive-table">
                <table class="table" id="erp-table">
                    <thead>
                    <tr>
                        <th>{{__('SL.')}}</th>
                        <th>{{__('name')}}</th>
                        <th>{{__('code')}}</th>
                        <th>{{__('rate')}}</th>
                        <th>{{__('symbol')}}</th>
                        <th>{{__('status')}}</th>
                        <th>{{__('Default')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($currencies as $currency )
                        <tr>
                            <td>{{ ($currencies->perPage() * ($currencies->currentPage() - 1)) + $loop->iteration }} <i class="{{ request('id') == $currency->id ? 'fas fa-bell text-red' : '' }}"></i></td>
                            <td>{{ $currency->name }}</td>
                            <td>{{ $currency->code }}</td>
                            <td>{{ $currency->rate }}</td>
                            <td>{{ $currency->symbol }}</td>
                            <td>
                                <div class="{{ $currency->status == 1 ? 'badge bg-success' : 'badge bg-danger' }}">
                                    {{ $currency->status == 1 ? 'Active' : 'Inactive' }}
                                </div>
                            </td>
                            <td>
                                <div class="{{ $currency->is_default == 1 ? 'badge bg-success' : 'badge bg-danger' }}">
                                    {{ $currency->is_default == 1 ? 'Yes' : 'No' }}
                                </div>
                            </td>
                            <td>
                                <div class="dropdown table-action">
                                    <button type="button" data-bs-toggle="dropdown">
                                        <i class="far fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.currencies.edit',$currency->id) }}">
                                                <i class="fal fa-pencil-alt"></i>
                                                {{__('Edit')}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                {{-- table end --}}
            </div>
            <div>
                {{ $currencies->links() }}
            </div>
        </div>
    </div>

@endsection

