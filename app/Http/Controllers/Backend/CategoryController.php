<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Model\Backend\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->query('sort','');
        $keyword = $request->query('name','');

        $queryORM = CategoryModel::where('name','LIKE','%'.$keyword.'%');
        if($sort == 'name_asc'){
            $queryORM->orderBy('name','asc');
        }
        if($sort == 'name_desc'){
            $queryORM->orderBy('name','desc');
        }
        $category = $queryORM ->paginate(10);

        //Truyền dữ liệu xuống view
        $data = [];
        $data['category'] = $category;
        $data['keyword'] = $keyword;
        $data['sort'] = $sort;
        return view('backend.category.index',$data);
    }
    public function create()
    {
        return view('backend.category.create');
    }public function store(Request $request)
    {
        //Validate Form
        $validateData = $request ->validate([
           'name' => 'required',
           'slug' => 'required',
           'desc' => 'required',
        ]);
        //lấy giá trị từ form
        $name = $request -> input('name','');
        $slug = $request -> input('slug','');
        $image = $request -> file('image')->store('/public/categoryimages');
        $desc = $request -> input('desc','');
        //Khởi tạo model
        $category = new CategoryModel();
        //Gán giá trị từ form vào CSDl
        $category->name = $name;
        $category->slug = $slug;
        $category->image = $image;
        $category->desc = $desc;
        $category->save();
        return redirect('/backend/category/index')->with('status','Thêm mới danh mục thành công');
    }
    public function edit(Request $request,$id)
    {
        $category = CategoryModel::findOrFail($id);
        //Truyền biến xuống view
        $data = [];
        $data['category'] = $category;
        return view('backend.category.edit',$data);
    }
    public function update(Request $request,$id)
    {
        //Validate Form
        $validateData = $request -> validate([
           'name' => 'required',
           'slug' => 'required',
           'desc' => 'required',
        ]);
        //Lấy giá trị từ form
        $name = $request ->input('name','');
        $slug = $request ->input('slug','');
        $desc = $request ->input('desc','');

        $category = CategoryModel::findOrFail($id);
        //Gán giá trị vào CSDl
        $category -> name = $name;
        $category -> slug = $slug;
        if ($request->hasFile('image')){
            if ($category -> image){
                Storage::delete($category -> image);
            }
            $image = $request ->file('image')->store('/public/categoryimages');
            $category -> image = $image;
        }
        $category -> desc = $desc;

        $category->save();
        return redirect("backend/category/edit/$id")->with('status','Sửa danh mục thành công');
    }
    public function delete($id)
    {
        $category = CategoryModel::findOrFail($id);
        $category->delete();
        return redirect('backend/category/index')->with('status','Xóa danh mục thành công');
    }
}
