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
     * Search and get user
     *
     * @param int $length
     * @param string $search
     * @return mixed
     */
    public static function getUsers($length = 0, $search = "")
    {
        if ($length > 0) {
            $users = self::orderBy("id", "desc")->where("username", "like", "%" . $search . "%")->where("id", "!=", 1)->where("id", "!=", Auth::user()->id)->paginate($length);
        } else {
            $users = self::orderBy("id", "desc")->where("id", "!=", 1)->where("id", "!=", Auth::user()->id)->get();
        }
        return $users;
    }

    /**
     * Search and get approved users
     *
     * @param int $length
     * @param string $search
     * @return mixed
     */
    public static function getApprovedUsers($length = 0, $search = "") {
        if ($length > 0) {
            $users = self::orderBy("id", "desc")->where("username", "like", "%" . $search . "%")->where("id", "!=", 1)->where("id", "!=", Auth::user()->id)->whereApprove(1)->paginate($length);
        } else {
            $users = self::orderBy("id", "desc")->where("id", "!=", 1)->where("id", "!=", Auth::user()->id)->whereApprove(1)->get();
        }
        return $users;
    }

    /**
     * Search and get disapproved users
     *
     * @param int $length
     * @param string $search
     * @return mixed
     */
    public static function getDisapprovedUsers($length = 0, $search = "") {
        if ($length > 0) {
            $users = self::orderBy("id", "desc")->where("username", "like", "%" . $search . "%")->where("id", "!=", 1)->where("id", "!=", Auth::user()->id)->whereApprove(0)->paginate($length);
        } else {
            $users = self::orderBy("id", "desc")->where("id", "!=", 1)->where("id", "!=", Auth::user()->id)->whereApprove(0)->get();
        }
        return $users;
    }


    /**
     * Get admins
     *
     * @return mixed
     */
    public static function getAdmins() {
        $users = self::orderBy("id", "desc")->where("id", "!=", 1)->where("id", "!=", Auth::user()->id)->whereRole_id(1)->whereApprove(1)->get();
        return $users;
    }

    /**
     * Get user by verification token
     *
     * @param $token
     * @return mixed
     */
    public static function getUserByActivationToken($token)
    {
        $user = self::whereActivation_token($token)->first();
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
