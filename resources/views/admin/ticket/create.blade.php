@section('title')
    {{ trans('general.add') }} {{ trans('general.ticket') }}
@stop
@extends('admin.general.master')
@section('content')
<link href="{{asset('themes/admin/assets/css/summernote.min.css')}}" rel="stylesheet">

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- users edit start -->
                <section class="users-edit">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <ul class="nav nav-tabs mb-2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center active" id="account-tab"
                                            data-toggle="tab" href="#account" aria-controls="account" role="tab"
                                            aria-selected="true">
                                            <i class="bx bxs-categories mr-25"></i><span
                                                class="d-none d-sm-block">{{ trans('general.ticket') }}</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <form method="POST" action="{{route('admin.ticket.store')}}" enctype="multipart/form-data">
                                        @csrf
                                        <!-- Basic Inputs start -->
                                        <div class="row">
                                            <div class="col-12 py-4">
                                                <h2>{{__('ticket.lb_support_ticket')}}</h2>
                                            </div>
                                        </div>
                                        <section id="basic-input">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title">{{__('ticket.lb_ticket_info')}}</h4>
                                                        </div>
                                                        <div class="card-content">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <fieldset class="form-group">
                                                                            <label for="basicInput">{{__('ticket.lb_customer_name')}}</label>
                                                                            <input type="text" class="form-control" name="name" required id="basicInput"
                                                                                placeholder="{{__('ticket.lb_customer_name')}}">
                                                                        </fieldset>
                        
                                                                        <fieldset class="form-group">
                                                                            <label for="helpInputTop">{{__('ticket.lb_department')}}</label>
                                                                            <select class="form-control" name="department_id" id="basicSelect">
                                                                                @if(!empty($departments))
                                                                                    @foreach($departments as $department)
                                                                                        <option value="{{$department->id}}">{{$department->name}}</option>
                                                                                    @endforeach
                                                                                @else
                                                                                    <option>Phòng kỹ thuật</option>
                                                                                    <option>IT</option>
                                                                                @endif
                                                                            </select>
                                                                        </fieldset>
                        
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <fieldset class="form-group">
                                                                            <label for="helpInputTop">{{__('ticket.lb_email')}}</label>
                                                                            <input type="email" name="email" class="form-control" required id="basicInput"
                                                                                placeholder="{{__('ticket.lb_email')}}">
                                                                        </fieldset>
                                                                        <fieldset class="form-group">
                                                                            <label for="disabledInput">{{__('ticket.lb_ticket_title')}}</label>
                                                                            <input type="text" class="form-control" name="title" required id="basicInput"
                                                                                placeholder="{{__('ticket.lb_ticket_title')}}">
                                                                        </fieldset>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <!-- Basic Inputs end -->
                                        <!-- Snow Editor start -->
                                        <section class="snow-editor">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title">{{__('ticket.lb_ticket_content')}}</h4>
                                                        </div>
                                                        {{-- <div class="card-content">
                                                            <textarea 
                                                                rows="3" 
                                                                class="mb-3 d-none" 
                                                                name="body"
                                                                id="quill-editor-area"></textarea>
                                                        </div> --}}
                                                        <div class="card-content collapse show">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        
                                                                        <div id="snow-wrapper">
                                                                            <div id="snow-container">
                                                                                <div class="quill-toolbar">
                                                                                    <span class="ql-formats">
                                                                                        <select class="ql-header">
                                                                                            <option value="1">Heading</option>
                                                                                            <option value="2">Subheading</option>
                                                                                            <option selected>Normal</option>
                                                                                        </select>
                                                                                        <select class="ql-font">
                                                                                            <option selected>Sailec Light</option>
                                                                                            <option value="sofia">Sofia Pro</option>
                                                                                            <option value="slabo">Slabo 27px</option>
                                                                                            <option value="roboto">Roboto Slab</option>
                                                                                            <option value="inconsolata">Inconsolata</option>
                                                                                            <option value="ubuntu">Ubuntu Mono</option>
                                                                                        </select>
                                                                                    </span>
                                                                                    <span class="ql-formats">
                                                                                        <button class="ql-bold"></button>
                                                                                        <button class="ql-italic"></button>
                                                                                        <button class="ql-underline"></button>
                                                                                    </span>
                                                                                    <span class="ql-formats">
                                                                                        <button class="ql-list" value="ordered"></button>
                                                                                        <button class="ql-list" value="bullet"></button>
                                                                                    </span>
                                                                                    <span class="ql-formats">
                                                                                        <button class="ql-link"></button>
                                                                                        <button class="ql-image"></button>
                                                                                        <button class="ql-video"></button>
                                                                                    </span>
                                                                                    <span class="ql-formats">
                                                                                        <button class="ql-formula"></button>
                                                                                        <button class="ql-code-block"></button>
                                                                                    </span>
                                                                                    <span class="ql-formats">
                                                                                        <button class="ql-clean"></button>
                                                                                    </span>
                                                                                </div>
                                                                                <div class="editor">
                                                                                    {{-- <h2>Quill Rich Text Editor</h2> --}}
                                                                                </div>
                                                                                <div>
                        
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <!-- Snow Editor end -->
                                        <!-- File uploader -->
                                        <section class="snow-editor">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card pb-1">
                                                        <div class="card-header">
                                                            <h4 class="card-title">{{__('ticket.lb_ticket_attachment')}}</h4>
                                                        </div>
                                                        <div class="box-file-uploader">
                                                            <div class="form-group">
                                                                <input type="file" name="files[]" class="form-control-file" id="exampleFormControlFile1" multiple>
                        
                                                            </div>
                                                            <button type="button" class="btn btn-outline-primary mr-1 mb-1"><i
                                                                    class="bx bx-plus"></i><span class="align-middle ml-25">{{__('ticket.lb_ticket_add_file')}}</span></button>
                                                        </div>
                                                        <label class="text-capitalize px-2">
                                                            {{__('ticket.lb_ticket_file_note')}}:: .jpg, .gif, .jpeg, .bmp, .doc, .docx, .xls,
                                                            .xlsx, .csv, .png, .pdf ({{__('ticket.lb_ticket_file_limit')}}: 2MB)
                                                        </label>
                        
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <div class="box-btn btn-submit-ticket">
                                            <input type="hidden" name="description" id="description" />
                                            <button type="submit" id="send_ticket" class="btn btn-secondary mr-1 mb-1 btn-lg">{{__('ticket.lb_send_ticket')}}</button>
                                            <button type="button" class="btn btn-outline-danger mr-1 mb-1 btn-lg">{{__('ticket.lb_cancel_ticket')}}</button>
                                        </div>
                                        <!-- Snow Editor end -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- users edit ends -->
            </div>
        </div>
    </div>
@stop


@push('js')
    <script src="{{asset('themes/admin/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('themes/admin/assets/js/summernote.min.js')}}"></script>
    <script>
        $(document).ready(function (){
            $('.short_description').summernote({
                tabsize: 2,
                height: 100,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });

            $('.description').summernote({
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ],
                callbacks: {
                    onChange: function(contents, $editable) {
                        $($editable).parents('.editor').prev().trigger('input');
                    }
                }
            });
        });

        $('#send_ticket').on('click', function() {
            let content = $('.ql-editor').html();
            $('#description').val(content);
        });

    </script>
@endpush
