<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $table = "user_permission";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'permission_id',
    ];

    public function insertData($data)
    {
        return $this
            ->insert($data);

    }

    public function getListPermissionUser($userId)
    {
        return $this
            ->where('user_id',$userId)
            ->get();
    }

    public function removeByUserId($userId)
    {
        return $this
            ->where('user_id',$userId)
            ->delete();
    }

    /**
     * Kiểm tra quyền chi tiết theo user và chức năng
     * @param $userId
     * @param $keyPermision
     * @return mixed
     */
    public function checkPagePermision($userId,$keyPermision)
    {
        return $this
            ->join('permissions','permissions.id', $this->table.'.permission_id')
            ->where('user_id',$userId)
            ->where('permissions.name',$keyPermision)
            ->first();
    }

}
