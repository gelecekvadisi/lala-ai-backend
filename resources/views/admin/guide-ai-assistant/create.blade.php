@extends('layouts.master')

@section('title')
    {{ __('Guide AI Assistant') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{ __('Add New Guide AI Assistant') }}</h4>
                <a href="{{ route('admin.guide-ai-assistant.index') }}"
                    class="add-order-btn rounded-2 {{ Route::is('admin.guide-ai-assistant.create') ? 'active' : '' }}"><i
                        class="far fa-list" aria-hidden="true"></i> {{ __('Guide AI Assistant List') }}</a>
            </div>
            <div class="order-form-section">
                <form action="{{ route('admin.guide-ai-assistant.store') }}" method="POST" enctype="multipart/form-data"
                    class="ajaxform_instant_reload">
                    @csrf
                    <div class="add-suplier-modal-wrapper">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 justify-content-center">
                                <div class="row">
                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Name') }}</label>
                                        <textarea name="name" class="form-control" placeholder="Name"></textarea>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Image Name') }}</label>
                                        <textarea name="image_name" class="form-control" placeholder="Image Name"></textarea>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Assistant ID') }}</label>
                                        <textarea name="assistant_id" class="form-control" placeholder="Assistant ID"></textarea>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Inputs') }}</label>
                                        <textarea name="inputs" class="form-control" placeholder="Inputs"></textarea>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Instructions Generator') }}</label>
                                        <textarea name="instructions_generator" class="form-control" placeholder="Instructions Generator"></textarea>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Spreadsheet Name') }}</label>
                                        <textarea name="spreadsheet_name" class="form-control" placeholder="Spreadsheet Name"></textarea>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Spreadsheet ID') }}</label>
                                        <textarea name="spreadsheet_id" class="form-control" placeholder="Spreadsheet ID"></textarea>
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <label>{{ __('Status') }}</label>
                                        <div
                                            class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                            <p class="dynamic-text">{{ __('Active') }}</p>
                                            <label class="switch m-0">
                                                <input type="checkbox" name="status" class="change-text" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="button-group text-center mt-5">
                                            <a href="{{ route('admin.guide-ai-assistant.index') }}"
                                                class="theme-btn border-btn m-2">{{ __('Cancel') }}</a>
                                            <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
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
