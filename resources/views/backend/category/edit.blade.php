@extends('backend.layouts.main')
@section('title','Sửa Danh mục')
@section('content')
    <h1>Sửa Danh mục</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <form name="category" action="{{ url("/backend/category/update/$category->id") }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Tên danh mục:</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $category->name }}">
        </div>
        <div class="form-group">
            <label for="slug">Slug danh mục:</label>
            <input type="text" name="slug" class="form-control" id="slug" value="{{ $category->slug }}">
        </div>
        <div class="form-group">
            <label for="image">Ảnh danh mục:</label>
            <input type="file" name="image" id="image" value="{{ $category->image }}">
            @if($category->image)
                @php $category->image = str_replace("public/","",$category->image); @endphp
                <div>
                    <img src="{{ asset("/storage/$category->image") }}" style="width: 200px;">
                </div>
            @endif
        </div>
        <div class="form-group">
            <label for="desc">Mô tả danh mục:</label>
            <textarea name="desc" id="desc" class="form-control" rows="10">{{ $category->desc }}</textarea>
        </div>
        <button type="submit" class="btn btn-info">Thêm danh mục</button>
    </form>
@endsection
@section('appendjs')
    <script src="{{ asset('/be-assets/js/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript">
        tinymce.init({selector:'#desc'});
    </script>
@endsection
