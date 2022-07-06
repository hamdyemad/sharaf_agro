<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permession;
use App\Models\Role;
use App\Traits\Res;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    use Res;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('roles.index');
        $roles = Role::with('permessions')->latest();
        $roles = $roles->get();
        return $this->sendRes('', true, $roles);
    }
}
