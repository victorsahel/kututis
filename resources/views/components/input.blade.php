<div class="form-label-group">
    <input type="{{$type}}" class="form-control form-control-light {{--@error($name) is-invalid @enderror--}}" id="{{$name}}" name="{{$name}}"
           value="{{ $value ?? old($name) }}" placeholder="{{$slot}}" {{ $attributes }}>
    <label for="{{$name}}" class="form-label form-label-placeholder {{$required? 'required' : ''}}">{{ $slot }}</label>
</div>
@error($name)
<span class="invalid-feedback">{{$message}}</span>
@enderror
