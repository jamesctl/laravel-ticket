@section('title')
{{ trans('general.reply') }} {{ trans('general.ticket') }}
@stop
@extends('admin.general.master')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-12">
                <!-- Ticket Section -->
                <div class="collapsible email-detail-head">
                    <div class="card collapse-header bg-gray " role="tablist">
                        <div id="headingCollapse5" class="card-header d-flex justify-content-between align-items-center"
                            data-toggle="collapse" role="tab" aria-expanded="false" aria-controls="collapse5">
                            <div class="collapse-title media">
                                <div class="pr-1">
                                    <div class="avatar mr-75">
                                        <img src="{{asset('assets/male_avatar.jpeg')}}" height="30" alt="male_avatar.jpeg">
                                    </div>
                                </div>
                                <div class="media-body mt-25">
                                    <span class="text-primary">{{$ticketData->customer->name}}</span>
                                    <span class="d-sm-inline d-none"> &lt;{{$ticketData->customer->email}}&gt;</span>
                                    <small class="text-muted d-block">to {{$ticketData->user->email}}</small>
                                </div>
                            </div>
                            <div class="information d-sm-flex d-none align-items-center">
                                <small class="text-muted mr-50">{{ (new DateTime($ticketData->created_at))->format('d M Y, H:i') }}</small>
                                @php
                                $statusClass = [
                                'New' => 'badge-light-primary',
                                'Processing' => 'badge-light-warning',
                                'Complete' => 'badge-light-success',
                                'Close' => 'badge-light-secondary'
                                ];
                                @endphp
                                <span class="badge badge-pill {{$statusClass[$ticketData->status] ?? 'badge-light-primary'}} status-ticket">
                                    {{$ticketData->status}}</span>
                            </div>

                        </div>
                        <div role="tabpanel" aria-labelledby="headingCollapse5" class="collapse show">
                            <div class="card-content border-top">
                                <div class="card-body py-1">
                                    <!-- <p class="text-bold-500">Greetings!</p> -->
                                    <p>
                                        {!! $ticketData->description !!}
                                    </p>
                                    <!-- <p class="mb-0">Sincerely yours,</p>
                    <p class="text-bold-500">Envato Design Team</p> -->
                                </div>
                                <div class="card-footer border-top">
                                    <label class="sidebar-label">Attached Files</label>
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($ticketData->ticketAttachments as $item)
                                        <li class="cursor-pointer pb-25">
                                            <a href="{{ Storage::url($path . $item->filename) }}" download>
                                                <img src="{{ asset('themes/admin/app-assets/images/minetype/' . get_icon_for_mime_type($item['mime_type'])) }}" height="30">

                                                <small class="text-muted ml-1 attchement-text">{{$item?->name ?? 'N/A'}} <span>: {{ (new DateTime($item->created_at))->format('d M Y, H:i') }}</span></small>
                                            </a>
                                        </li>
                                        <!-- <li class="cursor-pointer">
                                            <img src="{{asset('themes/admin/app-assets/images/icon/sketch.png')}}" height="30" alt="sketch.png">
                                            <small class="text-muted ml-1 attchement-text">uikit-design.sketch(142KB) <span>: 15 Jul
                                                    2019,10:30</span></small>
                                        </li> -->
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Ticket Section -->

                <!-- Reply Section -->
                @foreach ($ticketData->replies as $relyData)

                <div class="collapsible email-detail-head ml-1">
                    <div class="card collapse-header" role="tablist">
                        <div id="headingCollapse5" class="card-header d-flex justify-content-between align-items-center"
                            data-toggle="collapse" role="tab" aria-expanded="false" aria-controls="collapse5">
                            <div class="collapse-title media">
                                <div class="pr-1">
                                    <div class="avatar mr-75">
                                        <img src="{{asset('assets/male_avatar.jpeg')}}" height="30" alt="male_avatar.jpeg">
                                    </div>
                                </div>
                                <div class="media-body mt-25">
                                    <!-- <span class="text-primary">{{$ticketData->customer->name}}</span> -->
                                    <span class="d-sm-inline d-none"> &lt;{{$relyData->from_email}}&gt;</span>
                                    <small class="text-muted d-block">to {{$relyData->to_email}}</small>
                                </div>
                            </div>
                            <div class="information d-sm-flex d-none align-items-center">
                                <small class="text-muted mr-50">{{ (new DateTime($relyData->created_at))->format('d M Y, H:i') }}</small>
                                <!-- <span class="badge badge-pill {{$statusClass[$ticketData->status] ?? 'badge-light-primary'}}">
                                    {{$ticketData->status}}</span> -->
                            </div>

                        </div>
                        <div role="tabpanel" aria-labelledby="headingCollapse5" class="collapse show">
                            <div class="card-content border-top">
                                <div class="card-body py-1">
                                    <p>
                                        {!!$relyData->message!!}
                                    </p>
                                </div>
                                <div class="card-footer border-top">
                                    <label class="sidebar-label">Attached Files</label>
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($relyData->replyTicketAttachments as $item)
                                        <li class="cursor-pointer pb-25">
                                            <a href="{{ Storage::url($path . $item->filename) }}" download>
                                                <img src="{{ asset('themes/admin/app-assets/images/minetype/' . get_icon_for_mime_type($item['mime_type'])) }}" height="30">

                                                <small class="text-muted ml-1 attchement-text">{{$item?->name ?? 'N/A'}} <span>: {{ (new DateTime($item->created_at))->format('d M Y, H:i') }}</span></small>
                                            </a>
                                        </li>
                                        <!-- <li class="cursor-pointer pb-25">
                                            <img src="{{asset('themes/admin/app-assets/images/icon/psd.png')}}" height="30" alt="psd.png">
                                            <small class="text-muted ml-1 attchement-text">{{$item->filename}} (142KB) <span>: {{ (new DateTime($item->created_at))->format('d M Y, H:i') }}</span></small>
                                        </li> -->
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- End Reply Section -->
                <div class="col-12 px-0">
                    <div class="card shadow-none border rounded">
                        <div class="pt-2 px-2">
                            <fieldset class="form-group">
                                <label for="helpInputTop">Status</label>
                                <select class="form-control" id="basicSelect">
                                    <option>New</option>
                                    <option>Complete</option>
                                    <option>Processing</option>
                                    <option>Close</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="card-body quill-wrapper">
                            <span>Reply to {{$ticketData->customer->name}}</span>
                            <div id="editor">
                                <!-- <p>Xin chào, <strong>World</strong></p> -->
                            </div>
                            <div class="d-flex justify-content-end mt-50">
                                <button class="btn btn-primary send-btn submit-btn">
                                    <i class='bx bx-send mr-25'></i>
                                    <span class="d-none d-sm-inline"> Send</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@stop

