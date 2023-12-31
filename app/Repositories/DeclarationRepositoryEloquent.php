<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DeclarationRepository;
use App\Models\Declaration;
use App\Validators\DeclarationValidator;

/**
 * Class DeclarationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DeclarationRepositoryEloquent extends BaseRepository implements DeclarationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Declaration::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
