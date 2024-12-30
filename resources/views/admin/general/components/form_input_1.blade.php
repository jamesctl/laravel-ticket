<div class="col-12">
    <div class="form-group">
        <div class="controls">
            <label>{{ trans("general.$text") }}</label>
            {{-- {{ html()->text($key . "[$text]"", $settings->setting_value[$key]["$text"] ?? '')->class('form-control')->placeholder(__('general.$text')) }} --}}
            {{ html()->text($key . "[$text]", $settings->setting_value[$key]["$text"] ?? '')->class('form-control')->placeholder(__("general.$text")) }}
        </div>
    </div>
</div>
