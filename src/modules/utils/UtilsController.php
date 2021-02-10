<?php


class UtilsController
{
    public function defaultImages()
    {
        echo json_encode(Utils::generateDefaultImages());
        return true;
    }

    public function copyImages()
    {
        echo json_encode(Utils::copyImages());
        return true;
    }

    public function slug()
    {
        echo json_encode(Utils::slug());
        return true;
    }
}
