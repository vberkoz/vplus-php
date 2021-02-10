<?php

include_once 'SearchService.php';

class SearchController
{
    public function full()
    {
        echo json_encode(SearchService::full($_POST));
        return true;
    }
}
