<div class="modal fade" id="delete-box-modal" tabindex="-1" role="dialog" aria-labelledby="delete-box-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{trans('general.delete')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="delete-message">

                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">No</span>
                </button>
                <a  class="btn btn-primary ml-1 message-href" href="javascript:void(0)">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Yes</span>
                </a>
            </div>
        </div>
    </div>
</div>
 <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix mb-0"><span class="float-left d-inline-block">{{date('Y')}} &copy; treasury.jp</span>
            <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="bx bx-up-arrow-alt"></i></button>
        </p>
    </footer>

    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{url('themes/admin')}}/app-assets/vendors/js/vendors.min.js"></script>
    <script src="{{url('themes/admin')}}/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
    <script src="{{url('themes/admin')}}/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
    <script src="{{url('themes/admin')}}/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <!-- BEGIN Vendor JS-->
 <script src="{{url('themes/admin')}}/app-assets/vendors/js/extensions/dropzone.min.js"></script>
    <script src="{{url('themes/admin')}}/app-assets/vendors/js/ui/prism.min.js"></script>
    <!-- BEGIN: Page Vendor JS-->

    <script src="{{url('themes/admin')}}/app-assets/vendors/js/extensions/dragula.min.js"></script>
    <!-- END: Page Vendor JS-->
<script src="{{url('themes/admin')}}/app-assets/vendors/js/extensions/toastr.min.js"></script>
@include('admin.general.notification')
    <!-- BEGIN: Theme JS-->
    <script src="{{url('themes/frontend')}}/assets/vendors/jquery/jquery-3.6.0.min.js"></script>
    {{-- <script src="{{url('themes/frontend/js')}}/jquery.validate.min.js"></script> --}}
    <script src="{{url('themes/admin')}}/app-assets/js/core/app-menu.js"></script>
    <script src="{{url('themes/admin')}}/app-assets/js/core/app.js"></script>
    <script src="{{url('themes/admin')}}/app-assets/js/scripts/components.js"></script>
    <script src="{{url('themes/admin')}}/app-assets/js/scripts/footer.js"></script>

     <script src="{{url('themes/admin')}}/app-assets/vendors/js/editors/quill/katex.min.js"></script>
    <script src="{{url('themes/admin')}}/app-assets/vendors/js/editors/quill/highlight.min.js"></script>
    <script src="{{url('themes/admin')}}/app-assets/vendors/js/editors/quill/quill.min.js"></script>
    <script src="{{url('themes/admin')}}/app-assets/vendors/js/extensions/jquery.steps.min.js"></script>
    <script src="{{url('themes/admin')}}/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="{{url('quill')}}/tidy_html5.min.js"></script>
    <!-- <script src="{{url('quill')}}/quill.min.js"></script> -->
    <script src="{{url('quill')}}/image-resize.min.js?version={{config('jscss.js')}}"></script>
    <script src="{{url('themes/admin/js')}}/global.js?v={{config('jscss.js')}}"></script>
    <script src="{{ asset('themes/frontend/assets/vendors/jquery/jquery-ui.js') }}"></script>
    <script src="{{ asset('themes/frontend/assets/vendors/jquery/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('themes/frontend/assets/vendors/jquery/tinymce_7_6_0/js/tinymce.min.js') }}"></script>
    <script src="{{ asset('themes/frontend/assets/vendors/jquery/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/frontend/assets/vendors/jquery/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/jquery.form.min.js') }}"></script>
    <script src="{{ asset('themes/admin/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('themes/admin/app-assets/vendors/js/editors/quill/quill.min.js') }}"></script>
    <script src="{{url('themes/admin')}}/app-assets/js/scripts/editors/editor-quill.js"></script>
    @livewireScripts
    <!-- END: Theme JS-->


    <!-- BEGIN: Page JS-->

    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>
