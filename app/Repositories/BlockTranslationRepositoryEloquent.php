<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\BlockTranslationRepository;
use App\Models\BlockTranslation;
use App\Validators\BlockTranslationValidator;

/**
 * Class BlockTranslationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BlockTranslationRepositoryEloquent extends BaseRepository implements BlockTranslationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BlockTranslation::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
