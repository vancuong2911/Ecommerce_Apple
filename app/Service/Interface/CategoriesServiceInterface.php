<?php

namespace App\Service\Interface;

interface CategoriesServiceInterface
{
    public function getAllCategories();
    public function getById($id);
    public function createCategories(array $data);

    public function unActiveCategories($id);
    public function showActiveCategories($id);
    public function editCategories($id, array $data);
    public function deleteCategories($id);
    public function deleteAllCategories(array $id);
}

