<?php

namespace VnCoder\Admin\Controllers;

class PostsController extends CrudController
{
    protected $model = 'VnCoder\Core\Models\VnPosts';

    protected $indexTitle = "Danh sách bài viết";
    protected $addTitle = "Thêm bài viết mới";
    protected $editTitle = "Chỉnh sửa bài viết ";
}