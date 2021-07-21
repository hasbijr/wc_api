<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function list()
    {
        $roles = Role::all(['name'])->toArray();
        $data = [];

        foreach ($roles as $role) {
            $data[$role['name']] = $role['name'];
        }
        return $this->writeResponseData($data);
    }
}
