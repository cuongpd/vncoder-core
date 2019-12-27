<?php

namespace VnCoder\Core\Models;

use Illuminate\Database\Eloquent\Model;

class VnRoles extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = '__roles';

    protected $fillable = ['id', 'name', 'description', 'permission'];


    public static function getRoles()
    {
        return self::select('id', 'name', 'description', 'permission')->where('status', '>', 0)->get();
    }

    public static function getInfo($id = 0)
    {
        return self::where('id', $id)->first();
    }

    public static function getRoleById($id = 0)
    {
    }

    public static function editRole($id, $data)
    {
        return self::where('id', $id)->update($data);
    }
}
