<?php

include_once 'Product.php';
include_once 'ProductRenderer.php';
include_once 'ProductService.php';
include_once ROOT.'/modules/category/Category.php';
include_once ROOT.'/modules/category/CategoryRenderer.php';

class ProductController
{
    public function checkslug(): bool
    {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
        echo json_encode(ProductService::checkslug($decoded));
        return true;
    }

    public function index(): bool
    {
        $products = Product::selectAll();
        $r = [
            'products' => $products,
            'categories' => Category::selectAll()
        ];
        echo json_encode($r);
        return true;
    }

    public function show(): bool
    {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
        $product = Product::selectOne($decoded);
        $r = [
            'product' => $product,
            'categories' => Category::selectAll()
        ];
        echo json_encode($r);
        return true;
    }

    public function update(): bool
    {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
        Product::update($decoded);
        $ifp = fopen($_SERVER['DOCUMENT_ROOT'] . "/ssr/img/{$decoded['code']}.jpg", 'wb');
        fwrite($ifp, base64_decode($decoded['img']));
        fclose($ifp);
        $pages = [
            'name' => ['index', 'payment', 'blog', 'contact', 'about'],
            'ua' => ['Головна', 'Оплата і доставка', 'Блог', 'Контакти', 'Про нас'],
            'en' => ['Main', 'Payment and Delivery', 'Blog', 'Contacts', 'About Us']
        ];
        ProductRenderer::details($decoded['id'], $pages);
        CategoryRenderer::details($decoded['cat_id'], $pages);
        return true;
    }

    public function store(): bool
    {
        $product = Product::insert();
        echo json_encode($product);
        $pages = [
            'name' => ['index', 'payment', 'blog', 'contact', 'about'],
            'ua' => ['Головна', 'Оплата і доставка', 'Блог', 'Контакти', 'Про нас'],
            'en' => ['Main', 'Payment and Delivery', 'Blog', 'Contacts', 'About Us']
        ];
        ProductRenderer::details($product['id'], $pages);
        return true;
    }

    public function destroy(): bool
    {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
        Product::deleteSelected(implode(', ', $decoded));
        return true;
    }
}
