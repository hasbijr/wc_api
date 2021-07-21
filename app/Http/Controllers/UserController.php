<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInformation;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['create']]);
    }

    public function create(Request $request)
    {
        $userValidation = User::getValidationRules();
        unset($userValidation['password']);
        $userInfValidation = UserInformation::getValidationRules();
        $roleValidation = ['role.name' => 'required|exists:roles,name'];

        $validation = array_merge($userInfValidation, $userValidation, $roleValidation);

        $this->validate($request, $validation);

        DB::beginTransaction();

        try {
            $user = new User();
            $user->username = $request->username;
            $user->password = Hash::make('secret');

            if (!$user->save()) {
                throw new Exception('error: make user', 500);
            }

            $user->assignRole($request->role['name']);
            $userinf = new UserInformation();
            $userinf->user_id = $user->id;
            $userinf->nama = $request->user_information['nama'];

            if (!$userinf->save()) {
                throw new Exception('error: make user inf', 500);
            }

            DB::commit();
            return $this->writeResponseBody(self::HTTP_STATUS_CREATED, '', $user, true);
        } catch (QueryException $e) {
            DB::rollBack();
            return $this->writeResponse(self::HTTP_STATUS_ERROR, $e->getMessage(), false);
        }
    }
}
