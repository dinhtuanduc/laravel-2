@extends('backend.layouts.main')
@section('title','Danh sách sản phẩm')
@section('content')
    <h1>Danh sách tài khoản</h1>

    <div style="padding: 10px;">
        <form name="search_product" method="get" action="{{ htmlspecialchars($_SERVER['REQUEST_URI']) }}" class="form-inline">
            <input name="admins_name" value="{{ $keyword }}" class="form-control" style="width: 350px; margin-right: 20px" placeholder="Nhập tên sản phẩm bạn muốn tìm kiếm ..." autocomplete="off">
            <select name="admins_sort" class="form-control" style="width: 150px; margin-right: 20px">
                <option value="">Sắp xếp</option>
                <option value="name_asc" {{ $sort=='name_asc' ? 'selected' : '' }}>Tên tăng dần</option>
                <option value="name_desc" {{ $sort=='name_desc' ? 'selected' : '' }}>Tên giảm dần</option>
            </select>
            <div style="padding: 10px 0">
                <input type="submit" name="search" class="btn btn-success" value="Lọc kết quả">
            </div>
            <div>
                <a href="{{ url('/backend/admin/index') }}" id="clear-search" name="clear-search" class="btn btn-warning" style="margin-left: 20px">Bỏ tìm kiếm</a>
            </div>
            <input type="hidden" value="1" name="page">
        </form>
    </div>


    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <a href="{{ url('/backend/admin/create') }}" class="btn btn-primary">Thêm mới</a>

    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Email</th>
            <th>Mật khẩu</th>
            <th>Thao tác</th>
        </tr>
        </thead>

        <tbody>
        @if(isset($admins) && !empty($admins))
            @foreach($admins as $admin)
                <tr>
                    <td>{{ $admin -> id }}</td>
                    <td>{{ $admin -> name }}</td>
                    <td>{{ $admin -> email }}</td>
                    <td>{{ $admin -> password }}</td>
                    <td>
                        <a href="{{ url("/backend/admin/edit/$admin->id") }}" class="btn btn-warning">Sửa tài khoản</a>
                        <a onclick="return confirm('Bạn có chắc là muốn xóa tài khoản này chứ?')" href="{{ url("/backend/admin/delete/$admin->id") }}" class="btn btn-danger">Xóa tài khoản</a>
                    </td>
                </tr>
            @endforeach
        @else
            Chưa có bản ghi nào
        @endif
        </tbody>
    </table>
{{ $admins -> links() }}
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

