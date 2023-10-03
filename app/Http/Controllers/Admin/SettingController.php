<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;


class SettingController extends AppBaseController
{



    public function general()
    {
        return view('admin.settings.general.index');

    }


    public function updateSettings(Request $request)
    {
        $type = $request->input('type_page_setting');

        if ($type == "general") {
            $request_general = $request->except('type_page_setting', '_token');

            $request_general = collect($request_general)->filter(function ($item, $key) {

                return $item != null;
            })->toArray();
            if ($request->file('logo'))
                $request_general['logo'] = uploadImage('logo', $request->logo);
            setting($request_general)->save();
        }


        session()->flash('success', __('lang.updated_successfully'));

        return redirect()->back();


    }


}
