<label class="form-check form-check-inline">
    <input class="form-check-input {{--@error($name) is-invalid @enderror--}}" type="radio" name="{{$name}}" value="{{ $value }}" {{ $isSelected($value) ? 'checked' : '' }}>
    <span class="form-check-label">{{ $slot }}</span>
</label>
