@foreach(['info','danger','success','warning'] as $msg)
    @if(Session::has($msg))
        <div class="alert alert-{{ $msg }} alert-dismissable session-msg">
            <button type="butoon" class="close" data-dismiss="alert">&times;</button>
            {{ Session::get($msg) }}
        </div>
    @endif
@endforeach