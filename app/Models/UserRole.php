<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = "user_roles";

    /**
     * Get roles
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getRoles()
    {
        $roles = self::all();
        return $roles;
    }
}
