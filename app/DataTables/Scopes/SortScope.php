<?php

namespace App\DataTables\Scopes;

use Yajra\Datatables\Contracts\DataTableScopeContract;

class SortScope implements DataTableScopeContract
{
    
    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function apply($query)
    {
        switch ($sort = session('sort')) {

            case 'list':
                return $query->orderBy('list_id', 'asc');
                break;
            case 'desc':
                return $query->orderBy('id', 'desc');
                break;
            case 'active':
                return $query->where('active', 1);
                break;
            case 'passive':
                return $query->where('active', 0);
                break;
            case 'all':
                return $query->orderBy('id', 'desc');
                break;
            default: null;
        }

        if (is_null($sort)) {
            return $query->orderBy('id', 'desc');
        }
    }
}
