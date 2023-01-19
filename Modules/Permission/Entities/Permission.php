<?php

namespace Modules\Permission\Entities;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Kyslik\ColumnSortable\Sortable;

class Permission extends SpatiePermission
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
