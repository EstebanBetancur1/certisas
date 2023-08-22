<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EntityRepository;
use App\Models\Entity;
use App\Validators\EntityValidator;

/**
 * Class EntityRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EntityRepositoryEloquent extends BaseRepository implements EntityRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Entity::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
