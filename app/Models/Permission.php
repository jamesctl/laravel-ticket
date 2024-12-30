<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    protected $table = "permissions";

    protected $fillable = [
        'module_id',
        'name',
        'action'
    ];

    public function getAll()
    {
        return $this
            ->select($this->table.'.*','modules.name as module_name')
            ->join('modules','modules.id',$this->table.'.module_id')
            ->get();
    }

}
