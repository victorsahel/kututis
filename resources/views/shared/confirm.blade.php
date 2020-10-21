{{-- VARIABLES
    $modal = [
        'id':       -- str -- 'alert' //Id del modal
        'title'     -- str -- 'Confirmar' //Titulo del modal
        'action'    -- str -- 'realizar' // "Está seguro que desea {action} {info}?
        'info'      -- str -- 'esta operación' // "Está seguro que desea {action} {info}?
        'type',     -- ??? -- //TODO
        'show'      -- 'load'|'check'|'click' // load [al cargar la pagina]; check [al
        'confirm'   -- true|false -- true
        'cancel'    -- ture|false -- ture
    ]
--}}

<?php $modal_id = $modal['id'] ?? 'alert' ?>

@section('modals')
    <div class="modal modal-blur fade" id="{{$modal_id}}" role="dialog" tabindex="-1">
        <div class="modal-dialog {{$modal['size'] ?? 'modal-sm'}} modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    @section('modal-title')
                        <div class="modal-title text-center">{{$modal['title'] ?? 'Confirmar'}}</div>
                    @show
                    @section('modal-body')
                        <p>¿Está seguro que desea <span class="data-action">{{$modal['action'] ?? 'realizar'}} </span>
                            <span class="data-info">{{$modal['info'] ?? 'este elemento'}}?</span></p>
                    @show
                </div>
                @section('modal-footer')
                    <div class="modal-footer justify-content-center">
                        <div class="btn-list flex-nowrap">
                            @if($modal['cancel'] ?? true)
                                <button type="button"
                                        class="btn {{$modal['cancel_class'] ?? 'btn-secondary'}} mx-2 modal-cancel"
                                        data-dismiss="modal">{{$modal['cancel_txt'] ?? 'Cancelar'}}</button>
                            @endif
                            @if($modal['confirm'] ?? true)
                                <a type="button"
                                   class="btn {{$modal['confirm_class'] ?? 'btn-primary'}} mx-2 modal-confirm"
                                   href="{{$modal['confirm_url'] ?? url()->current()}}">{{$modal['confirm_txt'] ?? 'Aceptar'}}</a>
                            @endif
                        </div>
                    </div>
                @show
            </div>
        </div>
    </div>
@append


@section('scripts')
    @parent
    @switch($modal['show'] ?? '')
        @case('load')
        <script>
            $('#{{$modal_id}}').modal('show');
        </script>
        @break
        @case('check')
        <script>
            function checkElement(e, url, action, info) {
                openConfirm(url, action, info);
                e.checked = !e.checked;
            }
        </script>
        @default
        <script>
            const openConfirm = (url, action, info, closeHandler) => {
                $('#{{$modal_id}} .modal-confirm').attr('href', url);

                if (action != null) {
                    $('#{{$modal_id}} .data-action').text(action);
                }
                if (info != null) {
                    $('#{{$modal_id}} .data-info').text(info);
                }
                if (closeHandler != null) {
                    $('#{{$modal_id}}').on('hidden.bs.modal', closeHandler);
                }
                $('#{{$modal_id}}').modal('show');
            }
        </script>
        @break
    @endswitch
@append
