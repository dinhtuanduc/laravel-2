<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\OrderModel;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request -> query('sort','');
        $keyword = $request -> query('name','');
        $queryORM = OrderModel::where('customer_name','LIKE','%'.$keyword.'%');
        if($sort == 'name_asc')
        {
            $queryORM -> orderBy('customer_name','asc');
        }
        if($sort == 'name_desc')
        {
            $queryORM -> orderBy('customer_name','desc');
        }
        $orders = $queryORM->paginate(10);
        $data = [];
        $data['orders'] = $orders;
        $data['keyword'] = $keyword;
        $data['sort'] = $sort;
        return view('backend.orders.index',$data);
    }
    public function create()
    {
        return view('backend.orders.create');
    }
    public function store()
    {

    }
    public function edit()
    {

    }
    public function update()
    {

    }
    public function delete()
    {

    }
}
