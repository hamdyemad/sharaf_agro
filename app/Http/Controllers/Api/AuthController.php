<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FirebaseToken;
use App\Traits\File;
use App\Traits\Res;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{

    use Res, File;
    public function login(Request $request) {
        $rules = [
            'username' => 'required|string|exists:users,username',
            'password' => "required"
        ];
        $messages = [
            'username.required' => 'أسم المستخدم مطلوب',
            'username.exists' => 'أسم المستخدم غير موجود',
            'password.required' => 'الرقم السرى مطلوب',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return $this->sendRes('يوجد خطأ ما', false, $validator->errors());
        }
        $user = User::with('roles')->where('username', $request->username)->first();
        $hashed = Hash::check($request->password, $user->password);
        if(!$hashed) {
            return $this->sendRes('يوجد خطأ ما', false, [
                'password' => 'الرقم السرى خطأ'
            ]);
        } else {
            $token = auth()->guard('api')->login($user);
            return $this->respondWithToken($token, true, 'تم تسجيل الدخول بنجاح', $user);
        }
    }

    public function firebase_tokens(Request $request) {
        $validator = Validator::make($request->all(), [
            'currentToken' => 'required|string'
        ], [
            'currentToken.required' => 'التوكين مطلوب',
            'currentToken.string' => 'التوكين يجب أن يكون نوعه سترينج'
        ]);
        if($validator->fails()) {
            return $this->sendRes('يوجد خطأ ما', false, $validator->errors());
        }

        $firebaseToken = FirebaseToken::where('token', $request->currentToken)->first();
        if(!$firebaseToken) {
            FirebaseToken::create([
                'user_id' => Auth::id(),
                'token' => $request->currentToken
            ]);
            return $this->sendRes('تم انشاء التوكين', true);
        } {
            return "token is created before";
        }
    }

    public function profile(Request $request) {
        return User::with('balance')->find(Auth::id());
    }

    public function update_profile(Request $request) {
        if(Auth::user()) {
            $updateArray = [
                'name' => $request->name,
                'email' => $request->email
            ];
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255',Rule::unique('users', 'email')->ignore(Auth::id())],
                'old_password' => 'required|min:8'
            ];
            $messages = [
                'name.required' => 'الأسم مطلوب',
                'name.string' => 'الأسم يجب أن يكون من نوع string',
                'name.max' => 'يجب أن يكون الأسم أقل من 255 حرف',
                'email.required' => 'البريد الالكترونى مطلوب',
                'email.string' => 'البريد الألكترونى يجب أن يكون من نوع string',
                'email.max' => 'يجب أن يكون البريد أقل من 255 حرف',
                'email.unique' => 'البريد هذا مستخدم من قبل',
                'old_password.required' => 'الرقم السرى مطلوب',
                'old_password.min' => 'الرقم السرى يجب ان يكون على الأقل 8 حروف'
            ];
            $hashed = false;
            $hashed = Hash::check($request->old_password, Auth::user()->password);
            if($hashed) {
                if($request->password !== null) {
                    $rules['password'] = 'required|min:8';
                    $messages['password.required'] = 'الرقم السرى الجديد مطلوب';
                    $messages['password.min'] = 'الرقم السرى الجديد يجب أن يكون اكثر من 8 حروف';
                }
                $validator = Validator::make($request->all(), $rules, $messages);
                if($validator->fails()) {
                    return $this->sendRes('يوجد خطأ ما', false, $validator->errors());
                }
                if($request->password) {
                    $updateArray['password'] = Hash::make($request->password);
                }
                if($request->has('avatar')) {
                    $updateArray['avatar'] = $this->uploadFile($request, $this->usersPath, 'avatar');
                    if(file_exists(Auth::user()->avatar)) {
                        $img = last(explode('/', Auth::user()->avatar));
                        if(in_array($img, scandir(dirname(Auth::user()->avatar)))) {
                            unlink(Auth::user()->avatar);
                        }
                    }
                }
                $user = User::find(Auth::id());
                $user->update($updateArray);
                return $this->sendRes('تم تعديل الملف الشخصى الخاص بك بنجاح', true);
            } else {
                return $this->sendRes('يوجد خطأ ما', false, ['old_password' => ['الرقم السرى القديم خطأ']]);
            }
        } else {
            return $this->sendRes('يوجد خطأ ما', false);
        }
    }
}
