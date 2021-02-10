<?php

include_once 'UserService.php';

class UserController
{
    public function index()
    {
        echo json_encode(UserService::index());
        return true;
    }

    public function update()
    {
        echo json_encode(UserService::update($_POST['d']));
        return true;
    }

    public function show()
    {
        echo json_encode(UserService::show());
        return true;
    }

    public function register()
    {
        echo json_encode(UserService::register($_POST['d']));
        return true;
    }

    public function email()
    {
        echo json_encode(UserService::email($_POST['email']));
        return true;
    }

    public function orders()
    {
        echo json_encode(UserService::orders($_POST['data']));
        return true;
    }

    public function logout()
    {
        UserService::logout();
        return true;
    }

    public function login()
    {
        echo json_encode(UserService::login($_POST['data']));
        return true;
    }

    public function logged()
    {
        echo json_encode(UserService::logged());
        return true;
    }
}
