<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SectionalRepository;
use App\Models\Sectional;
use App\Validators\SectionalValidator;

/**
 * Class SectionalRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SectionalRepositoryEloquent extends BaseRepository implements SectionalRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Sectional::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
