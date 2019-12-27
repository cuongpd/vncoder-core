<?php

namespace Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Roles extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $primaryKey = 'id';
    protected $dateFormat = 'U';

    protected $table = 'vn_users_role';

    protected $fillable = ['id','name','description','permission'];

    public static function getRoles()
    {
        return self::select('id', 'name')->where('status', '>', 0)->get();
    }

    public static function getRoleInfo($role_id)
    {
        $info = self::where('id', $role_id)->first();
        return $info ? $info->name : "Chưa phân quyền";
    }

    public static function getData()
    {
        return self::select(with(new static)->fillable)->where('status', '>', 0)->orderBy('id', 'asc')->get();
    }

    public static function getInfo($id = 0)
    {
        if ($id == 0) {
            $info = newObject();
            $info->id = 0;
            $info->name = "";
            $info->description = "";
        } else {
            $info = self::select('id', 'name', 'description')->where('id', $id)->first();
        }
        return $info;
    }

    public static function updateRole($id, $data)
    {
        $name = isset($data['name']) ? $data['name'] : "";
        if (!$name) {
            return false;
        }
        $description = isset($data['description']) ? $data['description'] : "";
        $update = [
            'name' => $name ,
            'description' => $description,
            'updated' => time(),
        ];
        if ($id > 0) {
            self::where('id', $id)->update($update);
        } else {
            $update['created'] = time();
            self::insertGetId($update);
        }
        return true;
    }

    public static function listRole()
    {
        $role = [];
        $backend_controller_dir = BACKEND_PATH.'/Controllers';
        $backend_controller_core_dir = BACKEND_PATH.'/Core';


        $modules = File::allFiles($backend_controller_dir);
        foreach ($modules as $file) {
            $module = str_replace($backend_controller_dir.'/', '', $file);
            $module = trim(str_replace('Controller.php', '', $module)); // Remove Controller in name
            if ($module !== 'Backend') {
                $class_methods = self::getControllerMethod($file);
                if ($class_methods) {
                    $role['Controllers'][ucwords($module)] = $class_methods;
                }
            }
        }

        $modules = File::allFiles($backend_controller_core_dir);
        foreach ($modules as $file) {
            $module = str_replace($backend_controller_core_dir.'/', '', $file);
            $module = trim(str_replace('Controller.php', '', $module)); // Remove Controller in name
            if ($module !== 'Backend') {
                $class_methods = self::getControllerMethod($file);
                if ($class_methods) {
                    $role['Core'][ucwords($module)] = $class_methods;
                }
            }
        }


        return $role;
    }

    public static function getControllerMethod($file = '')
    {
        $data = [];
        $no_method = [
            '__construct', '__destruct'
        ];
        $list_method = array();
        $fileContents = file_get_contents($file);
        preg_match_all('/public function[\s\n]+(\S+)[\s\n]*\(/', $fileContents, $list_method);
        if (count($list_method) > 1) {
            foreach ($list_method[1] as $item) {
                if (!in_array($item, $no_method)) {
                    $data[] = $item;
                }
            }
        }
        return $data;
    }
}
