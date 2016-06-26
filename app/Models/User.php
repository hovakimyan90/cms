<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;

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
     * @param int $length
     * @param string $search
     * @return mixed
     */
    public static function getUsers($length = 0, $search = "")
    {
        if ($length > 0) {
            $users = self::orderBy("id", "desc")->where("username", "like", "%" . $search . "%")->paginate($length);
        } else {
            $users = self::orderBy("id", "desc")->get();
        }
        return $users;
    }

    /**
     * Get user by verification token
     *
     * @param string $token
     * @return mixed
     */
    public static function getUserByVerifyToken($token = "")
    {
        $user = self::whereVerify_token($token)->first();
        return $user;
    }
}
