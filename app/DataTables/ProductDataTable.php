<?php

namespace App\DataTables;

use App\Category;
use App\Product;
use Yajra\Datatables\Services\DataTable;

class ProductDataTable extends DataTable
{

    protected $exportColumns = ['id', 'name', 'quantity'];
    protected $printColumns = ['id', 'name', 'quantity'];

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query()->with('categories'))
            ->setRowId(function ($product) {
                return 'arrayorder_' . $product->id;
            })
            ->addColumn('checkbox', function ($product) {
                return "<input type=\"checkbox\" name=\"item[]\" value=\"$product->id\"/>";
            })
            ->addColumn('categories', function ($product) {
                return ($product->categories ? Category::getLocaleCategories($product->categories) : '-');
            })
            ->addColumn('active', function ($product) {
                if ($product->active == 0) {
                    return '<span class="label label-flat border-danger text-danger-600">PASİF</span>';
                } elseif ($product->active == 1) {
                    return '<span class="label label-flat border-success text-success-600">AKTİF</span>';
                }
            })
            ->addColumn('actions', function ($product) {
                return '<td class="text-center">
                <ul class="icons-list">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="' . route('admin.products.edit', array('id' => $product->id)) . '"><i class="icon-cogs"></i> Düzenle</a></li>
                            <li><a class="confirm-btn" href="#" data-id="' . $product->id . '" data-token="' . csrf_token() . '"
                            data-url="' . route('admin.products.destroy', array('id' => $product->id)) . '" data-title="' . $product->name . '"><i class="icon-cross2"></i> Sil</a></li>
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
        $query = Product::query();
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->ajax('')
                    ->addAction(['width' => '80px'])
                    ->parameters($this->getBuilderParameters());
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
        return 'products_' . time();
    }
}
