<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TemplateItemRepository;
use App\Models\TemplateItem;
use App\Validators\TemplateItemValidator;

/**
 * Class TemplateItemRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TemplateItemRepositoryEloquent extends BaseRepository implements TemplateItemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TemplateItem::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
