<?php

include_once 'Review.php';
include_once ROOT.'/modules/product/ProductRenderer.php';

class ReviewController
{
    public function store(): bool
    {
        echo json_encode(Review::store($_POST['review']));
        ProductRenderer::details($_POST['review']['product_id']);
        return true;
    }
}
