<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminLogin;
use App\Models\Backend\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request -> query('admins_sort','');
        $keyword= $request -> query('admins_name','');
        $queryORM = AdminModel::where('name','LIKE','%'.$keyword.'%');
        if ($sort == 'name_asc')
        {
            $queryORM -> orderBy('name','asc');
        }
        if ($sort == 'name_desc')
        {
            $queryORM -> orderBy('name','desc');
        }
        $admins = $queryORM ->paginate(10);
        $data = [];
        $data['admins'] = $admins;
        $data['sort'] = $sort;
        $data['keyword'] = $keyword;
        return view('backend.admins.index',$data);
    }
    public function create()
    {
        return view('backend.admins.create');
    }
    public function store(Request $request)
    {
        //Validate
        $validate = $request ->validate([
            'name' => 'required',
            'email' => 'required|unique:admins',
//            'avatar' => 'required',
            'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:6',
        ]);
        $name = $request ->input('name','');
        $email = $request ->input('email','');
        $password = $request ->input('password','');
//        $avatar = $request ->file('avatar')->store('public/Adimimage');

        $admin = new AdminModel();

        $admin -> name = $name;
        $admin -> email = $email;
        $admin -> password = $password;
//        $admin -> avatar = $avatar;
        $admin ->save();
        return redirect('backend/admin/index')->with('status','Bạn đã tạo tài khoản thành công');
    }
    public function edit($id)
    {
        $admin = AdminModel::findOrfail($id);
        $data = [];
        $data['admin'] = $admin;
        return view('backend.admins.edit',$data);
    }
    public function update(Request $request, $id)
    {
        $name = $request -> input('name','');
        $email = $request -> input('email','');
        $password = $request -> input('password','');
        if (strlen($password) > 0) {
            // validate dữ liệu
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|unique:admins',
                'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'required|min:6',
            ]);
        } else {
            // validate dữ liệu
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|unique:admins',
            ]);
        }
        $admin = AdminModel::findOrfail($id);
        $admin -> name = $name;
        $admin -> email = $email;
        if (strlen($password) > 0) {
            $admin->password = Hash::make($password);
        }
        $admin -> save();
        return redirect('backend/admin/index')->with('status','Cập nhật tài khoản thành công');
    }
    public function delete($id)
    {
        $admin = AdminModel::findOrfail($id);
        $admin->delete();
        return redirect('backend/admin/index')->with('status','Xóa tài khoản thành công');
    }
}
