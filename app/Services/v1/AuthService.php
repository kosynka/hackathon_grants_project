<?php

namespace App\Services\v1;

use App\Models\Executor;
use App\Models\User;
use App\Presenters\v1\ExecutorPresenter;
use App\Presenters\v1\UserPresenter;
use App\Repositories\ExecutorRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AuthService extends BaseService
{
    private UserRepository $userRepository;
    private ExecutorRepository $executorRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
        $this->executorRepository = new ExecutorRepository();
    }

    public function login (array $data) {
        $user = $this->userRepository->findByPhone($data['phone']);

        if (isset($user)) {
            return $this->loginUser($data, $user);
        }
        else {
            return $this->error(401, 'Неверный номер телефона или пароль');
        }
    }

    private function loginUser($data, $user)
    {
        if (!Hash::check($data['password'], $user->password)) {
            return $this->error(401, 'Неверный номер телефона или пароль');
        }

        $token = $user->createToken($user->email, ['user'])->plainTextToken;

        return $this->result([
            'token' => $token,
            'user' => (new UserPresenter($user))->info(),
        ]);
    }

    public function register(array $data)
    {
        if ($this->userRepository->findByPhone($data['phone'])) {
            return $this->errNotAcceptable('Данный номер телефона уже занят');
        }
        if ($this->userRepository->findByEmail($data['email'])) {
            return $this->errNotAcceptable('Данный адрес эл. почты уже занят');
        }

        $data['password'] = Hash::make($data['password']);
        if(isset($data['photo_path'])) {
            $path = $data['photo_path']->store('public/user');
            $data['photo_path'] = Storage::url($path);
        }

        $this->userRepository->store($data);
        
        $user = $this->userRepository->findByPhone($data['phone']);
        $token = $user->createToken($user->email, ['user'])->plainTextToken;

        return $this->result([
            'token' => $token,
            'user' => (new UserPresenter($user))->info(),
        ]);
    }

    public function logout()
    {
        if (is_null(auth()->user())) {
            return $this->ok();
        }
        auth()->user()->tokens()->delete();
        return $this->ok();
    }

    public function sendForgot(string $email)
    {
        $user = User::where('email', $email)->first();

        if (!isset($user)) {
            $user = Executor::where('email', $email)->first();
        }

        if (!$user) {
            return $this->errNotFound('Пользователь не найден');
        }

        $token = rand(100000, 999999);
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
        ]);

        Mail::to($user->email)->send(new ResetPassword($token));

        return $this->ok('Код сброса пароля отправлен на почту');
    }

    public function reset($password, $token)
    {
        $passwordReset = DB::table('password_resets')->where('token', $token)->first();

        if (is_null($passwordReset)) {
            return $this->errNotFound('Неверный код');
        }

        $user = User::where('email', $passwordReset->email)->first();
        if (!isset($user)) {
            $user = Executor::where('email', $passwordReset->email)->first();
        }

        if (is_null($user)) {
            return $this->errNotFound('Пользователь не найден');
        }
        if (Hash::check($password, $user->password)) {
            return $this->errNotAcceptable('Новый пароль не может совпадать со старым');
        }

        $password = Hash::make($password);

        $user->update(['password' => $password]);

        DB::table('password_resets')->where('token', $token)->delete();

        return $this->ok('Пароль изменён');
    }
}
