<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CompanyActivityRepository;
use App\Models\CompanyActivity;
use App\Validators\CompanyActivityValidator;

/**
 * Class CompanyActivityRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CompanyActivityRepositoryEloquent extends BaseRepository implements CompanyActivityRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CompanyActivity::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
