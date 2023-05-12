<?php
namespace App\Service;

use App\Repository\Categories\CategoriesRepository;
use App\Service\Interface\CategoriesServiceInterface;

class CategoriesService implements CategoriesServiceInterface
{
    protected $categoriesRepository;
    public function __construct(CategoriesRepository $categoryRepository) {
        $this->categoriesRepository = $categoryRepository;
    }
    public function getAllCategories() {
        return $this->categoriesRepository->getAllCategories();
    }
    public function getById($id) {
        return $this->categoriesRepository->getById($id);
    }
    public function createCategories(array $data) {
        return $this->categoriesRepository->createCategories($data);
    }
    public function unActiveCategories($id) {
        return $this->categoriesRepository->unActiveCategories($id);
    }
    public function showActiveCategories($id) {
        return $this->categoriesRepository->showActiveCategories($id);
    }
    public function editCategories($id, array $data) {
        return $this->categoriesRepository->editCategories($id, $data);
    }
    public function deleteCategories($id) {
        return$this->categoriesRepository->deleteCategories($id);
    }
    public function deleteAllCategories(array $id) {
        $this->categoriesRepository->deleteAllCategories($id);
    }
}
