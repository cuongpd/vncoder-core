<?php

namespace VnCoder\Core\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class VnUsers extends Authenticatable
{
    use Notifiable;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $primaryKey = 'id';
    protected $dateFormat = 'U';

    protected $table = '__users';

    protected $fillable = ['role_id','code', 'name', 'nickname', 'email', 'password', 'phone', 'jobs', 'provider', 'provider_id', 'avatar', 'permission', 'status'];

    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    public function role(){
        return $this->belongsTo(VnRoles::class, 'role_id', 'id');
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar ?? url('images/user.jpg');
    }

    public function getCodeAttribute()
    {
        return $this->code ?? numberx($this->id , false);
    }

    // Xử lý lấy dữ liệu
    public static function getData($limit = 20){
        return self::with('role')->orderBy('id', 'desc')->paginate($limit);
    }

    public function getRoleNameAttribute(){
        return $this->role->name ?? "Guest User";
    }

    public function getPermissionAttribute(){
        if($this->role_id > 0){
            if($this->role_id == 1){
                return 'Root_User';
            }else{
                return $this->role->permission;
            }
        }
        return -1;
    }

    public static function active($id)
    {
        self::where('id', $id)->update(['status' => 1]);
        flash_message('User has unlocked!');
    }

    public static function deactive($id)
    {
        self::where('id', $id)->update(['status' => -1]);
        flash_message('User has locked!');
    }

    public static function getUser()
    {
        return Auth::user();
    }

    public static function getInfo($uid = 0)
    {
        return self::where('id', $uid)->first();
    }

    static function createUser($name , $email , $password , $phone = '' , $jobs = ''){
        $userId = self::insertGetId([
            'name' => $name , 'email' => $email, 'password' => bcrypt($password) ,  'phone' => $phone , 'jobs' => $jobs
        ]);
        if($userId){
            self::where('id',$userId)->update(['code' => numberx($userId)]);
        }
        return $userId;
    }


}
