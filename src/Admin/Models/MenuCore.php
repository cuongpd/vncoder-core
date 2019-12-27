<?php

namespace Core\Modules\Backend\Models;

class MenuCore
{
    public static function getMenuData()
    {
        $menu = [];
        $menu[96] = [
            'name' => 'Bài viết',
            'data' => [
                ['name' => 'Bài viết' , 'link' => route('backend.post'), 'icon' => 'fa-newspaper-o'],
                ['name' => 'Danh mục' , 'link' => route('backend.post.category'), 'icon' => 'fa-database'],
            ],
            'icon' => 'fa-database',
            'active' => ['post']
        ];
        $menu[97] = [
            'name' => 'Cấu hình',
            'data' => [
                ['name' => 'Cấu hình chung' , 'link' => route('backend.config'), 'icon' => 'fa-cogs'],
                ['name' => 'Config Website' , 'link' => route('backend.config.website'), 'icon' => 'fa-codepen'],
                ['name' => 'Menu' , 'link' => route('backend.menu'), 'icon' => 'fa-language'],
                ['name' => 'Module HTML' , 'link' => route('backend.module'), 'icon' => 'fa-odnoklassniki-square'],
                ['name' => 'Trang Tĩnh' , 'link' => route('backend.page'), 'icon' => 'fa-html5'],
            ],
            'icon' => 'fa-database',
            'active' => ['config','menu','slider','module','page']
        ];
        $menu[98] = [
            'name' => 'Quản trị viên',
            'data' => [
                ['name' => 'Người dùng' , 'link' => route('backend.user'), 'icon' => 'fa-user-o'],
                ['name' => 'Phân quyền' , 'link' => route('backend.role'), 'icon' => 'fa-feed'],
            ],
            'icon' => 'fa-address-card',
            'active' => ['user','role']
        ];
        $menu[99] = [
            'name' => 'Hệ Thống',
            'data' => [
                ['name' => 'Debug Logs' , 'link' => route('backend.logs'), 'icon' => 'fa-history'],
                ['name' => 'PHP Info' , 'link' => route('backend.info'), 'icon' => 'fa-info'],
                ['name' => 'Backup' , 'link' => route('backend.backup'), 'icon' => 'fa-database'],
            ],
            'icon' => 'fa-shield',
            'active' => ['logs','info','backup']
        ];

        return $menu;
    }
}
