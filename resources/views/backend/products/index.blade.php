@extends('backend.layouts.main')
@section('title','Danh sách sản phẩm')
@section('content')
    <h1>Danh sách sản phẩm</h1>

    <div style="padding: 10px;">
        <form name="search_product" method="get" action="{{ htmlspecialchars($_SERVER['REQUEST_URI']) }}" class="form-inline">
            <input name="product_name" value="{{ $keyword }}" class="form-control" style="width: 350px; margin-right: 20px" placeholder="Nhập tên sản phẩm bạn muốn tìm kiếm ..." autocomplete="off">
            <select name="product_status" class="form-control" style="width: 200px; margin-right: 20px">
                <option value="0">Lọc theo trạng thái</option>
                <option value="1" {{ $product_status == 1 ? 'selected' : '' }}>Đang mở bán</option>
                <option value="2" {{ $product_status == 2 ? 'selected' : '' }}>Ngừng bán</option>
            </select>
            <select name="product_sort" class="form-control" style="width: 150px; margin-right: 20px">
                <option value="">Sắp xếp</option>
                <option value="price_asc" {{ $sort=='price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                <option value="price_desc" {{ $sort=='price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                <option value="quantity_asc" {{ $sort=='quantity_asc' ? 'selected' : '' }}>Tồn kho tăng dần</option>
                <option value="quantity_desc" {{ $sort=='quantity_desc' ? 'selected' : '' }}>Tồn kho giảm dần</option>
            </select>
            <div style="padding: 10px 0">
                <input type="submit" name="search" class="btn btn-success" value="Lọc kết quả">
            </div>
            <div>
                <a href="{{ url('/backend/product/index') }}" id="clear-search" name="clear-search" class="btn btn-warning" style="margin-left: 20px">Bỏ tìm kiếm</a>
            </div>
            <input type="hidden" value="1" name="page">
        </form>
    </div>
    {{ $products->links() }}

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <a href="{{ url('/backend/product/create') }}" class="btn btn-primary">Thêm mới</a>

    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Ảnh sản phẩm</th>
            <th>Mô tả</th>
            <th>Ngày tháng</th>
            <th>Giá sản phẩm</th>
            <th>Số lượng tồn kho</th>
            <th>Thao tác</th>
        </tr>
        </thead>

        <tbody>
        @if(isset($products) && !empty($products))
            @foreach($products as $product)
                <tr>
                    <td>{{ $product -> id }}</td>
                    <td>
                        {{ $product -> product_name }}
                        @if($product -> product_status==1)
                            <p><span class="bg-success text-white">Đang bán</span></p>
                        @endif
                        @if($product -> product_status==2)
                            <p><span class="bg-success text-white">Ngừng bán</span></p>
                        @endif
                    </td>
                    <td>
                        @if($product->product_image)
                            @php $product->product_image = str_replace("public/","",$product->product_image); @endphp
                            <div>
                                <img src="{{ asset("/storage/$product->product_image") }}" style="width: 200px;">
                            </div>
                        @endif
                    </td>
                    <td>{!! $product -> product_desc !!}</td>
                    <td>{{ $product -> product_publish }}</td>
                    <td>{{ $product -> product_price }}</td>
                    <td>{{ $product -> product_quantity }}</td>
                    <td>
                        <a href='{{url("/backend/product/edit/$product->id")}}' class="btn btn-warning">Sửa</a>
                        <a onclick="return confirm('Bạn chắc chắn muốn xóa không?')" href='{{url("/backend/product/delete/$product->id")}}' class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
            @endforeach
        @else
            Chưa có bản ghi nào
        @endif
        </tbody>
    </table>
    {{ $products->links() }}
@endsection
@section('appendjs')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#clear-search').on('Click',function (e) {
                e.preventDefault();
                $("input[name='product_name]").val('');
                $("form[name='search_product']").trigger('submit');
            });
        });
    </script>
@endsection
