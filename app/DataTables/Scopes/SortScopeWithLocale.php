<?php

namespace App\DataTables\Scopes;

use Illuminate\Support\Facades\App;
use Yajra\Datatables\Contracts\DataTableScopeContract;

class SortScopeWithLocale implements DataTableScopeContract
{
    public $locale;

    /**
     * SortScopeWithLocale constructor.
     */
    public function __construct()
    {
        $this->locale = App::getLocale();
    }

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
                return $query->where('locale', $this->locale)->orderBy('list_id', 'asc');
                break;
            case 'desc':
                return $query->where('locale', $this->locale)->orderBy('id', 'desc');
                break;
            case 'active':
                return $query->where('locale', $this->locale)->where('active', 1);
                break;
            case 'passive':
                return $query->where('locale', $this->locale)->where('active', 0);
                break;
            case 'all':
                return $query->where('locale', $this->locale)->orderBy('id', 'desc');
                break;
            default: null;
        }

        if (is_null($sort)) {
            return $query->where('locale', $this->locale)->orderBy('id', 'desc');
        }
    }
}
