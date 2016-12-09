<?php

namespace App\DataTables;

use App\Form;
use Yajra\Datatables\Services\DataTable;

class FormsDataTable extends DataTable
{
    protected $exportColumns = ['id', 'name', 'email', 'phone', 'message', 'type', 'created_at', 'created_at', 'active'];
    protected $printColumns = ['id', 'name', 'email', 'phone', 'message', 'type', 'created_at', 'created_at', 'active'];

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->setRowId(function ($form) {
                return 'arrayorder_' . $form->id;
            })
            ->addColumn('checkbox', function ($form) {
                return "<input type=\"checkbox\" name=\"item[]\" value=\"$form->id\"/>";
            })
            ->addColumn('types', function ($form) {
                return ($form->type ? Form::getFormType($form->type) : '-');
            })
            ->addColumn('active', function ($form) {
                if ($form->active == 0) {
                    return '<span class="label label-flat border-danger text-danger-600">CEVAPLANMADI</span>';
                } elseif ($form->active == 1) {
                    return '<span class="label label-flat border-success text-success-600">CEVAPLANDI</span>';
                }
            })
            ->addColumn('actions', function ($form) {
                return '<td class="text-center">
                <ul class="icons-list">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="' . route('admin.forms.edit', array('id' => $form->id)) . '"><i class="icon-cogs"></i> Düzenle</a></li>
                            <li><a class="confirm-btn" href="#" data-id="' . $form->id . '" data-token="' . csrf_token() . '"
                            data-url="' . route('admin.forms.destroy', array('id' => $form->id)) . '" data-title="' . $form->name . '"><i class="icon-cross2"></i> Sil</a></li>
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
        $query = Form::query();

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
        return 'forms_' . time();
    }
}
