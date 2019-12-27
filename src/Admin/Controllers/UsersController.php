<?php

namespace VnCoder\Admin\Controllers;

use VnCoder\Core\Models\VnUsers;
use VnCoder\Core\Models\VnRoles;
use Illuminate\Support\Facades\File;

class UsersController extends AdminController
{
    public function Index_Action()
    {
        $this->metaData->title = "Người dùng";
        $this->metaData->description = "hoạt động trên hệ thống";
        $this->linkCreate = backend('users.add');
        $this->linkEdit = backend('users.edit');
        // Custom link
        $this->setData['linkLock'] = backend('users.lock');
        $this->setData['linkUnlock'] = backend('users.unlock');

        $this->setData['data'] = VnUsers::getData();
        return $this->views('users.user');
    }

    public function Add_Action()
    {
    }

    public function Edit_Action()
    {
    }

    public function Lock_Action()
    {
        VnUsers::deactive($this->id);
        return redirect(backend('users'));
    }

    public function Unlock_Action()
    {
        VnUsers::active($this->id);
        return redirect(backend('users'));
    }

    // Role Action
    public function Role_Action()
    {
        $this->metaData->title = "Danh sách quyền người dùng";
        $this->setData['data'] = VnRoles::getRoles();
        $this->setData['link_add'] = backend('users.role_add');
        $this->setData['link_edit'] = backend('users.role_edit');
        $this->setData['link_delete'] = backend('users.role_delete');
        $this->setData['link_permission'] = backend('users.role_permission');
        return $this->views('users.role');
    }

    public function Role_Add_Action()
    {
        return $this->views('users.role-create');
    }

    public function Role_Edit_Action()
    {
        $id = getParamInt('id', 0);
        if ($id == 1) {
            flash_message('Quyền Root không được sửa đổi');
            return redirect(backend('users.role'));
        }

        if ($this->isSubmit) {
            $name = getParam('name');
            $description = getParam('description');
            VnRoles::editRole($id, array('name' => $name , 'description' => $description));
            flash_message('Đã cập nhật role: '.$name);
            return redirect(backend('users.role'));
        }

        $roleInfo = VnRoles::getInfo($this->id);
        if (!$roleInfo) {
            return redirect(backend('users/role'));
        }

        $this->metaData->title = "Chỉnh sửa quyền quản trị: ".$roleInfo->name;
        $this->setData['data'] = $roleInfo;

        return $this->views('users.role-edit');
    }

    public function Role_Permission_Action()
    {
        $id = getParamInt('id', 0);
        if ($id == 1) {
            flash_message('Quyền Root có toàn quyền quản trị!');
            return redirect(backend('users.role'));
        }

        $roleInfo = VnRoles::getInfo($id);
        if(!$roleInfo){
            flash_message('Không tìm thấy quyền quản trị với id : '.$id);
            return redirect(backend('users.role'));
        }

        $this->metaData->title = "Tùy chỉnh quyền quản trị: ".$roleInfo->name;
        $this->setData['roleInfo'] = $roleInfo;

        $this->setData['roleData'] = $this->getRoleInController();

        return $this->views('users.role-permission');
    }

    protected function getRoleInController(){
        $data = [];
        // Load controller from: ADMIN_PATH.'Controllers' and BACKEND_PATH.'Controllers'

        foreach (File::files(BACKEND_PATH.'Controllers') as $item){
            $controller = $this->getControllerRoute($item->getFilename());
            $data['backend'][$controller] = $this->getPublicMethodFromController($item->getPathname());
        }

        foreach (File::files(ADMIN_PATH.'Controllers') as $item){
            $filename = $item->getFilename();
            if(!in_array($filename, ['AdminController.php','CrudController.php'])){
                $controller = $this->getControllerRoute($filename);
                $data['admin'][$controller] = $this->getPublicMethodFromController($item->getPathname());
            }
        }

        return $data;
    }

    protected function getPublicMethodFromController($controller){
        $controllerInfo = file_get_contents($controller);
        preg_match_all('/public function(.*?)_Action\(\)/', $controllerInfo, $matches);
        return $matches ? $matches[1] : [];
    }

    protected function getControllerRoute($controllerFile){
        return str_replace('Controller.php','', $controllerFile);
    }

}
