@php
    use App\Enums\StatusEnum as StatusEnum;
@endphp

<div class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <span>{{ trans('general.status') }}</span>
            </div>
        </div>
        <select name="status" class="form-control col-3">
            <option value="active" {{ old('status') === StatusEnum::ACTIVE ? 'selected' : '' }}>{{ trans('general.active') }}</option>
            <option value="inactive" {{ old('status') === StatusEnum::INACTIVE ? 'selected' : '' }}>{{ trans('general.inactive') }}</option>
        </select>
    </div>
</div>
