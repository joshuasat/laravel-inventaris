@section('js')

<script type="text/javascript">

$(document).ready(function() {
    $(".users").select2();
});

</script>


@stop

@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('penerbits.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
<div class="row">
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Tambah Ruangan baru</h4>
                      
                        <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                            <label for="id" class="col-md-4 control-label">id</label>
                            <div class="col-md-6">
                                <input id="id" type="text" class="form-control" name="id" value="{{ old('id') }}" required>
                                @if ($errors->has('id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('penerbit') ? ' has-error' : '' }}">
                            <label for="penerbit" class="col-md-4 control-label">Ruangan</label>
                            <div class="col-md-6">
                                <input id="penerbit" type="text" class="form-control" name="penerbit" value="{{ old('penerbit') }}" required>
                                @if ($errors->has('penerbit'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('penerbit') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" id="submit">
                                    Submit
                        </button>
                        <button type="reset" class="btn btn-danger">
                                    Reset
                        </button>
                        <a href="{{route('penerbits.index')}}" class="btn btn-light pull-right">Back</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

</div>
</form>
@endsection