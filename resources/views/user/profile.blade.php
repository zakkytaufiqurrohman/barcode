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
            <form method="POST" action="{{ route('user') }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" value="{{ old('id_user', $user->id_user) }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add-nama_user">Nama</label>
                        <input type="text" name="nama_user" class="form-control @error('nama_user') is-invalid @enderror" value="{{ old('nama_user', $user->nama_user) }}" placeholder="Nama">
                        @error('nama_user')
                            <span style="color:red" class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="add-email_user">Email</label>
                        <input type="email" name="email_user" class="form-control @error('email_user') is-invalid @enderror" value="{{ old('email_user', $user->email_user) }}" placeholder="Email">
                        @error('email_user')
                            <span style="color:red" class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="add-username_user">Username</label>
                        <input type="text" name="username_user" class="form-control @error('username_user') is-invalid @enderror" value="{{ old('username_user', $user->username_user) }}" placeholder="Username">
                        @error('username_user')
                            <span style="color:red" class="invalid-feedback" role="alert">
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