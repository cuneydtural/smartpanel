<?php

namespace App\DataTables;

use App\Category;
use Yajra\Datatables\Services\DataTable;

class CategoriesDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->setRowId(function ($category) {
                return 'arrayorder_' . $category->id;
            })
            ->addColumn('checkbox', function ($category) {
                return "<input type=\"checkbox\" name=\"item[]\" value=\"$category->id\"/>";
            })
            ->addColumn('parent_id', function ($category) {
                return '<a href="'. route('admin.categories.show', ['id' => $category->id]) .'" class="btn btn-primary btn-xs legitRipple"><i class="icon-tree6 position-left"></i> Alt Düzeyleri</a>';
            })
            ->addColumn('active', function ($category) {
                if ($category->active == 0) {
                    return '<span class="label label-flat border-danger text-danger-600">PASİF</span>';
                } elseif ($category->active == 1) {
                    return '<span class="label label-flat border-success text-success-600">AKTİF</span>';
                }
            })
            ->addColumn('actions', function ($category) {
                return '<td class="text-center">
                <ul class="icons-list">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="' . route('admin.categories.edit', array('id' => $category->id)) . '"><i class="icon-cogs"></i> Düzenle</a></li>
                            <li><a class="confirm-btn" data-id="' . $category->id . '" data-token="' . csrf_token() . '"
                            data-url="' . route('admin.categories.destroy', array('id' => $category->id)) . '" data-title="' . $category->name . '"><i class="icon-cross2"></i> Sil</a></li>
                            <li><a class="create-locale" data-id="' . $category->id . '"><i class="icon-plus2"></i> Dil Ekle</a></li>
                            <li><a class="index-locale" data-id="' . $category->id . '"><i class="icon-list3"></i> Dil Listeleri</a></li>
                        </ul>
                    </li>
                </ul>
            </td>';
            })->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $categories = Category::query();
        return $this->applyScopes($categories);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())->ajax()
            ->addAction()->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            // add your columns
            'created_at',
            'updated_at',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'categories_' . time();
    }
}
