<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserCodes;
use App\Models\UserOptions;
use App\Services\SmsSenderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserAuthController
{
    public function loginUser(Request $request): JsonResponse
    {
        $response = [
            'status' => 200,
        ];

        $request->validate([
            'phone' => 'required|unique:users',
            'password' => 'required|min:4',
        ]);

        $data = $request->all();

        $credentials = [
            'phone' => $this->phoneNormalize($data['phone']),
            'password' => $data['password'],
        ];
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $response['redirect'] = '/';
            $response['result'] = true;
        } else {
            $response['result'] = false;
            $db_user = User::query()->where(['phone' => $this->phoneNormalize($data['phone'])])->first();
            if (!$db_user) {
                $response['phone_error'] = 'Пользователь c таким номером телефона не найден';
            } else {
                $response['pass_error'] = 'Неверный пароль';
            }
        }

        return new JsonResponse($response);
    }

    public function checkUser(Request $request): JsonResponse
    {
        $response = [
            'status' => 200,
        ];

        $data = $request->all();

        $user = User::query()->where('phone', $this->phoneNormalize($data['phone']))->count();

        if ($user > 0) {
            $response['phone_error'] = 'Пользователь с таким номером телефона уже зарегистрирован';
            return new JsonResponse($response);
        } else {
            $user = $this->createNewUser($data);

            if ($user) {
                /** Генерируем код для подтверждения номера телефона */
                $code = $this->generateCode();
                /** Удаляем предыдущие запросы */
                $userCodes = UserCodes::query()->where(['user_id' => $user->id])->get();
                if ($userCodes) {
                    foreach ($userCodes as $userCode) {
                        $userCode->delete();
                    }
                }
                $newUserCode = UserCodes::create([
                    'user_id' => $user->id,
                    'code' => $code,
                ]);
                if (!$newUserCode) {
                    $response['message'] = 'Не удалось подготовить код для пользователя';
                }
                /** Высылаем СМС для подтверждения номера телефона */
                $smsSender = new SmsSenderService();
                $response['result'] = $smsSender->send($this->phoneNormalize($data['phone']), $newUserCode->code);
            }
        }


        return new JsonResponse($response);
    }

    public function registration(Request $request): JsonResponse
    {
        $response = [
            'status' => 200,
            'is_user_login' => false,
        ];

        $t = $request->validate([
            'name' => 'required|min:2',
            'phone' => 'required|unique:users',
            'password' => 'required|min:4',
        ]);

        $data = $request->all();
        /** Создаем нового пользователя */
//        $check = $this->createNewUser($data);

        $check = true;
        if ($check) {


            return new JsonResponse($response);
//            $credentials = $request->only('phone', 'password');
//            if (Auth::attempt($credentials)) {
//                return Redirect('/');
//            }
        }
//        return redirect('/');
        return new JsonResponse($response);
    }

    public function checkCode(Request $request): JsonResponse
    {
        $response = [
            'status' => 200,
        ];

        $data = $request->all();

        $user = User::query()->where([
            'phone' => $this->phoneNormalize($data['phone']),
            'name' => $data['name']
        ])->first();

        if ($user) {
            $userCode = UserCodes::query()->where([
                'user_id' => $user->id,
                'code' => $data['code'],
            ])->first();
            if ($userCode) {
                /** Код совпал - авторизуем пользователя */
                $credentials = [
                    'phone' => $this->phoneNormalize($data['phone']),
                    'password' => $data['password'],
                ];

                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                    $response['redirect'] = '/';
                    $response['result'] = true;

                    /** Добавляем дату верификации номера телефона */
                    $user->phone_verified_at = time();
                    $user->save();
                    /** Удаляем проверочный код */
                    $userCode->delete();
                }

            } else {
                $response['message'] = 'Введен неверный код';
            }
        } else {
            $response['message'] = 'Не удалось найти пользователя пользователя';
        }

        return new JsonResponse($response);
    }

    public function createNewUser(array $data)
    {
        $result = false;
        $user = User::create([
            'name' => $data['name'],
            'phone' => $this->phoneNormalize($data['phone']),
            'password' => Hash::make($data['password'])
        ]);

        if ($user) {
            $default_role = Role::where(['is_default' => true])->first();
            if ($default_role) {
                $user_options = UserOptions::create([
                    'user_id' => $user->id,
                    'role_id' => $default_role->id,
                ]);
                if ($user_options) {
                    $result = $user;
                }
            }
        }

        return $result;
    }

    public function phoneNormalize($phone = ''): string
    {
        $result = '';
        if ($phone !== '') {
            for ($i = 0; $i < strlen($phone); $i++) {
                if (!is_numeric($phone[$i])) {
                    continue;
                } else {
                    if ($result === '' && $phone[$i] === '8') {
                        $result .= '7';
                        continue;
                    }
                    $result .= $phone[$i];
                }
            }
        }

        return $result;
    }

    public function generateCode($length = 6): string
    {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= rand(0, 9);
        }

        return $result;
    }

    public function logoutUser(Request $request)
    {
        $response = [
            'status' => 200,
        ];

        Auth::logout();
        Session::flush();

        $response['redirect'] = '/';
        $response['result'] = true;

        return new JsonResponse($response);
    }
}
