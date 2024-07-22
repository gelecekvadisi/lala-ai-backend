@extends('layouts.master')

@section('title')
    {{ __('Guide AI Assistant') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{ __('Edit Guide AI Assistant') }}</h4>
                <a href="{{ route('admin.guide-ai-assistant.index') }}"
                    class="add-order-btn rounded-2 {{ Route::is('admin.guide-ai-assistant.create') ? 'active' : '' }}"><i
                        class="far fa-list" aria-hidden="true"></i> {{ __('Guide AI Assistant List') }}</a>
            </div>
            <div class="order-form-section">
                <form action="{{ route('admin.guide-ai-assistant.update', $guideAiAssistant->id) }}" method="POST"
                    class="ajaxform_instant_reload">
                    @csrf
                    @method('put')
                    <div class="add-suplier-modal-wrapper">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Name') }}</label>
                                        <textarea name="name" class="form-control" placeholder="Name">{{ $guideAiAssistant->name }}</textarea>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Image Name') }}</label>
                                        <textarea name="image_name" class="form-control" placeholder="Image Name">{{ $guideAiAssistant->image_name }}</textarea>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Assistant ID') }}</label>
                                        <textarea name="assistant_id" class="form-control" placeholder="Assistant ID">{{ $guideAiAssistant->assistant_id }}</textarea>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Inputs') }}</label>
                                        <textarea name="inputs" class="form-control" placeholder="Inputs">{{ $guideAiAssistant->inputs }}</textarea>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Instructions Generator') }}</label>
                                        <textarea name="instructions_generator" class="form-control" placeholder="Instructions Generator">{{ $guideAiAssistant->instructions_generator }}</textarea>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Spreadsheet Name') }}</label>
                                        <textarea name="spreadsheet_name" class="form-control" placeholder="Spreadsheet Name">{{ $guideAiAssistant->spreadsheet_name }}</textarea>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Spreadsheet ID') }}</label>
                                        <textarea name="spreadsheet_id" class="form-control" placeholder="Spreadsheet ID">{{ $guideAiAssistant->spreadsheet_id }}</textarea>
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <label>{{ __('Status') }}</label>
                                        <div
                                            class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                            <p class="dynamic-text">
                                                {{ $guideAiAssistant->status == 1 ? 'Active' : 'Deactive' }}</p>
                                            <label class="switch m-0">
                                                <input type="checkbox" name="status" class="change-text"
                                                    {{ $guideAiAssistant->status == 1 ? 'checked' : '' }}>
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
