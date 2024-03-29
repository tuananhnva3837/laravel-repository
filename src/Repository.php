<?php

namespace AnhAiT\LaravelRepository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

abstract class Repository implements RepositoryInterface
{
    private $app;

    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    abstract public function model();

    public function all($columns = array('*'))
    {
        return $this->model->get($columns);
    }

    public function list($orderByColumn, $orderBy = 'desc', $with = [], $columns = ['*'])
    {
        return $this->model->with($with)
                           ->orderBy($orderByColumn, $orderBy)
                           ->get($columns);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id, $attribute = 'id')
    {
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    public function findBy(string $field, mixed $value, $columns = array('*'))
    {
        return $this->model->where($field, $value)
                           ->select($columns)
                           ->first();
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }
}
