<div class="form-file thumbnail">
    <div class="form-label form-label-placeholder {{$required? 'required' : 'required'}}">{{ $slot }}</div>
    <input type="file" class="form-file-input {{--@error($name) is-invalid @enderror--}}" id="{{$name}}"
           name="{{$name}}"
           value="{{ $value ?? old($name) }}" accept="{{ $accept ?? '' }}">
    <label class="form-file-label" for="{{$name}}">
        <span class="form-file-text form-control-light">Elegir archivo...</span>
        <span class="form-file-button form-control-light"><i class="fas fa-paperclip text-primary"></i></span>
    </label>
    @error($name)
    <span class="invalid-feedback">{{$message}}</span>
    @enderror
</div>
<input type="hidden" name="{{$key}}" value="{{ session($key) }}">



@section('scripts')
    @once
    @parent
    @endonce

    <script>
        let {{$key}} = new UploadPreview($('#{{$name}}'), '{{$preloaded}}');
        @if($preview)
        {{$key}}.preview($('#{{$preview}}'));
        @endif
    </script>
@append
