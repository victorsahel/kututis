<div class="form-label">{{ $slot }}</div>
<div>
    @foreach($data as $item)
    <label class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="Habilitado" value="1">
        <span class="form-check-label">Sí</span>
    </label>
    <label class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="Habilitado" value="0">
        <span class="form-check-label">No</span>
    </label>
    @endforeach
</div>
