<?php

namespace App\Repository\Categories;

use App\Models\Categories;
use App\Repository\BaseRepository;
use Illuminate\Support\Facades\DB;

class CategoriesRepository extends BaseRepository implements CategoriesRepositoryInterface
{
    public function getModel()
    {
        return Categories::class;
    }
    public function getAllCategories() {
        return $this->model->paginate(10);
    }
    public function getById($id) {
        return $this->model->find($id);
    }
    public function createCategories(array $data) {
        $categories = new Categories();
//        $this->getModel()->create();
        $categories->name = $data['categories_name'];
        $categories->active = $data['categories_active'];

        $categories->save();
        return $categories->fresh();
    }
    public function unActiveCategories($id) {
        $this->model->where('id', $id)->update(['active' => 0]);
        return redirect()->back()->with('message', 'Bạn đã ẩn categories thành công!');
    }
    public function showActiveCategories($id) {
        $this->model->where('id', $id)->update(['active' => 1]);
        return redirect()->back()->with('message', 'Bạn đã hiển thị categories thành công!');
    }
    public function editCategories($id, array $data) {
        $categories = $this->getById($id);
        if (! $categories) {
            return null;
        }
        $categories->name = $data['categories_name'];
        return $categories->update($data);
    }
    public function deleteCategories($id) {
        $categories = $this->getById($id);
        return $categories->delete($id);
    }
    public function deleteAllCategories(array $id) {
        $this->model->whereIn('id', $id)->delete();
    }

}
