<?php

include_once 'ProductRepository.php';
include_once ROOT.'/components/Utils.php';

class ProductService
{
    public static function checkslug($data)
    {
        return ProductRepository::checkslug($data);
    }
}
