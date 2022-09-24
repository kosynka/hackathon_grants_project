<?php

namespace App\Services\v1;

use App\Models\User;
use App\Presenters\v1\UserPresenter;
use App\Presenters\v1\OfferPresenter;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Storage;

class UserService extends BaseService
{
    private UserRepository $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function info(int $userId)
    {
        $user = User::find($userId);
        if (is_null($user)) {
            return $this->errNotFound('Пользователь не найден');
        }

        $authExecutor = auth('api-executor')->user();
        if (!is_null($authExecutor)) {
            $order = Order::where('user_id', $userId)
                ->where('executor_id', $authExecutor->id)
                ->first();
            if (!is_null($order)) {
                return $this->result(['user' => (new UserPresenter($user))->info()]);
            }
        }

        $authUser = auth('api')->user();
        if (!is_null($authUser) && $authUser->id == $userId) {
            return $this->result(['user' => (new UserPresenter($user))->info()]);
        }

        return $this->result(['user' => (new UserPresenter($user))->shortInfo()]);
    }

    public function update(array $data)
    {
        $user = auth('api')->user();
        if (!$user) {
            return $this->errFobidden('Пользователь не авторизирован');
        }

        if (array_key_exists('phone', $data)) {
            if ($this->userRepository->findByPhone($data['phone']) && $user->phone != $data['phone']) {
                return $this->errNotAcceptable('Данный номер телефона уже занят');
            }
        }
        if (array_key_exists('email', $data)) {
            if ($this->userRepository->findByEmail($data['email']) && $user->email != $data['email']) {
                return $this->errNotAcceptable('Данный адресом эл. почты уже занят');
            }
        }

        if (isset($data['photo_path'])) {
            $path = $data['photo']->store('public/user');
            $data['photo_path'] = Storage::url($path);
        }

        $this->userRepository->update($user, $data);
        return $this->result(['user' => (new UserPresenter($user))->info()]);
    }

    public function offersList()
    {
        $user = auth('api')->user();
        $offers = $this->userRepository->offersList($user);

        return $this->resultCollections($offers, OfferPresenter::class, 'index');
    }

    public function verifyEmail()
    {
        $user = auth('api')->user();
        $user->sendEmailVerificationNotification();

        return $this->ok('На вашу почту было высланно письмо подтверждения');
    }

    public function resendVerify()
    {
        $user = auth('api')->user();
        $user->sendEmailVerificationNotification();

        return $this->ok('На вашу почту было высланно письмо подтверждения');
    }
}
