<?php

namespace App\DataTables;

use App\User;
use Yajra\Datatables\Services\DataTable;

class UsersDataTable extends DataTable
{


    protected $exportColumns = ['id', 'first_name', 'last_name', 'email', 'created_at', 'updated_at', 'active'];
    protected $printColumns = ['id', 'first_name', 'last_name', 'email', 'created_at', 'updated_at', 'active'];

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->setRowId(function ($user) {
                return 'arrayorder_' . $user->id;
            })
            ->addColumn('checkbox', function ($user) {
                return "<input type=\"checkbox\" name=\"item[]\" value=\"$user->id\"/>";
            })
            ->editColumn('first_name', function ($user) {
                return $user->first_name . ' ' . $user->last_name;
            })->addColumn('active', function ($user) {
                if ($user->active == 0) {
                    return '<span class="label label-flat border-danger text-danger-600">PASİF</span>';
                } elseif ($user->active == 1) {
                    return '<span class="label label-flat border-success text-success-600">AKTİF</span>';
                }
            })
            ->addColumn('actions', function ($user) {
                return '<td class="text-center">
                <ul class="icons-list">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="' . route('admin.users.edit', array('id' => $user->id)) . '"><i class="icon-cogs"></i> Düzenle</a></li>
                            <li><a class="confirm-btn" href="#" data-id="' . $user->id . '" data-token="' . csrf_token() . '"
                            data-url="' . route('admin.users.destroy', array('id' => $user->id)) . '" data-title="' . $user->first_name . ' '.$user->last_name. '"><i class="icon-cross2"></i> Sil</a></li>
                        </ul>
                    </li>
                </ul>
            </td>';
            })->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $users = User::query();
        return $this->applyScopes($users);
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
    private function getColumns()
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
        return 'users_' . time();
    }
}

