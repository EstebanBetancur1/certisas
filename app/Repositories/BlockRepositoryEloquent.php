<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\BlockRepository;
use App\Models\Block;
use App\Validators\BlockValidator;

/**
 * Class BlockRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BlockRepositoryEloquent extends BaseRepository implements BlockRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Block::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
