<?php

include_once 'OrderService.php';

class OrderController
{
    public function index()
    {
        echo json_encode(OrderService::index());
        return true;
    }
}
