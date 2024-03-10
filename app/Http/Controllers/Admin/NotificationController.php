<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Student;
use App\Notifications\NewNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;


class NotificationController extends AppBaseController
{


    public function general()
    {
        return view('admin.notifications.index');

    }


    public function send(Request $request)
    {
        $users = Student::all();
        $NewNotification = array();
        $NewNotification['title'] = $request->title;
        $NewNotification['body'] = $request->body;
        $NewNotification['type'] = "notification";
        $NewNotification['id'] = null;
        Notification::send($users, new NewNotification($NewNotification));

        send_notification_FCM_Topic("general", $request->title, $request->body, null, 'notification');

        session()->flash('success', __('lang.send_successfully'));

        return redirect()->back();


    }


}
