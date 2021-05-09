<?php

namespace App\Model\Backend;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    //Khai báo tên bảng
    protected $table = 'category';
    //Khai báo khóa chính
    protected $primaryKey = 'id';
}
