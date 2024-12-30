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
            <option value="active" @if ($status === 'active'){{ 'selected' }}@endif>
                {{ trans('general.active') }}
            </option>
            <option value="inactive" @if ($status === 'inactive') {{ 'selected' }}@endif>
                {{ trans('general.inActive') }}
            </option>
        </select>

        @if($isUseSort)
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <span>{{ trans('general.sort') }}</span>
                </div>
            </div>
            <input name="sort" class="form-control col-1" value="{{ $sort }}">
        @endif
    </div>
</div>
