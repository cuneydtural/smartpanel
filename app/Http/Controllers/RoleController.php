<?php

namespace App\Http\Controllers;

use App\DataTables\RolesDataTable;
use App\DataTables\Scopes\RoleScope;
use App\Helpers\Helper;
use App\Role;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles =  Sentinel::getRoleRepository()->all();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * @param RolesDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function data(RolesDataTable $dataTable)
    {
        return $dataTable->addScope(new RoleScope)->render('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = PermissionController::getPermissions();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('permissions')) {

            $permissions = $request->input('permissions');
            $p = null;

            foreach($permissions as $perm) {
                $p[$perm] = true;
            }

            $role = Sentinel::getRoleRepository()->createModel()->create([
                'name' => $request->input('name'),
                'slug' => Helper::slug($request->input('name')),
                'permissions' => $p
            ]);

            $notify[] = ['message' => 'Yeni rol eklendi', 'alert' => 'success'];
            return Redirect::route('admin.roles.index')->withNotify($notify);

        } else {

            $notify[] = ['message' => 'En az bir yetki seçmelisiniz!', 'alert' => 'danger'];
            return Redirect::back()->withNotify($notify)->withInput();
        }

    }


    /**
     * @param $sort
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($sort, Request $request)
    {
        $list = ['sort', 'list', 'desc', 'active', 'passive', 'all'];

        if (!in_array($sort, $list)) {
            return redirect()->route('admin.roles.index');
        }

        if($sort == 'sort') {
            if($request->has('arrayorder')) {
                $i=0;
                $array_order = $request->input('arrayorder');
                foreach($array_order as $role_id) {
                    Role::where("id", $role_id)->update(['list_id' => $i]);
                    $i++;
                }
                return response()->json([
                    'status' => 'success',
                    'message' => 'Sıralama değiştirildi.'
                ]);
            }
        } elseif($sort) {
            Session::put('sort', $sort);
            $notify[] = ['message' => 'Filtreleme seçeneği değiştirildi', 'alert' => 'success'];
            return redirect()->route('admin.roles.index')->withNotify($notify);
        } else {
            return redirect()->route('admin.roles.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permissions = PermissionController::getPermissions();
        $role = Sentinel::findRoleById($id);
        return view('admin.roles.create', compact('permissions', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if($request->has('permissions')) {

            $role = Sentinel::findRoleById($id);
            $old = $role->permissions;
            $permissions = null;

            foreach ($request->input('permissions') as $perm) {
                $permissions[$perm] = true;
            }

            foreach($old as $key => $val) {
                $old[$key] = false;
            }

            $permissions = array_merge($old, $permissions);

            $role->name = $request->input('name');
            $role->permissions = $permissions;
            $role->slug = str_slug($request->input('name'));
            $role->save();

            $notify[] = ['message' => 'Rol güncellendi', 'alert' => 'success'];
            return Redirect::back()->withNotify($notify);
        }
        else {
            $notify[] = ['message' => 'En az bir yetki seçmelisiniz!', 'alert' => 'danger'];
            return Redirect::back()->withNotify($notify);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Sentinel::findRoleById($id);
        $role->delete();

        $notify[] = ['message' => 'Rol silindi!', 'alert' => 'danger'];
        Session::flash('notify', $notify);

        return route('admin.roles.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function multiple(Request $request) {

        $status = $request->input('status');
        $item_ids = $request->input('item_id');

        if($status && $item_ids) {

            parse_str($item_ids, $item_arr);
            $roles = Role::find($item_arr['item']);

            switch ($status) {
                case 'passive':
                    $active = 0;
                    $notify = 'Rol pasif edilmiştir.';
                    break;
                case 'active':
                    $active = 1;
                    $notify = 'Rol aktif edilmiştir.';
                    break;
                case 'destroy':
                    $active = null;
                    $notify = 'Rol silinmiştir.';
            }

            foreach ($roles as $role) {
                if (is_null($active)) {
                    $role->delete();
                } else {
                    $role->active = $active;
                    $role->save();
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => $notify
            ]);

        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Üzgünüz! İşlem yapılamadı',
            ]);
        }

    }
}
