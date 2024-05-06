@extends('layouts.master')

@section('title')
    {{__ ('Currency Edit') }}
@endsection

@section('main_content')
    <div class="order-form-section">
        <div class="erp-table-section">
            <div class="container-fluid">
                <div class="table-header">
                    <h4>{{__('Edit Currency')}}</h4>
                </div>
                <form action="{{ route('admin.currencies.update', $currency->id) }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <label>{{__('Name')}}</label>
                            <input type="text" name="name" value="{{ $currency->name }}" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="col-lg-6 mt-2">
                            <label>{{__('Code')}}</label>
                            <input type="text" name="code" value="{{ $currency->code }}" class="form-control" placeholder="Enter Code">
                        </div>
                        <div class="col-lg-6 mt-2">
                            <label>{{__('Rate')}}</label>
                            <input type="number" step="any" name="rate" value="{{ $currency->rate }}" class="form-control" placeholder="Enter Rate">
                        </div>
                        <div class="col-lg-6 mt-2">
                            <label>{{__('Symbol')}}</label>
                            <input type="text" name="symbol" value="{{ $currency->symbol }}" class="form-control" placeholder="Enter Symbol">
                        </div>
                        <div class="col-lg-6 mt-2">
                            <label>{{__('Position')}}</label>
                            <select name="position" class="form-control table-select w-100">
                                <option value="">{{__('Select a position')}}</option>
                                <option value="left" @selected('left' == $currency->position)>{{__('left')}}</option>
                                <option value="right" @selected('right' == $currency->position)>{{__('right')}}</option>
                            </select>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <label>{{__('Status')}}</label>
                            <select name="status" class="form-control table-select w-100">
                                <option value="1" @selected( $currency->status == 1)>{{__('Active')}}</option>
                                <option value="0" @selected( $currency->status == 0)>{{__('Inactive')}}</option>
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <div class="button-group text-center mt-5">
                                <a href="{{ route('admin.currencies.index') }}"
                                   class="theme-btn border-btn m-2">{{__('Cancel')}}</a>
                                <button class="theme-btn m-2 submit-btn">{{__('Save')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

