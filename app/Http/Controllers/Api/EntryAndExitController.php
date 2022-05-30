<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EntryAndExit;
use App\Traits\Res;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EntryAndExitController extends Controller
{
    use Res;
    public function store(Request $request) {

        date_default_timezone_set('Africa/Cairo');

        if(Auth::user()->type == 'user') {
            return $this->sendRes('الحضور والأنصراف خاص بالموظفين فقط', false);
        } else {
            $rules = [
                'latitude' => 'required',
                'longitude' => 'required',
            ];
            $messages = [
                'latitude.required' => 'الأحداثيات مطلوبة',
                'longitude.required' => 'الأحداثيات مطلوبة',
            ];

            $vallidator = Validator::make($request->all(), $rules, $messages);

            if($vallidator->fails()) {
                return $this->sendRes('يوجد خطأ ما', false, $vallidator->errors());
            }

            $enteredAndExit = EntryAndExit::
                whereDate('current_date', Carbon::now()->format('Y-m-d'))
                ->where('user_id' ,  Auth::id())
                ->where('is_enter' , 1)

                ->orWhere('user_id' ,  Auth::id())
                ->where('is_exit' , 1)
                ->whereDate('current_date' , Carbon::now()->format('Y-m-d'))

            ->get();

            if(count($enteredAndExit) == 2) {

                return $this->sendRes('لا يمكنك الحضور او الأنصراف أكثر من مرة فى اليوم الواحد', false);

            } else {
                $enteredBefore = EntryAndExit::where(['current_date' => Carbon::now()->format('Y-m-d'),
                'user_id' =>  Auth::id(), 'is_enter' => 1])->first();
                if($enteredBefore) {
                    $EntryAndExit = EntryAndExit::create([
                        'user_id' => Auth::id(),
                        'current_date' => Carbon::now(),
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                        'is_exit' => 1,
                        'exit' => Carbon::now()->format('Y-m-d H:i')
                    ]);
                    return $this->sendRes('تم تسجيل انصرافك بنجاح', true, $EntryAndExit);
                } else {
                    $EntryAndExit = EntryAndExit::create([
                        'user_id' => Auth::id(),
                        'current_date' => Carbon::now(),
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                        'is_enter' => 1,
                        'entry' => Carbon::now()->format('Y-m-d H:i')
                    ]);
                    return $this->sendRes('تم تسجيل حضورك بنجاح', true, $EntryAndExit);
                }
            }
        }


    }
}
