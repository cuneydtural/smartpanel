<?php

namespace App\DataTables;

use App\Subscriber;
use Yajra\Datatables\Services\DataTable;

class SubscriberDataTable extends DataTable
{

    protected $exportColumns = ['id', 'name', 'email', 'created_at', 'updated_at', 'active'];
    protected $printColumns = ['id', 'name', 'email', 'created_at', 'updated_at', 'active'];

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->setRowId(function ($subscriber) {
                return 'arrayorder_' . $subscriber->id;
            })
            ->addColumn('checkbox', function ($subscriber) {
                return "<input type=\"checkbox\" name=\"item[]\" value=\"$subscriber->id\"/>";
            })->addColumn('active', function ($subscriber) {
                if ($subscriber->active == 0) {
                    return '<span class="label label-flat border-danger text-danger-600">PASİF</span>';
                } elseif ($subscriber->active == 1) {
                    return '<span class="label label-flat border-success text-success-600">AKTİF</span>';
                }
            })
            ->addColumn('actions', function ($subscriber) {
                return '<td class="text-center">
                <ul class="icons-list">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="' . route('admin.subscribers.edit', array('id' => $subscriber->id)) . '"><i class="icon-cogs"></i> Düzenle</a></li>
                            <li><a class="confirm-btn" href="#" data-id="' . $subscriber->id . '" data-token="' . csrf_token() . '"
                            data-url="' . route('admin.subscribers.destroy', array('id' => $subscriber->id)) . '" data-title="' . $subscriber->name . '"><i class="icon-cross2"></i> Sil</a></li>
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
        $query = Subscriber::query();
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
        return 'subscribers_' . time();
    }
}
