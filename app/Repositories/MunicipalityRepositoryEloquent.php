<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MunicipalityRepository;
use App\Models\Municipality;
use App\Validators\MunicipalityValidator;

/**
 * Class MunicipalityRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MunicipalityRepositoryEloquent extends BaseRepository implements MunicipalityRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Municipality::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
