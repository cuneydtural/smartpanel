<?php

namespace App\Http\Controllers;

use App;
use App\Setting;
use App\Http\Requests\Admin\Settings\UpdateRequest;
use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use Image;
use Illuminate\Support\Facades\Redirect;

class SettingController extends Controller
{

    /**
     * @return mixed
     */
    public function index()
    {
        $settings = Setting::where('locale', $this->locale)->first();
        if(!$settings) {
            $notify[] = ['message' => 'İlgili sayfa bulunamadı!', 'alert' => 'danger'];
            return redirect()->route('admin.dashboard.index')->withNotify($notify);
        }
        return view('admin.settings.edit', compact('settings'));
    }

    /**
     * @param UpdateRequest $request
     * @param $id
     * @return mixed
     */
    public function update(UpdateRequest $request, $id)
    {
        // Cache Temizle
        Cache::flush();

        $settings = Setting::findorFail($id);
        $settings->update($request->except('logo', 'locale', 'mail_password'));

        if($request->has('mail_password')) {
            $settings->mail_password = $request->input('mail_password');
            $settings->save();
        }

        if($request->hasFile('image')) {

            $image = UploadController::imageUpload($request, [
                'title' => $request->input('title'),
                'source_type' => 'settings.logo',
                'size' => [200,140]
            ]);

            if (isset($image['url'])) {
                $settings->logo = $image['url'];
                $settings->save();
                $notify[] = ['message' => 'Fotoğraf yüklendi', 'alert' => 'success'];
            } else {
                $notify[] = ['message' => $image['error_message'], 'alert' => 'danger'];
            }
        }

        $notify[] = ['message' => 'Site ayarları güncellendi', 'alert' => 'success'];

        return Redirect::back()->withNotify($notify);
    }

}
