<?php

namespace App\DataTables;

use App\Slide;
use Yajra\Datatables\Services\DataTable;

class SlidesDataTable extends DataTable
{

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables->eloquent($this->query())
            ->setRowId(function ($slide) {
                return 'arrayorder_' . $slide->id;
            })
            ->addColumn('checkbox', function ($slide) {
                return "<input type=\"checkbox\" name=\"item[]\" value=\"$slide->id\"/>";
            })
            ->addColumn('preview', function ($slide) {
                return '<img src="'.url('photos/thumbs/'.$slide->photo).'" alt="" class="img-rounded img-preview">';
            })
            ->addColumn('active', function ($slide) {
                if ($slide->active == 0) {
                    return '<span class="label label-flat border-danger text-danger-600">PASİF</span>';
                } elseif ($slide->active == 1) {
                    return '<span class="label label-flat border-success text-success-600">AKTİF</span>';
                }
            })
            ->addColumn('actions', function ($slide) {
                return '<td class="text-center">
                    <ul class="icons-list">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="' . route('admin.slides.edit', array('id' => $slide->id)) . '"><i class="icon-cogs"></i> Düzenle</a></li>
                                    <li><a class="confirm-btn" href="#" data-id="' . $slide->id . '" data-token="' . csrf_token() . '"
                                    data-url="' . route('admin.slides.destroy', array('id' => $slide->id)) . '" data-title="' . $slide->title . '"><i class="icon-cross2"></i> Sil</a></li>
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
        $query = Slide::query();
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
            ->columns($this->getColumns())->ajax()->addAction(['width' => '80px'])
            ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'roles_' . time();
    }
}
