<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements RepositoryInterface
{
    // Model tương tác
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    // Lấy model tương ứng
    abstract public function getModel();

    /**
     * @throws BindingResolutionException
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }
    public function getAll()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        $result = $this->model->find($id);

        return $result;
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    public function paginate(int $perPage)
    {
        $paginator = $this->model->paginate($perPage);

        return $this->formatPaginator($paginator);
    }

    protected function formatPaginator(LengthAwarePaginator $paginator)
    {
        $pagination = [
            'total' => $paginator->total(),
            'perPage' => $paginator->perPage(),
            'currentPage' => $paginator->currentPage(),
            'lastPage' => $paginator->lastPage(),
            'previousPageUrl' => $paginator->previousPageUrl(),
            'nextPageUrl' => $paginator->nextPageUrl(),
            'items' => $paginator->items(),
        ];

        return $pagination;
    }
}
