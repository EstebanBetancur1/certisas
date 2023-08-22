<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CompanyResponsibilityRepository;
use App\Models\CompanyResponsibility;
use App\Validators\CompanyResponsibilityValidator;

/**
 * Class CompanyResponsibilityRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CompanyResponsibilityRepositoryEloquent extends BaseRepository implements CompanyResponsibilityRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CompanyResponsibility::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