@push('css')
<style>
    .bg-gray {
        background: #c4d0d5 !important;
    }
</style>
@endpush

@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        let status = $('.status-ticket').text().trim();
        $('#basicSelect').val(status);

        const toolbarOptions = [
            [{
                'header': [1, 2, 3, false]
            }],
            ['bold', 'italic', 'underline'], // toggled buttons
            ['link', 'image'],
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            ['clean'] // remove formatting button
        ];

        const quill = new Quill('#detail-view-quill, #editor', {
            placeholder: 'Write something to reply...',
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            },
        });

        let documentFiles = [];
        // Custom image handler to handle multiple file types (image, pdf, docx, etc.)
        let replyMessageRoot = null;
        let imageFiles = [];    // Mảng lưu riêng các ảnh

        // Khởi tạo sự kiện để theo dõi thay đổi trong Quill editor
        quill.on('text-change', function() {
            // Cập nhật lại nội dung của editor
            replyMessageRoot = quill.root.innerHTML.trim();
        });


        quill.getModule('toolbar').addHandler('image', function() {
            if (replyMessageRoot === null) {
                replyMessageRoot = quill.root.innerHTML; // Lưu nội dung gốc ban đầu
            }

            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*,.pdf,.docx,.doc,.xls,.xlsx'); // Accept multiple file types
            input.click();

            input.onchange = function() {
                const files = input.files;
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if (file) {
                        documentFiles.push(file); // Add the file to the array
                        imageFiles.push(file);

                        // Handle image files
                        /*
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const img = `<br><img width="100px" height="100px" src="${e.target.result}" />`;
                                const range = quill.getSelection();
                                quill.clipboard.dangerouslyPasteHTML(range.index, img);
                            };
                            reader.readAsDataURL(file);
                        } else {
                            // Handle other file types (PDF, DOCX, etc.)
                            const link = `<br><a href="${URL.createObjectURL(file)}" download>${file.name}</a>`;
                            const range = quill.getSelection();
                            quill.clipboard.dangerouslyPasteHTML(range.index, link);
                        }
                        */

                        const link = `<br><a href="${URL.createObjectURL(file)}" download>${file.name}</a>`;
                        const range = quill.getSelection();
                        quill.clipboard.dangerouslyPasteHTML(range.index, link);
                    }
                }
            };
        });

        // Function to sync documentFiles with editor content
        function syncDocumentFiles() {
            const editorContent = quill.root.innerHTML;

            documentFiles = documentFiles.filter((file) => {
                /*
                if (file.type.startsWith('image/')) {
                    // Check if the image exists in editor content
                    const imageSrc = URL.createObjectURL(file);
                    return editorContent.includes(imageSrc);
                } else {
                    // Check if the file link exists in editor content
                    return editorContent.includes(file.name);
                }
                */
                return editorContent.includes(file.name);
            });
        }

        // Send button click handler
        $('.send-btn').click(function() {
            const url = `{{ route('admin.ticket.sendReply') }}`;
            const ticketId = `{{$ticketData->id}}`;
            const cusName = `{{$ticketData->customer->name}}`;
            const emailSubject = `{{$ticketData->title}}`;
            const toEmail = `{{$ticketData->customer->email}}`;

            let replyMessage;
            if (replyMessageRoot != null) {
                replyMessage = replyMessageRoot;
            } else {
                replyMessage = quill.root.innerHTML; // Hoặc quill.getText() tùy theo nhu cầu
            }

            // Sync files with current editor content
            syncDocumentFiles();

            let status = $('#basicSelect').val();

            if (status == 'New')
                status = 'Processing';

            const formData = new FormData();

            // Append all files from the documentFiles array to FormData
            if (documentFiles.length > 0) {
                documentFiles.forEach(file => {
                    formData.append('files[]', file);
                });
            }

            // Collect other form data (if any) and append to formData
            formData.append('cusName', cusName);
            formData.append('ticketId', ticketId);
            formData.append('toEmail', toEmail);
            formData.append('subject', emailSubject);
            formData.append('message', replyMessage);
            formData.append('status', status);

            // Send the form data via AJAX
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false, // Don't set content type for FormData
                processData: false, // Don't process data (jQuery would try to transform it)
                success: function(response) {
                    window.location.reload();
                    toastr.success(response.message, 'success');
                    $('.spinner-border').hide();
                    $('.send-btn').prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.responseJSON?.errors?.message?.[0] || xhr.responseText || error;
                    toastr.error(errorMessage, 'Error');
                }
            });
        });

    });
</script>
@endpush