<?php

namespace App\DataTables;

use App\Campaign;
use Yajra\Datatables\Services\DataTable;

class CampaignsDataTable extends DataTable
{

    protected $exportColumns = ['id', 'name', 'date_start', 'date_end', 'active', 'locale'];
    protected $printColumns = ['id', 'name', 'date_start', 'date_end', 'active', 'locale'];

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->setRowId(function ($campaign) {
                return 'arrayorder_' . $campaign->id;
            })
            ->addColumn('checkbox', function ($campaign) {
                return "<input type=\"checkbox\" name=\"item[]\" value=\"$campaign->id\"/>";
            })->addColumn('active', function ($campaign) {
                if ($campaign->active == 0) {
                    return '<span class="label label-flat border-danger text-danger-600">PASİF</span>';
                } elseif ($campaign->active == 1) {
                    return '<span class="label label-flat border-success text-success-600">AKTİF</span>';
                }
            })
            ->addColumn('actions', function ($campaign) {
                return '<td class="text-center">
                <ul class="icons-list">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="' . route('admin.campaigns.edit', array('id' => $campaign->id)) . '"><i class="icon-cogs"></i> Düzenle</a></li>
                            <li><a class="confirm-btn" href="#" data-id="' . $campaign->id . '" data-token="' . csrf_token() . '"
                            data-url="' . route('admin.campaigns.destroy', array('id' => $campaign->id)) . '" data-title="' . $campaign->name . '"><i class="icon-cross2"></i> Sil</a></li>
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
        $query = Campaign::query();
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
        return 'campaigns_' . time();
    }
}
