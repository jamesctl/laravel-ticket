@section('title')
    {{ trans('general.update') }} {{ $item->name }}
@stop
@extends('admin.general.master')
@section('content')

    <!-- BEGIN: Content-->
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
                                                class="d-none d-sm-block">{{ trans('general.item') }}</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active fade show" id="admin" aria-labelledby="account-tab"
                                        role="tabpanel">
                                        {{ html()->modelForm($item, 'POST', route('admin.seo.update', $item->id))
                                        ->class('form-horizontal form-label-left')
                                        // ->attribute('enctype', 'multipart/form-data')
                                        ->open() }}
                                        
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ trans('general.title') }}</label>
                                                    <input type="text" name="title"
                                                           class="form-control add-pages-title" value="{{ $item?->title }}">
                                                </div>
                                                @error('title')<i class="text-danger">{{ $message }}</i>@enderror

                                                <div class="form-group">
                                                    <label>{{ trans('general.short_description') }} <span class="text-uppercase"></span></label>
                                                    <textarea name="short_description" class="form-control short_description">{!! $item?->short_description !!}</textarea>
                                                </div>
                                                @error('short_description')<i class="text-danger">{{ $message }}</i>@enderror

                                                <div class="form-group">
                                                    <label>{{ trans('general.description') }} <span class="text-uppercase"></span></label>
                                                    <textarea name="description" rows="10" class="form-control">{{$item?->description}}</textarea>
                                                </div>

                                                {{-- <div class="form-group">
                                                    <label>{{ trans('general.description') }}</label>
                                                    <input type="text" name="description"
                                                           class="form-control add-pages-title" value="{{ $item->description }}">
                                                </div> --}}

                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <span>{{ trans('general.status') }}</span>
                                                            </div>
                                                        </div>
                                                        <select name="status" class="form-control col-3">
                                                            <option value="active" @if ($item->status === 'active') {{ 'selected' }} @endif>
                                                                {{ trans('general.active') }}
                                                            </option>
                                                            <option value="inactive" @if ($item->status === 'inactive') {{ 'selected' }} @endif>
                                                                {{ trans('general.inActive') }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <span>{{ trans('general.sort') }}</span>
                                                            </div>
                                                        </div>
                                                        <input value="{{$item?->sort}}" type="number" name="sort" class="form-control col-3" />
                                                    </div>
                                                </div>
                                                @error('sort')<i class="text-danger">{{ $message }}</i>@enderror

                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <span>{{ trans('general.price') }}</span>
                                                            </div>
                                                        </div>
                                                        <input value="{{$item?->price}}" type="number" name="price" class="form-control col-3" />
                                                    </div>
                                                </div>
                                                @error('price')<i class="text-danger">{{ $message }}</i>@enderror
                                            </div>


                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                                <button type="submit"
                                                    class="submit-btn btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">{{ trans('general.update') }}</button>
                                                <button type="reset"
                                                    class="btn btn-light">{{ trans('general.reset') }}</button>
                                            </div>
                                        </div>
                                        {{ html()->form()->close() }}
                                        <!-- users edit account form ends -->
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- users edit ends -->
            </div>
        </div>
    </div>


@endsection

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

            // $('.description').summernote({
            //     tabsize: 2,
            //     height: 300,
            //     toolbar: [
            //         ['style', ['style']],
            //         ['font', ['bold', 'underline', 'clear']],
            //         ['color', ['color']],
            //         ['para', ['ul', 'ol', 'paragraph']],
            //         ['table', ['table']],
            //         ['insert', ['link']],
            //         ['view', ['codeview']]
            //     ]
            // });
        })
    </script>
@endpush
