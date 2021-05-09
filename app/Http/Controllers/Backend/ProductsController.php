<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Model\Backend\ProductsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        //lấy ra tất cả
        $products = ProductsModel::all();
        //Phân trang - 1 bảng giơi hạn 10
//        $products = DB::table('products')->paginate(10);
        //Tìm kiếm
        $sort = $request->query('product_sort','');
        $keyword = $request ->query('product_name','');
        $productStatus =(int) $request ->query('product_status','');
        $allproductStatus =[1,2];

        //Tìm kiếm theo từ khóa và phân trang 10
        $queryORM = ProductsModel::where('product_name','LIKE','%'.$keyword.'%');
        if(in_array($productStatus,$allproductStatus)){
            $queryORM = $queryORM->where('product_status',$productStatus);
        }
        if($sort=='price_asc'){
            $queryORM-> orderBy('product_price','asc');
        }
        if($sort=='price_desc'){
            $queryORM-> orderBy('product_price','desc');
        }
        if($sort=='quantity_asc'){
            $queryORM-> orderBy('product_quantity','asc');
        }
        if($sort=='quantity_desc'){
            $queryORM-> orderBy('product_quantity','desc');
        }

        $products = $queryORM->paginate(10);
        //Truyền sữ liệu xuống view
        $data = [];
        $data['products'] = $products;


        //Truyền keyword xuống cho view
        $data['keyword'] = $keyword;
        $data['product_status'] = $productStatus;
        $data['sort'] = $sort;
        return view('backend.products.index',$data);
    }

    public function create()
    {
        return view('backend.products.create');
    }
    public function store(Request $request)
    {
        //Validate dữ liệu nhập vào
        $validateData = $request -> validate([
            'product_name' => 'required',
//            'product_desc' => 'required',
            'product_quantity' => 'required',
            'product_image' => 'required',
            'product_publish' => 'required',
            'product_price' => 'required',
        ]);
        $product_name = $request ->input('product_name');
        $product_status = $request ->input('product_status');
        $product_desc = $request ->input('product_desc');
        $product_publish = $request ->input('product_publish');
        $product_quantity = $request ->input('product_quantity');
        $product_price = $request ->input('product_price');
        $pathProductImage = $request -> file('product_image')->store('/public/product/image');
        var_dump($pathProductImage);
        $product = new ProductsModel();
        // khi $product_publish không được nhập dữ liệu
        // ta sẽ gán giá trị là thời gian hiện tại theo định dạng Y-m-d H:i:s
        if(!$product_publish){
            $product_publish = date('Y-m-d H:i:s');
        }

        // gán dữ liệu từ request cho các thuộc tính của biến $product
        // $product là đối tượng khởi tạo từ model ProductsModel
        $product -> product_name = $product_name;
        $product -> product_status = $product_status;
        $product -> product_desc = $product_desc;
        $product -> product_publish = $product_publish;
        $product -> product_quantity = $product_quantity;
        $product -> product_price = $product_price;
        $product -> product_image = $pathProductImage;
        //Lưu sản phẩm
        $product->save();
        //Chuyern hướng về index
        return redirect('/backend/product/index')->with('status','Thêm mới sản phẩm thành công');
    }

    public function edit($id)
    {
        $product = ProductsModel::findOrFail($id);
        //Truyền biến xuống edit
        $data = [];
        $data['product']=$product;
        return view('backend.products.edit',$data);
    }
    public function update(Request $request, $id)
    {
        //Validate form
        $validateData = $request -> validate([
           'product_name' => 'required',
           'product_desc' => 'required',
           'product_publish' => 'required',
           'product_price' => 'required',
           'product_quantity' => 'required',
        ]);
        //Lấy giá trị từ form
        $product_name = $request -> input('product_name');
        $product_status = $request -> input('product_status');
        $product_desc= $request -> input('product_desc');
        $product_price = $request -> input('product_price');
        $product_quantity = $request -> input('product_quantity');
        $product_publish = $request -> input('product_publish');
        if(!$product_publish){
            $product_publish = date('Y/m/m H:i:s');
        }
        //Lấy data qua id
        $product = ProductsModel::findOrFail($id);
        //Gán giá trị
        $product -> product_name = $product_name;
        $product -> product_status = $product_status;
        $product -> product_desc = $product_desc;
        $product -> product_price = $product_price;
        $product -> product_quantity = $product_quantity;
        $product -> product_publish = $product_publish;
        //Upload ảnh ở edit
        if ($request->hasFile('product_image')){
            // nếu có ảnh mới upload lên và
            // trong biến $product->product_image có dữ liệu
            // có nghĩa là trước đó đã có ảnh trong db
            if ($product->product_image) {
                Storage::delete($product->product_image);
            }
            $pathProductImage = $request ->file('product_image')->store('/public/product/image');
            $product->product_image = $pathProductImage;
        }
       //Lưu sản phẩm
        $product->save();
        return redirect("/backend/product/edit/$id")-> with('status','Cập nhật sản phẩm thành công');
    }

    public function delete($id)
    {
        //Lấy đối tượng dựa vào id
        $product = ProductsModel::findOrFail($id);
        $product->delete();
        return redirect('/backend/product/index')->with('status','Xóa sản phẩm thành công');
    }

}
