<?php

namespace App\DataTables;

use App\Article;
use App\Category;
use App\User;
use Yajra\Datatables\Services\DataTable;

class ArticlesDataTable extends DataTable
{

    protected $exportColumns = ['id', 'title', 'desc', 'keywords', 'created_at', 'updated_at'];
    protected $printColumns = ['id', 'title', 'desc', 'keywords', 'created_at', 'updated_at'];

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query()->with('categories'))
            ->setRowId(function ($article) {
                return 'arrayorder_' . $article->id;
            })
            ->addColumn('checkbox', function ($article) {
                return "<input type=\"checkbox\" name=\"item[]\" value=\"$article->id\"/>";
            })
            ->addColumn('categories', function ($article) {
                return ($article->categories ? Category::getLocaleCategories($article->categories) : '-');
            })
            ->addColumn('active', function ($article) {
                if ($article->active == 0) {
                    return '<span class="label label-flat border-danger text-danger-600">PASİF</span>';
                } elseif ($article->active == 1) {
                    return '<span class="label label-flat border-success text-success-600">AKTİF</span>';
                }
            })
            ->addColumn('actions', function ($article) {
                return '<td class="text-center">
                <ul class="icons-list">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="' . route('admin.articles.edit', array('id' => $article->id)) . '"><i class="icon-cogs"></i> Düzenle</a></li>
                            <li><a class="confirm-btn" href="#" data-id="' . $article->id . '" data-token="' . csrf_token() . '"
                            data-url="' . route('admin.articles.destroy', array('id' => $article->id)) . '" data-title="' . $article->title . '"><i class="icon-cross2"></i> Sil</a></li>
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
        $query = Article::query();
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
        return 'articles_' . time();
    }
}
