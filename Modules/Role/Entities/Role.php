<?php

namespace Modules\Role\Entities;

use Spatie\Permission\Models\Role as SpatieRole;
use Kyslik\ColumnSortable\Sortable;

class Role extends SpatieRole
{
    use Sortable;
    
    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'guard_name',
    ];

    /**
     * @var int
     */
    protected $perPage = 20;

    /**
     * @var array|string[]
     */
    protected array $sortable = [
        'id',
        'name',
    ];
}
