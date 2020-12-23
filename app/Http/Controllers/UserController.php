<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->validate($request,[
            'nama_user' => 'required|min:3|max:255',
            'email_user' => 'required|unique:tbl_user,email_user',
            'username_user' => 'required|min:3|unique:tbl_user,username_user',
            'password_user' => 'required|min:3',
            'password_user1' => 'required_with:password_user|same:password_user|required|min:3',
            'level_user' =>'required|in:Superadmin,Admin,User',
       ],[
           'nama_user.required'=>'Nama Tidak Boleh Kosong',
           'email_user.required'=>'Email Tidak Boleh Kosong',
           'username_user.required'=>'Username Tidak Boleh Kosong',
           'password_user.required'=>'Password Tidak Boleh Kosong',
           'password_user1.required'=>'Password Tidak Boleh Kosong',
           'level_user.required'=>'Level Tidak Boleh Kosong',
           'nama_user.min'=>'Nama minimal 3 character',
           'username_user.min'=>'Username minimal 3 character',
           'password_user.min'=>'Password minimal 3 character',
           'password_user1.min'=>'Password minimal 3 character',
           'password_user1.same'=>'Konfirmasi password harus sama dengan password',
           'username_user.unique'=>'Username Sudah Ada',
           'email_user.unique'=>'Email Sudah Ada',
           ]);
        DB::beginTransaction();
        try{
            $user = User::create([
                'nama_user' => $request->nama_user,
                'email_user' => $request->email_user,
                'username_user' => $request->username_user,
                'password_user' => Hash::make($request->password_user),
                'level_user' => $request->level_user,
                // 'tanggal_user' => \Carbon\Carbon::parse(date())->format('Y-m-d'),
                'tanggal_user' => date('Y-m-d'),
                'waktu_user' => date('H:i:s'),
                'reset' => ' ',
            ]);
            DB::commit();
            if($user->id_user < 0 || empty($user->id_user)){
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'Gagal simpan ke tabel berkas']);
            }
            return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan User']);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function show(Request $request)
    {
        $user = User::find($request->id);
        $datas = $user;
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Waarmeking tidak ditemukan', 'data' => '']);
        }

        return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil data daftar Waarmeking', 'data' => $datas]);
    }

    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->validate($request,[
            'nama_user' => 'required|min:3|max:255',
            'email_user' => 'required|email|unique:tbl_user,email_user,'.$request->id.',id_user',
            'username_user' => 'required|min:3|unique:tbl_user,username_user,'.$request->id.',id_user',
        ],[
           'nama_user.required'=>'Nama Tidak Boleh Kosong',
           'email_user.required'=>'Email Tidak Boleh Kosong',
           'username_user.required'=>'Username Tidak Boleh Kosong',
           'nama_user.min'=>'Nama minimal 3 character',
           'username_user.min'=>'Username minimal 3 character',
           'username_user.unique'=>'Username Sudah Ada',
           'email_user.unique'=>'Email Sudah Ada',
        ]);
        DB::beginTransaction();
        try{
            
            $data = User::find($request->id);
            $data->update([
                'nama_user' => $request->nama_user,
                'email_user' => $request->email_user,
                'username_user' => $request->username_user,
            ]);
            DB::commit();

            $id_user = $data->id_user;
            if($id_user == null || empty($id_user)){
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => "gagal mendapatkan id"]);
            }
                return response()->json(['status' => 'success', 'message' => 'Berhasil mengubah User']);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::find($request->id);
            if (!$user) {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan.']);
            }
            $user->delete();

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus User']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function data(Request $request)
    {
        $data = User::query();
        return DataTables::eloquent($data)
            ->addColumn('action', function ($data) {
               
                $action = '';
                $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-primary' data-id='{$data->id_user}' onclick='showUser(this);'><i class='fa fa-edit'></i></a>&nbsp;";
                $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-danger'  data-id='{$data->id_user}' onclick='deleteUser(this);'><i class='fa fa-trash'></i></a>&nbsp;";

                return $action;
            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }
    protected function validator(array $data, $type = 'insert', $id = 0)
    {
        $rulesemail_user = '';
        $rulesusername_user = '';
        $rulesPassword = '';
        $level_user = '';
        if ($type == 'insert') {
            $rulesemail_user = 'unique:tbl_user,email_user';
            $rulesusername_user = 'unique:tbl_user,username_user';
            $rulesPassword = ['required', 'string', 'min:8', 'max:191'];
            $level_user = 'required|in:Superadmin,Admin,User'; 
        } else if ($type == 'update') {
            $rulesemail_user = 'unique:tbl_user,email_user,' . $id.',id_user';
            $rulesusername_user = 'unique:tbl_user,username_user,' . $id.',id_user';
            // $rulesUsername = 'unique:users,username,' . $id;
            $rulesPassword = [];
        }

        $rules = [
            'nama_user' => 'required|min:3|max:255' ,
            'email_user' => ['required', $rulesemail_user ] ,
            'username_user' => ['required','min:3', $rulesusername_user] ,
            'password_user' => $rulesPassword ,
            'password_user1' => 'required_with:password_user|same:password_user',
            'level_user' =>  $level_user ,
        ];

        $messages = [
            'required' => ':attribute tidak boleh kosong',
            'string' => ':attribute harus berupa string',
            'min' => ':attribute minimal :min karakter',
            'max' => ':attribute maksimal :max karakter',
            'unique' => ':attribute yang Anda masukkan sudah terdaftar',
        ];

        return Validator::make($data, $rules, $messages);
    }
}
