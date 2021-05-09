@extends('backend.layouts.main')
@section('title','Danh sách Danh mục')
@section('content')
    <h1>Danh sách Danh mục</h1>
    <div style="padding: 10px;">
        <form name="search_product" method="get" action="{{ htmlspecialchars($_SERVER['REQUEST_URI']) }}" class="form-inline">
            <input name="name" value="{{ $keyword }}" class="form-control" style="width: 350px; margin-right: 20px" placeholder="Nhập tên danh mục bạn muốn tìm kiếm ..." autocomplete="off">

            <select name="sort" class="form-control" style="width: 200px; margin-right: 20px">
                <option value="">Sắp xếp</option>
                <option value="name_asc" {{ $sort == 'name_asc' ? 'selected' : '' }}>Tên danh mục tăng dần</option>
                <option value="name_desc" {{ $sort == 'name_desc' ? 'selected' : '' }}>Tên danh mục giảm dần</option>
            </select>
            <div style="padding: 10px 0">
                <input type="submit" name="search" class="btn btn-success" value="Lọc kết quả">
            </div>
            <div>
                <a href="{{ url('/backend/category/index') }}" id="clear-search" name="clear-search" class="btn btn-warning" style="margin-left: 20px">Bỏ tìm kiếm</a>
            </div>
            <input type="hidden" value="1" name="page">
        </form>

    <a href="{{ url('/backend/category/create') }}" class="btn btn-primary">Thêm mới</a>
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>ID</th>
            <th>Tên danh mục</th>
            <th>Ảnh danh mục</th>
            <th>Slug danh mục</th>
            <th>Mô tả</th>
            <th>Thao tác</th>
        </tr>
        </thead>

        <tbody>
        @if(isset($category) && !empty($category))
            @foreach($category as $danhmuc)
                <tr>
                    <td>{{ $danhmuc -> id }}</td>
                    <td>{{ $danhmuc -> name }}</td>
                    <td>
                        @if($danhmuc->image)
                            @php $danhmuc->image = str_replace("public/","",$danhmuc->image); @endphp
                            <div>
                                <img src="{{ asset("/storage/$danhmuc->image") }}" style="width: 200px;">
                            </div>
                        @endif
                    </td>
                    <td>{{ $danhmuc -> slug }}</td>
                    <td>{!! $danhmuc -> desc !!}</td>
                    <td>
                        <a href='{{url("/backend/category/edit/$danhmuc->id")}}' class="btn btn-warning">Sửa</a>
                        <a onclick="return confirm('Bạn chắc chắn muốn xóa không?')" href='{{url("/backend/category/delete/$danhmuc->id")}}' class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
            @endforeach
        @else
            Chưa có bản ghi nào
        @endif
        </tbody>
    </table>
@endsection
