<?php

namespace VnCoder\Core\Models;
use Illuminate\Database\Eloquent\Model;
use VnCoder\Helper\FormData;
use Illuminate\Support\Arr;

class VnModel extends Model
{
    use VnCache;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $primaryKey = 'id';
    protected $dateFormat = 'U';
    protected $columnable;
    protected $searchFields = array('title'); // Default
    // Crud Model
    protected $modelKey = [];
    protected $relations = [];
    protected $limit = 15;

    static function getInfo($id = 0)
    {
        return self::whereId($id)->first();
    }

    static function getData()
    {
        $limit = with(new static)->limit;
        $fillable = with(new static)->fillable;
        $orderBy = getParam('orderBy', 'id');
        $sortBy = getParam('sortBy', 'asc');
        if (!in_array($orderBy, $fillable)) {
            $orderBy = 'id';
        }
        $_query = getParam('_query', '');
        return self::relation()->active()->search($_query)->orderBy($orderBy, $sortBy)->paginate($limit);
    }

    static function getDataField(){
        return with(new static())->modelKey;
    }

    protected function formOption(){
        return [];
    }

    static function getForm($id = 0){
        if($id > 0){
            $info = self::where('id', $id)->first();
            if(!$info) return abort(404);;
        }else{
            $info = newObject();
            foreach (with(new static)->fillable as $item){
                $info->$item = "";
            }
        }

        $formOption = with(new static())->formOption();
        if(!$formOption){
            die('Vui lòng khai báo dữ liệu cho getForm method!');
        }
        foreach ($formOption as $key => $item) {
            $formOption[$key]['value'] = $info->$key;
        }
        $formOption['id'] = ['type' => 'hidden' , 'value' => $id];

        return $formOption;
    }

    public static function submitForm()
    {
        $data = request()->all();
        $id = isset($data['id']) ? $data['id'] : 0;
        unset($data['id']);
        $update = [];
        $update['status'] = 1;
        foreach (with(new static)->fillable as $item) {
            if (isset($data[$item])) {
                $update[$item] = $data[$item];
            }
        }
        if ($id) {
            self::where('id', $id)->update($update);
        } else {
            $id = self::insertGetId($update);
        }

        if ($id) {
            session()->flash('message', 'Bản ghi đã được lưu lại thành công!');
        } else {
            session()->flash('message', 'Có lỗi trong quá trình cập nhật!');
        }
        return $id;
    }


    public static function saveData($id, $data)
    {
        $data['updated'] = TIME_NOW;
        if ($id > 0) {
            return self::where('id', $id)->update($data);
        } else {
            $data['create'] = TIME_NOW;
            return self::create($data);
        }
    }

    // SCOPE Model
    public function scopeSearch($query, $data = '')
    {
        $searchFields = with(new static)->searchFields;
        if($data && $searchFields){
            if(is_array($searchFields)){
                foreach ($searchFields as $index => $item) {
                    if ($index == 0) {
                        $query->where($item, 'LIKE', '%'.$data.'%');
                    } else {
                        $query->orWhere($item, 'LIKE', '%'.$data.'%');
                    }
                }
            }else{
                $query->where($searchFields, 'LIKE', '%'.$data.'%');
            }
        }
        return $query;
    }

    public function scopeActive($query)
    {
        return $query->where('status', '>', 0);
    }

    public function scopeRelation($query)
    {
        $relations = with(new static)->relations;
        if($relations){
            return $query->with($relations);
        }
        return $query;
    }

    // ACTIVE - REMOVE ID
    public static function hiddenId($id = 0, $message = null)
    {
        if ($id) {
            $action = self::whereId($id)->update(['status' => -1]);
            if (!$message) {
                $message = "Bản ghi có ID = ".$id." đã được xóa thành công!";
            }
            flash_message($message);
            return $action;
        }
        return false;
    }

    public static function showId($id = 0, $message = null)
    {
        if ($id) {
            $action = self::whereId($id)->update(['status' => 1]);
            if (!$message) {
                $message = "Bản ghi có ID = ".$id." đã được khôi phục";
            }
            flash_message($message);
            return $action;
        }
        return false;
    }

}
