<?php

namespace App\Repository\Banners;

use App\Models\Banners;
use App\Repository\BaseRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class BannersRepository extends BaseRepository implements BannersRepositoryInterface
{
    public function getModel()
    {
        return Banners::class;
    }
    public function getAllBanners() {
        return $this->model->paginate(10);
    }
    public function getById($id) {
        return $this->model->find($id);
    }
    public function createBanners(array $data) {
        $banners = new Banners();
        $banners->title = $data['banners_title'];
        $banners->content = $data['banners_content'];
        $banners->active = $data['banners_active'];

        // Upload and store the image
        if (isset($data['image']) && $data['image']->isValid() && strpos($data['image']->getMimeType(), 'image/') === 0) {
            $destinationPath = 'banners/';
            $profileImage = date('YmdHis') . "." . $data['image']->getClientOriginalExtension();
            $data['image']->storeAs($destinationPath, $profileImage, 'public');
            $banners->image_url = "$profileImage";
        } else {
            return false;
        }

        $banners->save();
        return $banners->fresh();
    }
    public function unActiveBanners($id) {
        $this->model->where('id', $id)->update(['active' => 0]);
        return redirect()->back()->with('message', 'Bạn đã ẩn banner thành công!');
    }
    public function showActiveBanners($id) {
        $this->model->where('id', $id)->update(['active' => 1]);
        return redirect()->back()->with('message', 'Bạn đã hiển thị banner thành công!');
    }
    public function editBanners($id, array $data)
    {
        $banners = $this->getById($id);
        $banners->title = $data['banners_title'];
        $banners->content = $data['banners_content'];

        // Xóa ảnh cũ
        if(isset($data['image'])) {
            if (Storage::disk('public')->exists('banners/' . $banners->image_url)) {
                Storage::disk('public')->delete('banners/' . $banners->image_url);
            }
            $destinationPath = 'banners/';
            $profileImage = date('YmdHis') . "." . $data['image']->getClientOriginalExtension();
            $data['image']->storeAs($destinationPath, $profileImage, 'public');
            $banners->image_url = "$profileImage";
        }

        $banners->save();
        return $banners;
    }

    public function deleteBanners($id) {
        $banners = $this->getById($id);
        return $banners->delete($id);
    }
    public function deleteAllBanners(array $id) {
        $this->model->whereIn('id', $id)->delete();
    }


}
