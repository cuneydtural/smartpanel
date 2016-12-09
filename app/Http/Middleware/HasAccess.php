<?php

namespace App\Http\Middleware;

use App\Http\Controllers\PermissionController;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Closure;
use Illuminate\Http\Response;


class HasAccess
{

    /**
     * @param $request
     * @param Closure $next
     * @param null $value
     * @return mixed
     */
    public function handle($request, Closure $next, $value = null)
    {
        try {
            $user = \Sentinel::getUser();
        } catch (NotActivatedException $e) {
            $notify[] = ['message' => 'Lütfen giriş yapın!', 'alert' => 'error'];
            return redirect()->route('admin.login')->withNotify($notify);
        }

        if (!$value) $value = $request->route()->getName();

        if ($user && $permission = PermissionController::authCheck($value)) {
            if (!$user->hasAnyAccess(['superuser', $permission])) {
                if ($request->ajax()) {
                    return response()->json('Hata: Bu bölüme erişim yetkiniz bulunmuyor!', 403);
                } else {
                    $notify[] = ['message' => 'Üzgünüz! Bu bölüme erişim yetkiniz bulunmuyor!.', 'alert' => 'error'];
                    return redirect()->route('admin.dashboard.index')->withNotify($notify);
                }
            }
        }
        return $next($request);
    }

}
