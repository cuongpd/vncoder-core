<?php
namespace VnCoder\Admin\Controllers;

class CrudController extends AdminController
{
    protected $model = false;
    protected $module = '' , $moduel_url = '';
    protected $id = 0;

    public function __construct()
    {
        parent::__construct();
        $segments = request()->segments();
        $module = isset($segments[0]) ? ucfirst($segments[0]) : "";
        if (!isset($this->model) || !$this->model || !$module) {
            die('Cannot get model. Please define model in controller.<br><b>protected $model = Model Name;</b>');
        }

        $this->module = ucwords(str_replace("-", " " , $module));
        $this->id = getParamInt('id');

        $this->linkEdit =  backend($module.'.edit');
        $this->linkDelete =  backend($module.'.delete');
        $this->moduel_url = backend($this->module);
    }

    public function Index_Action()
    {
        $this->setData['data'] = $this->model::getData(15);

        $this->setData['orderBy'] = getParam('orderBy', 'id');
        $this->setData['sortBy'] = getParam('sortBy', 'asc');
        $this->setData['pageUrl'] = $this->moduel_url;


        $this->setData['dataField'] = $this->model::getDataField();
        $this->metaData->title = "Danh sách ".$this->module;
        return $this->views('crud.list');
    }

    public function Edit_Action()
    {
        if($this->isSubmit){
            $rules = $this->model::getRules();
            $this->validate(request(), $rules);
            $this->model::submitForm();
            return redirect($this->moduel_url);
        }
        $this->setData['modelData'] = $this->model::getForm($this->id);
        $this->metaData->title = $this->id ? "Chỉnh sửa ".$this->module : "Thêm ".$this->module." mới";
        $this->loadEditorModule();
        return $this->views('crud.edit');
    }


    public function Delete_Action()
    {
        $this->model::hiddenId($this->id);
        return redirect($this->moduel_url);
    }


}