<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RequestRepository;
use App\Models\Request;
use App\Validators\RequestValidator;

/**
 * Class RequestRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RequestRepositoryEloquent extends BaseRepository implements RequestRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Request::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
