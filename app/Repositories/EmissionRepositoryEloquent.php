<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EmissionRepository;
use App\Models\Emission;
use App\Validators\EmissionValidator;

/**
 * Class EmissionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EmissionRepositoryEloquent extends BaseRepository implements EmissionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Emission::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
