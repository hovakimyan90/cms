<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Auth;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $table = "users";

    /**
     * Get user by id
     *
     * @param $id
     * @return mixed
     */
    public static function getUserById($id)
    {
        $user = self::find($id);
        return $user;
    }

    /**
     * Search and get users
     *
     * @param int $role_id
     * @param int $length
     * @param string $search
     * @return mixed
     */
    public static function getUsers($length = 0, $search = "", $role_id = 2)
    {
        if ($length > 0) {
            $users = self::orderBy("id", "desc")->where("username", "like", "%" . $search . "%")->where("id", "!=", 1)->where("id", "!=", Auth::user()->id)->whereVerify(1)->paginate($length);
        } else {
            $users = self::orderBy("id", "desc")->whereRole_id($role_id)->whereVerify(1)->get();
        }
        return $users;
    }

    /**
     * Get user by verification token
     *
     * @param string $token
     * @return mixed
     */
    public static function getUserByVerifyToken($token)
    {
        $user = self::whereVerify_token($token)->first();
        return $user;
    }

    /**
     * Get user by email
     *
     * @param $email
     * @return mixed
     */
    public static function getUserByEmail($email)
    {
        $user = self::whereEmail($email)->first();
        return $user;
    }

    /**
     * Get user by reset password token
     *
     * @param $token
     * @return mixed
     */
    public static function getUserByResetPasswordToken($token)
    {
        $user = self::whereReset_password_token($token)->first();
        return $user;
    }
}
