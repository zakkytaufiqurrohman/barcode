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

<!-- modal add -->
<div class="modal fade" role="dialog" id="modal-add-user">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="javascript:void(0)" id="form-add-user">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add-nama_user">Nama</label>
                        <input type="text" name="nama_user" class="form-control" id="add-nama_user" placeholder="Nama">
                    </div>
                    <div class="form-group">
                        <label for="add-email_user">Email</label>
                        <input type="email" name="email_user" class="form-control" id="add-email_user" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="add-username_user">Username</label>
                        <input type="text" name="username_user" class="form-control" id="add-username_user" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="add-password_user">Password</label>
                        <input type="password" name="password_user" class="form-control" id="add-password_user" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="add-password_user1">Konfirmasi Password</label>
                        <input type="password" name="password_user1" class="form-control" id="add-password_user1" placeholder="Konfirmasi Password">
                    </div>
                    <div class="form-group">
                        <label for="add-level_user">Level User</label>
                        <select class="form-control" name="level_user" id="add-level_user" aria-label="Default select example">
                            <option selected>-- Pilih Level User --</option>
                            <option value="Superadmin">SuperAdmin</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                          </select>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal add -->

<!-- modal edit -->
<div class="modal fade" role="dialog" id="modal-update-user">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="javascript:void(0)" id="form-update-user">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="update-nama_user">Nama</label>
                        <input type="text" name="nama_user" class="form-control" id="update-nama_user" placeholder="Nama">
                    </div>
                    <div class="form-group">
                        <label for="update-email_user">Email</label>
                        <input type="email" name="email_user" class="form-control" id="update-email_user" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="update-username_user">Username</label>
                        <input type="text" name="username_user" class="form-control" id="update-username_user" placeholder="Username">
                    </div>
                    {{-- <div class="form-group">
                        <label for="update-password_user">Password</label>
                        <input type="password" name="password_user" class="form-control" id="update-password_user" placeholder="Password">
                    </div> --}}
                    {{-- <div class="form-group">
                        <label for="update-level_user">Level User</label>
                        <select class="form-control" name="level_user" id="update-level_user" aria-label="Default select example">
                            <option selected>-- Pilih Level User --</option>
                            <option value="Superadmin">SuperAdmin</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                          </select>
                    </div> --}}
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-update-agenda">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal edit -->
@endsection
@section('js')

@endsection