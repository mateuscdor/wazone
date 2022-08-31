<?php

namespace App\Http\Controllers;

class WebhookSallaController extends Controller
{

    /**
     * events and action method
     */
    protected const WEBHOOK_EVENTS = [
        "abandoned.cart" => "abandonedCart",
        "order.created" => "orderCreated",
        "order.status.updated" => "orderStatusUpdated",
        "order.cancelled" => "orderCancelled",
        "order.refunded" => "orderRefunded",
        "order.deleted" => "orderDeleted",
        "order.total.price.updated" => "orderTotalPriceUpdated",
    ];

    /**
     *
     * create user comes from salla
     *
     * @param $json
     * @return void
     *
     */
    public function createUser($json): void
    {
        //create user
    }

    /**
     *
     * check is webhook salla
     *
     * @param $authorization
     * @return bool
     */
    public function isWebhook($authorization): bool
    {
        return true;
    }

    /**
     *
     * check is salla wazone user
     *
     * @param $merchant_id
     * @return bool
     */
    public function isUser($merchant_id): bool
    {
        return true;
    }

    /**
     *
     * check and validate event
     *
     * @param $event
     * @return bool
     */
    public function isEvent($event): bool
    {
        return true;
    }


    /**
     *
     * get action method from events
     *
     * @param $event
     * @return string
     */
    public function getAction($event): string
    {
        return "";
    }

    /**
     *
     * do webhook action
     *
     * @param $json
     * @return void
     *
     */
    public function webhookAction($json): void
    {
        $data = json_decode($json, true);
        $authorization = $data["auth"];
        $merchant_id = $data["merchant_id"];
        $event = $data["event"];

        if ($this->isWebhook($authorization) && $this->isUser($merchant_id) && $this->isEvent($event)){
            $action = $this->getAction($event);
            $this->$action($json);
        }
    }
}
