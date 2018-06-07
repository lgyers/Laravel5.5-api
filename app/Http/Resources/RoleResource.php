<?php

namespace App\Http\Resources;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Resources\Json\Resource;

class RoleResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(Role $role)
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
        ];
    }
}
