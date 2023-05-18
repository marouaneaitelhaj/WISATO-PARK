<div class="form-group">
    <label for="identity" class="text-md-right">{{ __('Operator') }}</label>
    <input type="search" class="form-control{{ $errors->has('operator') ? ' is-invalid' : '' }}" value="{{ old('operator') }}" name="operator">
    <select>
        <option value="">1</option>
        <option value="">1</option>
        <option value="">1</option>
        <option value="">1</option>
        <option value="">1</option>
        <option value="">1</option>
    </select>
    <!-- @if ($errors->has('operator'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('operator') }}</strong>
    </span>
    @endif -->
</div>