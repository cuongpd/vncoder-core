<?php

namespace VnCoder\Helper;

class FormData
{
    protected $html = '';
    protected $action = '';
    protected $data = null;

    public static function init()
    {
        return with(new static);
    }

    public function setData($data = null)
    {
        $this->data = $data;
        return $this;
    }

    public function setAction($action = '')
    {
        $this->action = $action; // Submit form to url
        return $this;
    }

    public function getForm()
    {
        $this->openForm();
        $this->formGenerator();
        $this->closeForm();
        return $this->html;
    }

    public function openForm()
    {
        $action = $this->action;
        $this->html .= $this->getHtml('_open', ['action' => $action]);
    }

    public function closeForm()
    {
        $this->html .= $this->getHtml('_close');
    }

    public function getHtml($template, $data = [])
    {
        $path = 'core::form.'.$template;
        $data['path'] = $path;
        if (view()->exists($path)) {
            return view($path, $data)->render();
        } else {
            return view('core::form.blank', $data)->render();
        }
    }

    public function formGenerator()
    {
        // View Data: title , name , value ,
        if ($this->data && is_array($this->data)) {
            foreach ($this->data as $key => $data) {
                $data['name'] = $key;
                $formType = (isset($data['type']) && $data['type']) ? $data['type'] : $this->getTypeFormByName($key);

                $data['value'] = isset($data['value']) ? $data['value'] : "";
                $data['size'] = isset($data['size']) ? $data['size'] : 10;
                $data['required'] = isset($data['required']) ? $data['required'] : "";
                $data['placeholder'] = isset($data['placeholder']) ? $data['placeholder'] : $data['title'];
                $this->html .= $this->getHtml($formType, $data);
            }
        }
    }

    public function getTypeFormByName($name = '')
    {
        if (in_array($name, ['id', 'created', 'updated', 'status', 'created_at', 'updated_at'])) {
            return 'hidden';
        }
        if (in_array($name, ['photo', 'avatar', 'img', 'image', 'images', 'logo', 'favicon'])) {
            return 'photo';
        }
        if (in_array($name, ['file', 'source', 'video', 'webm'])) {
            return 'file';
        }
        if (in_array($name, ['description', 'meta'])) {
            return 'textarea';
        }
        if (in_array($name, ['content'])) {
            return 'content';
        }
        if (in_array($name, ['keyword','tags'])) {
            return 'tags';
        }
        return 'text';
    }
}
