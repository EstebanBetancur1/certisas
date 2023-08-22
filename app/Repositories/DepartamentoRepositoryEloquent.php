<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DepartamentoRepository;
use App\Models\Departamento;
use App\Validators\DepartamentoValidator;

/**
 * Class DepartamentoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DepartamentoRepositoryEloquent extends BaseRepository implements DepartamentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Departamento::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
