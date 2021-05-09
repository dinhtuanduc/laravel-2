@extends('backend.layouts.main')
@section('title','Danh sách sản phẩm')
@section('content')
    <h1>Danh sách đơn hàng</h1>

    <div style="padding: 10px;">
        <form name="search_product" method="get" action="{{ htmlspecialchars($_SERVER['REQUEST_URI']) }}" class="form-inline">
            <input name="product_name" value="{{ $keyword }}" class="form-control" style="width: 350px; margin-right: 20px" placeholder="Nhập tên sản phẩm bạn muốn tìm kiếm ..." autocomplete="off">
            <select name="product_sort" class="form-control" style="width: 150px; margin-right: 20px">
                <option value="">Sắp xếp</option>
                <option value="customer_asc" {{ $sort == 'customer_asc' ? 'selected' : '' }}>Tên khách hàng tăng dần</option>
                <option value="customer_desc" {{ $sort == 'customer_desc' ? 'selected' : '' }}>Tên khách hàng  giảm dần</option>
            </select>
            <div style="padding: 10px 0">
                <input type="submit" name="search" class="btn btn-success" value="Lọc kết quả">
            </div>
            <div>
                <a href="{{ url('/backend/order/index') }}" id="clear-search" name="clear-search" class="btn btn-warning" style="margin-left: 20px">Bỏ tìm kiếm</a>
            </div>
            <input type="hidden" value="1" name="page">
        </form>
    </div>
{{ $orders ->links() }}
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <a href="{{ url('/backend/order/create') }}" class="btn btn-primary">Thêm mới</a>

    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>ID đơn hàng</th>
            <th>Tên khách hàng</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Trạng thái</th>
            <th>Tổng số sản phẩm</th>
            <th>Tổng tiền</th>
            <th>Thao tác</th>
        </tr>
        </thead>

        <tbody>
        @if(isset($orders) && !empty($orders))
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order -> id  }}</td>
                    <td>{{ $order -> customer_name  }}</td>
                    <td>{{ $order -> customer_email  }}</td>
                    <td>{{ $order -> customer_phone  }}</td>
                    <td>{{ $order -> customer_address  }}</td>
                    <td>{{ $order -> total_product  }}</td>
                    <td>{{ $order -> total_price  }}</td>
                    <td>
                        <a href="{{ url("backend/order/edit/$order -> id") }}" class="btn btn-warning">Sửa</a>
                        <a href="{{ url("backend/order/delete/$order -> id") }}" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
            @endforeach
        @else
            Chưa có bản ghi nào
        @endif
        </tbody>
    </table>
    {{ $orders ->links() }}
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
