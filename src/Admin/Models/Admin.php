<?php

namespace Core\Modules\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $primaryKey = 'id';
    protected $dateFormat = 'U';

    protected $table = 'vn_admin';

    protected $fillable = ['id','role_id','email','name','avatar','jobs','info'];
    protected $hidden = ['password','token'];

    public static function login($email, $password)
    {
        $user = self::select('id', 'email', 'name', 'avatar', 'jobs', 'info')->whereEmail($email)->wherePassword(self::encrypt($password))->first();
        if ($user) {
            $token = self::token($user->id);
            session([ 'uid' => $user->id , 'user' => $user->data , 'token' => $token ]);
        }
        return $user;
    }

    public static function token($uid)
    {
        return md5('vn-'.$uid.'-vip2018');
    }

    public static function logout()
    {
        session()->forget([ 'uid' ,'user' ,'token' ]);
    }

    public static function getInfo($uid = 0)
    {
        return self::where('id', $uid)->first();
    }

    public static function updateProfile($uid, $data)
    {
        $update = [];
        $update['updated'] = TIME_NOW;
        if ($data['name']) {
            $update['name'] = $data['name'];
        }
        if ($data['avatar']) {
            $update['avatar'] = $data['avatar'];
        }
        return self::where('id', $uid)->update($update);
    }

    public static function changePassword($uid, $old, $new)
    {
        $user = self::getInfo($uid);
        if ($user) {
            if ($user->password == self::encrypt($old)) {
                self::where('id', $uid)->update(['password' => self::encrypt($new) , 'updated' => TIME_NOW]);
                flash('Mật khẩu đã được thay đổi thành công');
                return true;
            } else {
                flash('Mật khẩu hiện tại bạn nhập không đúng');
                return false;
            }
        }
        flash('Lỗi không tồn tại User');
        return redirect()->route('backend.auth.logout');
    }

    public static function getData($limit = 10)
    {
        $fillable = with(new static)->fillable;
        $orderBy = getParam('orderBy', 'id');
        $sortBy = getParam('sortBy', 'asc');

        if (!in_array($orderBy, $fillable)) {
            $orderBy = 'id';
        }

        $sortBy = $sortBy == 'asc' ? 'asc' : 'desc';

        return self::select($fillable)->where('status', '>', 0)->orderBy($orderBy, $sortBy)->paginate($limit);
    }

    public static function createUser($email, $password, $name, $role_id = 0)
    {
        $checkUser = self::checkEmailUser($email);
        if (!$checkUser) {
            $data = [
                'email' => $email,
                'password' => self::encrypt($password),
                'name' => $name,
                'role_id' => $role_id,
                'created' => TIME_NOW
            ];
            $userID = self::insertGetId($data);
            return $userID;
        }
        return false;
    }

    public static function checkEmailUser($email)
    {
        return self::where('email', $email)->first();
    }

    public static function encrypt($password)
    {
        return md5('vn-coder-'.md5($password).'-2018');
    }

    public static function deactive($id)
    {
        return self::where('id', $id)->update(['status' => -1]);
    }

    public function getDataAttribute()
    {
        return json_decode(json_encode($this->attributes), false);
    }
}
