<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Traits\Res;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    use Res;
    public function index(Request $request) {
        $statuses = Status::latest();
        if($request->name) {
           $statuses->where('name', 'like', '%' . $request->name . '%');
        }
        $statuses = $statuses->paginate(10);
        return $this->sendRes('', true, $statuses);
    }
}
