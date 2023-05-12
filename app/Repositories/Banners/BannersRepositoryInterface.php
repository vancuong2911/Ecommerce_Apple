<?php
namespace App\Repository\Banners;

use App\Repository\RepositoryInterface;

interface BannersRepositoryInterface extends RepositoryInterface
{
    public function getAllBanners();
    public function getById($id);
    public function createBanners(array $data);
    public function unActiveBanners($id);
    public function showActiveBanners($id);
    public function editBanners($id, array $data);
    public function deleteBanners($id);
    public function deleteAllBanners(array $id);
}
