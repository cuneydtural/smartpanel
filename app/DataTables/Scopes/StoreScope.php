<?php

namespace App\DataTables\Scopes;

use Yajra\Datatables\Contracts\DataTableScopeContract;

class StoreScope implements DataTableScopeContract
{
    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     * 1) Satış Noktaları
     * 2) Dağıtım Noktaları
     * 3) Servis
     */
    public function apply($query)
    {
        switch ($sort = session('sort')) {

            case 1:
                return $query->where('category', 1);
                break;
            case 2:
                return $query->where('category', 2);
                break;
            case 3:
                return $query->where('category', 3);
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
