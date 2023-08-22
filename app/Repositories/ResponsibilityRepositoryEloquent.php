<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ResponsibilityRepository;
use App\Models\Responsibility;
use App\Validators\ResponsibilityValidator;

/**
 * Class ResponsibilityRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ResponsibilityRepositoryEloquent extends BaseRepository implements ResponsibilityRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Responsibility::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
