<?php

include_once 'Category.php';
include_once 'CategoryService.php';
include_once 'CategoryRenderer.php';

class CategoryController
{
    public function index(): bool
    {
        echo json_encode(CategoryService::index($_POST['lang']));
        return true;
    }

    public function list(): bool
    {
        echo json_encode(CategoryService::list());
        return true;
    }

    public function update(): bool
    {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
        Category::updateAll($decoded);
        return true;
    }

    public function store(): bool
    {
        $cat = Category::insert();
        $pages = [
            'name' => ['index', 'payment', 'blog', 'contact', 'about'],
            'ua' => ['Головна', 'Оплата і доставка', 'Блог', 'Контакти', 'Про нас'],
            'en' => ['Main', 'Payment and Delivery', 'Blog', 'Contacts', 'About Us']
        ];
        echo json_encode($cat);
        CategoryRenderer::details($cat['id'], $pages);
        return true;
    }

    public function destroy(): bool
    {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
        Category::deleteSelected(implode(', ', $decoded));
        return true;
    }
}
