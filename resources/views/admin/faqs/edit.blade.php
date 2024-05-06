@extends('layouts.master')

@section('title')
    {{ __('FAQs') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Edit FAQs')}}</h4>
                @can('faqs-read')
                    <a href="{{ route('admin.faqs.index') }}" class="add-order-btn rounded-2 {{ Route::is('admin.faqs.create') ? 'active' : '' }}"><i class="far fa-list" aria-hidden="true"></i> {{ __('FAQs List') }}</a>
                @endcan
            </div>
            <div class="order-form-section">
                <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST" enctype="multipart/form-data" class="ajaxform_instant_reload">
                    @csrf
                    @method('put')
                    <div class="add-suplier-modal-wrapper">
                        <div class="row justify-content-center">
                            <div class="col-sm-10 col-md-8">
                                <div class="row">
                                    <div class="col-lg-6 mt-2">
                                        <label>{{('Question')}}</label>
                                        <input type="text" name="question" value="{{ $faq->question }}" required class="form-control" placeholder="Enter Question">
                                    </div>
                                    
                                    <div class="col-lg-6 mt-2">
                                        <label>{{__('Status')}}</label>
                                        <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                            <p class="dynamic-text">{{ $faq->status == 1 ? 'Active' : 'Deactive' }}</p>
                                            <label class="switch m-0">
                                                <input type="checkbox" name="status" class="change-text" {{ $faq->status == 1 ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
        
                                    <div class="col-lg-12 mt-2">
                                        <label>{{__('Answer')}}</label>
                                        <textarea name="answer" rows="4" class="form-control" placeholder="faqs">{{ $faq->answer }}</textarea>
                                    </div>
                                    
                                    <div class="col-lg-12">
                                        <div class="button-group text-center mt-5">
                                            <a href="{{ route('admin.faqs.index') }}"
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
