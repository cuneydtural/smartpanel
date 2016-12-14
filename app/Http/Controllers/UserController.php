<?php

namespace App\Http\Controllers;

use App\City;
use App\DataTables\Scopes\UserScope;
use App\DataTables\UsersDataTable;
use App;
use App\Helpers\Helper;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function data(UsersDataTable $dataTable)
    {
        return $dataTable->addScope(new UserScope)->render('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles =  Role::all();
        $permissions = PermissionController::getPermissions();
        return view('admin.users.create', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
        ]);

        if ($validator->fails()) {
            $notify[] = ['message' => 'Kullanıcı ekleme sırasında hata oluştu.', 'alert' => 'error'];
        } else {
            $user = User::create(
                [
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                    'active' => $request->input('active'),
                    'image' => ''
                ]
            );

            if($request->has('image')) {
                $user->image = App\Helpers\Helper::getFileName($request->input('image'));
                $user->save();
            }

            if($request->has('permissions')) {
                $permissions = null;
                foreach($request->input('permissions') as $perm) {
                    $permissions[$perm] = true;
                }

                $user->permissions = $permissions;
                $user->save();
            }

            if($request->has('roles')) {
                $user->roles()->attach($request->input('roles'));
            }

            $notify[] = ['message' => 'Yeni kullanıcı eklendi', 'alert' => 'success'];
        }
        return Redirect::route('admin.users.index')->withNotify($notify);
    }


    /**
     * @param $sort
     * @param Request $request
     * @return mixed
     */
    public function show($sort, Request $request)
    {
        $list = ['sort', 'list', 'desc', 'active', 'passive', 'all'];

        if (!in_array($sort, $list)) {
            return redirect()->route('admin.users.index');
        }

        if($sort == 'sort') {
            if($request->has('arrayorder')) {
                $i=0;
                $array_order = $request->input('arrayorder');
                foreach($array_order as $user_id) {
                    User::where("id", $user_id)->update(['list_id' => $i]);
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
            return redirect()->route('admin.users.index')->withNotify($notify);
        } else {
            return redirect()->route('admin.users.index');
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
        $user = User::with('roles')->findOrFail($id);
        $roles =  Role::all();
        $permissions = PermissionController::getPermissions();
        return view('admin.users.create', compact('user', 'roles', 'permissions'));
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

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,'.$id
        ]);

        if ($validator->fails()) {
            $notify[] = ['message' => 'Kullanıcı bilgileri güncellemedi!', 'alert' => 'error'];
        } else {
            $user = User::findorFail($id);
            $user->update($request->except(['password', 'image']));

            if($request->has('image')) {
                $user->image = Helper::getFileName($request->input('image'));
                $user->save();
            }

            if($request->has('password')) {
                $user->update(['password' => $request->input('password')]);
                $notify[] = [
                    'message' => 'Kullanıcı şifresi değiştirildi',
                    'alert' => 'success'];
            }

            if($request->has('roles')) {
                $user->roles()->detach();
                $user->roles()->attach($request->input('roles'));
            }

            if($request->has('permissions')) {
                $permissions = $request->input('permissions');
                $new_perm = null;
                $old_perm = $user->permissions;

                foreach($permissions as $perm) {
                    $new_perm[$perm] = true;
                }

                foreach($old_perm as $key => $value) {
                    $old_perm[$key] = false;
                }

                $user->permissions = array_merge($old_perm, $new_perm);
                $user->save();
            }

            $notify[] = [
                'message' => 'Kullanıcı bilgileri güncellendi',
                'alert' => 'success'];
        }
            return Redirect::back()->withNotify($notify);
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findorFail($id);
        $user->delete();

        $notify[] = [
            'message' => 'Kullanıcı silindi',
            'alert' => 'success'];

        Session::flash('notify', $notify);
        return route('admin.users.index');
    }


    public function multiple(Request $request) {

        $status = $request->input('status');
        $item_ids = $request->input('item_id');

        if($status && $item_ids) {

            parse_str($item_ids, $item_arr);
            $users = User::find($item_arr['item']);

            switch ($status) {
                case 'passive':
                    $active = 0;
                    $notify = 'Kullanıcı pasif edilmiştir.';
                    break;
                case 'active':
                    $active = 1;
                    $notify = 'Kullanıcı aktif edilmiştir.';
                    break;
                case 'destroy':
                    $active = null;
                    $notify = 'Kullanıcı silinmiştir.';
            }

            foreach ($users as $user) {
                if (is_null($active)) {
                    $user->delete();
                } else {
                    $user->active = $active;
                    $user->save();
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => $notify
            ]);

        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Üzgünüz! İşlem yapılamadı!',
            ]);
        }

    }
}
