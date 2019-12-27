<?php

namespace VnCoder\Admin\Controllers;
use VnCoder\Core\Controllers\VnController;

class AdminController extends VnController
{
    protected $bladeNamespace = 'admin';
    protected $id = 0;
    protected $uid = 0;
    protected $isSubmit = false;
    protected $linkCreate = "", $linkEdit = "", $linkDelete = "", $linkExport = "";

    public function __construct()
    {
        parent::__construct();
        $this->setData['vn_debugbar'] = $this->debugbar ? 'ON' : 'OFF';
        $this->setData['user_info'] = auth()->user();
        $this->setData['_query'] = getParam('_query', '');
        $this->id = getParamInt('id', 0);
        $this->isSubmit = request()->isMethod('post') ? true : false;
    }

    protected function siteInit()
    {
        $this->metaData->description = "";
        // Auto load menu
        $this->setData['backendMenu'] = $this->getBackendMenu();
    }

    protected function loadEditorModule(){
        $this->linkCSS('plugins/fancybox/css/fancybox.css');
        $this->linkJS('plugins/fancybox/js/fancybox.js');
        $this->linkJS('plugins/maxlength/bootstrap-maxlength.min.js');
        $this->linkCSS('plugins/select2/select2.min.css');
        $this->linkJS('plugins/select2/select2.min.js');
        $this->linkJS('plugins/tinymce/tinymce.min.js');
        $this->linkJS('plugins/tinymce/tinymce.init.js');
    }

    protected function loadDataTables(){
        $this->linkCSS('plugins/datatables/dataTables.bootstrap4.css');
        $this->linkJS('plugins/datatables/jquery.dataTables.min.js');
        $this->linkJS('plugins/datatables/dataTables.bootstrap4.min.js');
    }

    protected function render($bladePath)
    {
        $this->setData['linkCreate'] = $this->linkCreate;
        $this->setData['linkDelete'] = $this->linkDelete;
        $this->setData['linkEdit'] = $this->linkEdit;
        $this->setData['linkExport'] = $this->linkExport;
        return parent::render($bladePath);
    }

    protected function getBackendMenu()
    {
        $menu = [];
        if(file_exists(APP_PATH.'Backend/menu.php')){
            $menu = include APP_PATH.'Backend/menu.php';
        }

        $menu['user'] = ['name' => 'Quản trị viên' , 'icon' => 'fa-user' , 'link' =>  '' , 'subMenu' => [
            ['name' => 'Nguời dùng', 'link' => backend('users')],
            ['name' => 'Phân quyền', 'link' => backend('users/role')],
            ['name' => 'Xem Logs', 'link' => backend('logs')]
        ]];

        $menu['tools'] = ['name' => 'Công cụ' , 'icon' => 'fa-shield-alt' , 'link' =>  '' , 'subMenu' => [
            ['name' => 'Dịch nội dung', 'link' => backend('translate')],
            ['name' => 'Tìm từ khóa', 'link' => backend('keyword')],
        ]];

        $menu['shop'] = ['name' => 'Mua Sắm' , 'icon' => 'fa-shopping-bag' , 'link' =>  '' , 'subMenu' => [
            ['name' => 'Shopee', 'link' => backend('shop/shopee')],
            ['name' => 'Shopee Mall', 'link' => backend('shop/shopee2')],
        ]];

        return $menu;
    }
}
