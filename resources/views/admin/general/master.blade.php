@include('admin.general.header')
@include('admin.general.left')
@yield('content')
@include('admin.general.footer')
@yield('after_js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('body').on('click', '.submit-btn', function(e) {
        $('.submit-btn').loading()
        $(this).parents('form').submit()
    });

    const changeTab = (idName, key) => {
        $('#'+idName+'Main button').removeClass('active');
        $('#'+idName+'Main .'+key+'-tab').addClass('active');
        $('#'+idName+'Content div').removeClass('show active');
        $('#'+idName+'Content .'+key+'-nav-content').addClass('show active');
    }

    $('.summernote').summernote(
        {
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
                ['fontsize', ['fontsize']],
            ],
            height: 400,
            callbacks: {
                onImageUpload: function(files, editor, welEditable) {
                    const formData = new FormData()
                    for (let index = 0; index < files.length; index++) {
                        const element = files[index];
                        formData.append('images[]', element)
                    }
                    var data = uploadSummernoteImage(formData, this)
                },
                onChange: function(contents, $editable) {
                    $($editable).parents('.note-editor').prev().trigger('input')
                }
            },
        }
    )

    $.fn.multipleLanguages = function() {
        const languages = ['ja', 'en', 'vi'];
        let html = `<ul class="nav nav-tabs">`
        languages.forEach((lang) => {
            html += ` <li class="nav-item">
    <a class="nav-link active" href="#">${lang}</a> </li>`
        })
        html += `</ul>`
        $(this).after(html)
        // this.remove()
    }
    $('.multiple-languages').multipleLanguages()
</script>
<script>
    $('body').on('click', '.confirm-button', async function(e) {
        e.preventDefault()
        const result = await Swal.fire({
            title: '{{ __('general.areYouSure') }}',
            text: "{{ __('general.confirmWarningMessage') }}",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ __('general.accept') }}',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
        })
        if (result.value) {
            $(this).loading()
            $(e.currentTarget).parents('form').submit()
        }
    })
</script>
@stack('js')
