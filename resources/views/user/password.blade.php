@extends('layouts.master')

@section('title','User')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">User</li>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
                <div class="card-header">
                </div>
            </div>                
            <form method="POST" action="{{ route('user.update-password') }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="update-password_user">Password Lama</label>
                        <input type="password" name="oldpass" class="form-control @error('oldpass') is-invalid @enderror" id="update-oldpass" placeholder="Password">
                        @if($errors->any())
                        <span style="color:red" class="help-block">
                            <strong>{{$errors->first()}}</strong>
                        </span>
                        @endif
                    </div><br>
                    <div class="form-group">
                        <label for="add-password_user">Password Baru</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="add-password" placeholder="Password">
                         @error('password')
                            <span style="color:red" class="help-block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="add-password_user1">Ulangi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="add-password_confirmation" placeholder="Ulangi Password Baru">
                         @error('password_confirmation')
                            <span style="color:red" class="help-block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
          </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

@endsection
@section('js')

@endsection