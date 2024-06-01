@extends('layouts.master')

@section('title')
    {{ __('Suggestion') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Edit Suggestion')}}</h4>
                @can('suggestions-read')
                    <a href="{{ route('admin.suggestions.index') }}" class="add-order-btn rounded-2 {{ Route::is('admin.suggestions.create') ? 'active' : '' }}"><i class="far fa-list" aria-hidden="true"></i> {{ __('Suggestion List') }}</a>
                @endcan
            </div>
            <div class="order-form-section">
                <form action="{{ route('admin.suggestions.update', $suggestion->id) }}" method="POST" class="ajaxform_instant_reload">
                    @csrf
                    @method('put')
                    <div class="add-suplier-modal-wrapper">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-12 mt-2">
                                        <label>{{__('Name')}}</label>
                                        <textarea name="name" class="form-control" placeholder="Name">{{ $suggestion->name }}</textarea>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{__('Image Name')}}</label>
                                        <textarea name="image_name" class="form-control" placeholder="Image Name">{{ $suggestion->image_name }}</textarea>
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <label>{{__('Category')}}</label>
                                        <div class="gpt-up-down-arrow position-relative">
                                            <select name="category_id" required class="form-control table-select w-100">
                                                <option>{{ __('Select Category') }}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" @selected($category->id == $suggestion->category_id)>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <label>{{__('Status')}}</label>
                                        <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                            <p class="dynamic-text">{{ $suggestion->status == 1 ? 'Active' : 'Deactive' }}</p>
                                            <label class="switch m-0">
                                                <input type="checkbox" name="status" class="change-text" {{ $suggestion->status == 1 ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{__('Suggestions')}}</label>
                                        <textarea name="suggestions" class="form-control" placeholder="Suggestions">{{ $suggestion->suggestions }}</textarea>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="button-group text-center mt-5">
                                            <a href="{{ route('admin.suggestions.index') }}"
                                               class="theme-btn border-btn m-2">{{__('Cancel')}}</a>
                                            <button class="theme-btn m-2 submit-btn">{{__('Save')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
