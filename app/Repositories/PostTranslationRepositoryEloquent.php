<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PostTranslationRepository;
use App\Models\PostTranslation;
use App\Validators\PostTranslationValidator;

/**
 * Class PostTranslationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PostTranslationRepositoryEloquent extends BaseRepository implements PostTranslationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PostTranslation::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
