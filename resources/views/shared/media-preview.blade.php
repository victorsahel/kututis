<div class="card theme-dark">
    <div class="card-body">
        @forelse($input as $id => $type)
            @if($loop->odd)
                <div class="row">
            @endif
                    <div class="col-6">
                        @switch($type)
                            @case('video')
                            <label class="form-label">Video guardado:</label>
                            <div>
                                <video id="{{$id}}" class="mw-100">
                                </video>
                            </div>
                            @break
                            @case('imagen')
                            <label class="form-label">Imagen guardada:</label>
                            <div>
                                <img id="{{$id}}" class="mw-100">
                            </div>
                            @break
                        @endswitch
                    </div>
            @if($loop->even)
                </div>
            @endif
        @empty
        @endforelse
    </div>
</div>
