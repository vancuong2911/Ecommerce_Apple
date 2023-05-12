<?php

namespace App\Service\Interface;

interface BannersServiceInterface
{
    public function getAllBanners();
    public function getById($id);
    public function createBanners(array $data);
    public function unActiveBanners($id);
    public function showActiveBanners($id);
    public function editBanners($id, array $data);
    public function validateImage($image);
    public function deleteBanners($id);
    public function deleteAllBanners(array $id);
}

