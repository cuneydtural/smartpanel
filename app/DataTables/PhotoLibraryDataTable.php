<?php

namespace App\DataTables;

use App\File as Files;
use Yajra\Datatables\Services\DataTable;

class PhotoLibraryDataTable extends DataTable
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
            ->setRowId(function ($files) {
                return 'arrayorder_' . $files->id;
            })
            ->addColumn('checkbox', function ($files) {
                return "<input type=\"checkbox\" name=\"item[]\" value=\"$files->id\"/>";
            })
            ->addColumn('preview', function ($files) {
                return '<a href="'.url($files->path.'/'.$files->name).'" data-popup="lightbox">
					  <img src="'.url($files->thumb_path.'/'.$files->name).'" alt="" class="img-rounded img-preview">
				        </a>';
            })
            ->addColumn('info', function ($files) {
                return '<ul class="list-condensed list-unstyled no-margin">
				                        	<li><span class="text-semibold">Boyut:</span> '.$files->size.'</li>
				                        	<li><span class="text-semibold">Format:</span> '.$files->mime.'</li>
			                        	</ul>';
            })
            ->addColumn('active', function ($files) {
                if ($files->active == 0) {
                    return '<span class="label label-flat border-danger text-danger-600">PASİF</span>';
                } elseif ($files->active == 1) {
                    return '<span class="label label-flat border-success text-success-600">AKTİF</span>';
                }
            })
            ->addColumn('actions', function ($files) {
                return '<td class="text-center">
                <ul class="icons-list">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a class="confirm-btn" href="#" data-id="' . $files->id . '" data-token="' . csrf_token() . '"
                            data-url="' . route('admin.photo-library.destroy', array('id' => $files->id)) . '" data-title="' . $files->name . '"><i class="icon-cross2"></i>Fotoğrafı sil</a></li>
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
        $query = Files::query();
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
                    ->addAction()
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
        return 'photolibraries_' . time();
    }
}
