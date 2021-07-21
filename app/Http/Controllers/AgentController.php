<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AgentController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['list']]);
        $this->middleware('permission:list-agent', ['only' => ['list']]);
    }

    public function list(Request $request)
    {
        $query = User::with('userinformation')
            ->whereIn('id', function ($q) {
                $q->select('model_id')
                    ->from('model_has_roles')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->where('model_type', '=', User::class)
                    ->where('roles.name', '=', 'Agen');
            })
            ->limit(10);

        if ($request->filled('username')) {
            $query = $query->where('username', 'like',  '%' . $request->input('username') . '%');
        }

        $data = $query->get()->toArray();

        return $this->writeResponseData($data);
    }
}
