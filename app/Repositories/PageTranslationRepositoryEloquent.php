<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PageTranslationRepository;
use App\Models\PageTranslation;
use App\Validators\PageTranslationValidator;

/**
 * Class PageTranslationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PageTranslationRepositoryEloquent extends BaseRepository implements PageTranslationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PageTranslation::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
