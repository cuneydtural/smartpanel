<?php

namespace App\DataTables\Scopes;

use Yajra\Datatables\Contracts\DataTableScopeContract;

class CategoryScope implements DataTableScopeContract
{

    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function apply($query)
    {
        $request = app('request');

        switch ($sort = session('sort')) {

            case 'list':
                return $query->where('parent_id', $request->get('parent_id'))->orderBy('list_id', 'asc');
                break;
            case 'desc':
                return $query->where('parent_id', $request->get('parent_id'))->orderBy('id', 'asc');
                break;
            case 'active':
                return $query->where('active', 1)->where('parent_id', $request->get('parent_id'));
                break;
            case 'passive':
                return $query->where('active', 0)->where('parent_id', $request->get('parent_id'));
                break;
            case 'all':
                return $query->where('parent_id', $request->get('parent_id'))->orderBy('id', 'desc');
                break;
            default: null;
        }

        if (is_null($sort)) {
            return $query->where('parent_id', $request->get('parent_id'))->orderBy('id', 'desc');
        }

    }
}
