<?php

namespace VnCoder\Admin\Controllers;

use VnCoder\Models\Roles;
use VnCoder\Models\Users;

class RolesController extends AdminController
{
    public function Index_Action()
    {
        $this->setData['data'] = Roles::getRoles();
        $this->setData['link_add'] = backend('roles.add');
        $this->setData['link_edit'] = backend('roles.edit');
        $this->setData['link_delete'] = backend('roles.delete');
        $this->setData['link_permission'] = backend('roles.permission');
        return $this->views('users.role');
    }

    public function Edit_Action()
    {
        if ($this->isSubmit) {
            $id = getParamInt('id', 0);
            $name = getParam('name');
            $description = getParam('description');
            Roles::editRole($id, array('name' => $name , 'description' => $description));
            flash_message('Đã cập nhật role: '.$name);
            return redirect(backend('users.role'));
        }


        $this->setData['data'] = Roles::getInfo($this->id);


        return $this->views('users.role-edit');
    }
}
