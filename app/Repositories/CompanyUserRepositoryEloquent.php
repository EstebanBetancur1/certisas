<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CompanyUserRepository;
use App\Models\CompanyUser;
use App\Validators\CompanyUserValidator;

/**
 * Class CompanyUserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CompanyUserRepositoryEloquent extends BaseRepository implements CompanyUserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CompanyUser::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
