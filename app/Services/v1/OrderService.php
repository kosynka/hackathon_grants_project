<?php

namespace App\Services\v1;

use App\Models\Offer;
use App\Models\Order;
use App\Presenters\v1\ExecutorPresenter;
use App\Presenters\v1\OfferPresenter;
use App\Presenters\v1\OrderPresenter;
use App\Repositories\OrderRepository;
use App\Repositories\ReportRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class OrderService extends BaseService
{
    private OrderRepository $orderRepository;

    private ReportRepository $reportRepository;

    private $user;

    public function __construct() {
        $this->orderRepository = new OrderRepository();
        $this->reportRepository = new ReportRepository();
    }

    private function defineUser()
    {
        $user = auth('api-user')->user();

        if (!isset($user)) {
            return $this->errFobidden(403, 'Требуется авторизация');
        }
        else {
            $this->user = $user;
        }
    }

    private function defineExecutor()
    {
        $executor = auth('api-executor')->user();

        if (!isset($executor)) {
            return $this->errFobidden(403, 'Требуется авторизация');
        }
        else {
            $this->user = $executor;
        }
    }

    private function checkPermissions($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return $this->errNotFound('Заявка не найдена');
        }

        if ($order->executor_id != $this->user->id) {
            return $this->errNotAcceptable('В доступе отказано');
        }
    }

    public function index()
    {
        $this->defineUser();
        $user = $this->user;
        if (isset($user)) {
            $params = ['city_id' => $user->city_id];
            $orders = $this->orderRepository->onlyUserOrders($user->id, $params);
            return $this->resultCollections($orders, OrderPresenter::class, 'list');
        }

        $this->defineExecutor();
        $executor = $this->user;
        if (isset($executor)) {
            $params = ['city_id' => $executor->city_id];
            $orders = $this->orderRepository->executorOrders($params);
            $orders = $orders->sortByDesc('user_id');
            return $this->resultCollections($orders, OrderPresenter::class, 'list');
        }

        $orders = $this->orderRepository->index();
        return $this->resultCollections($orders, OrderPresenter::class, 'list');
    }

    public function ordersIndexByUserId(int $user_id)
    {
        $this->defineExecutor();
        $executor = $this->user;

        $params = ['city_id' => $executor->city_id];
        $params = ['user_id' => $user_id];

        $orders = $this->orderRepository->executorOrdersByUserId($params);
        $orders = $orders->sortByDesc('user_id');
        return $this->resultCollections($orders, OrderPresenter::class, 'list');
    }

    public function create(array $data)
    {
        $data['status'] = Order::STATUS_CREATED;
        if(isset($data['images'])) {
            $data['image_path'] = json_encode($this->attachImages($data['images']));
        }

        $order = $this->orderRepository->store($data);

        return $this->result([
            'order' => (new OrderPresenter($order))->list(),
        ]);
    }

    public function update(int $id, array $data)
    {
        $this->defineUser();
        $user = $this->user;

        $order = Order::find($id);
        if (!$order) {
            return $this->errNotFound('Заявка не найдена');
        }
        if ($order->user_id != $user->id) {
            return $this->errNotAcceptable('В доступе отказано');
        }

        if(isset($data['images'])) {
            $data['images'] = json_encode($this->attachImages($data['images']));
        }

        $this->orderRepository->update($order, $data);
        return $this->ok('Заявка обновлена');
    }

    public function waitReport(int $id)
    {
        $this->defineUser();
        $user = $this->user;

        $order = Order::find($id);
        if (!$order) {
            return $this->errNotFound('Заявка не найдена');
        }

        if ($order->user_id != $user->id) {
            return $this->errNotAcceptable('В доступе отказано');
        }

        if ($order['status'] == Order::STATUS_OFFER_ACCEPTED) {
            $this->orderRepository->waitReport($order, ['status' => Order::STATUS_WAITING_FOR_REPORT]);
        } else {
            return $this->errNotFound('Заявка не может перейти на этот статус');
        }

        return $this->ok('Заявка ждет отчета');
    }

    public function approve(int $id)
    {
        $this->defineUser();
        $user = $this->user;

        $order = Order::find($id);
        if (!$order) {
            return $this->errNotFound('Заявка не найдена');
        }

        if ($order->user_id != $user->id) {
            return $this->errNotAcceptable('В доступе отказано');
        }

        if ($order['status'] == Order::STATUS_REPORT_SENT) {
            $this->orderRepository->approve($order, ['status' => Order::STATUS_APPROVED]);
        } else {
            return $this->errNotFound('Заявка не может перейти на этот статус');
        }

        (new PushNotificationService)->sendNotification($order->executor->fb_token, 'Заказ №'. $order->id, 'Ваш отчет принят', ['orderId' => $order->id]);

        return $this->ok('Работа одобрена');
    }

    public function notApprove(int $id)
    {
        $this->defineUser();
        $user = $this->user;

        $order = Order::find($id);
        if (!$order) {
            return $this->errNotFound('Заявка не найдена');
        }

        if ($order->user_id != $user->id) {
            return $this->errNotAcceptable('В доступе отказано');
        }

        if ($order['status'] == Order::STATUS_REPORT_SENT) {
            $this->orderRepository->notApprove($order, ['status' => Order::STATUS_NOT_APPROVED]);
        } else {
            return $this->errNotFound('Заявка не может перейти на этот статус');
        }

        (new PushNotificationService)->sendNotification($order->executor->fb_token, 'Заказ №'. $order->id, 'Ваш отчет отклонен', ['orderId' => $order->id]);

        return $this->ok('Работа Не одобрена');
    }

    public function info(int $id)
    {
        $order = $this->orderRepository->info($id);
        if(!$order) {
            return $this->errNotFound('Заявка не найдена');
        }

        return $this->result([
            'order' => (new OrderPresenter($order))->list(),
        ]);
    }

    public function delete(int $id)
    {
        $user = auth('api-user')->user();
        if (!$user) {
            return $this->errFobidden('Пользователь не авторизирован');
        }

        $order = Order::find($id);
        if (!$order) {
            return $this->errNotFound('Заявка не найдена');
        }
        if ($order->user_id != $user->id) {
            return $this->errNotAcceptable('В доступе отказано');
        }

        $this->orderRepository->delete($order);
        return $this->ok('Заявка удалена');
    }

    public function offers(int $id)
    {
        $user = auth()->user();
        if (!$user) {
           return $this->errFobidden('Требуется авторизация');
        }

        $order = Order::find($id);
        if (!$order) {
            return $this->errNotFound('Заявка не найдена');
        }
        if($order->user_id != $user->id)
        {
            return $this->errNotAcceptable('В доступе отказано');
        }

        return $this->resultCollections($order->offers, OfferPresenter::class, 'forOrder');
    }

    public function userOrders(array $statuses)
    {
        $this->defineUser();
        $user = $this->user;

        $orders = $this->orderRepository->userOrders($user->id, $statuses);
        return $this->resultCollections($orders, OrderPresenter::class, 'list');
    }

    private function attachImages(array $images)
    {
        $image_path = array();

        foreach($images as $image) {
            $fileName = time() . $image->getClientOriginalName();
            Storage::disk('public')->put('order/' . $fileName, File::get($image));
            $fileName = 'storage/order/' . $fileName;
            array_push($image_path, $fileName);
        }
        
        return $image_path;
    }
}
