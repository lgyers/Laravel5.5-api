<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\PermissionsRresource;

class PermissionsController extends ApiController
{
    public function index()
    {
        $user = \Auth::guard('api')->user();
        $permissions = $user->getAllPermissions();
        return $this->success(PermissionsRresource::collection($permissions));
    }
}
