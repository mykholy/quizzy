<?php

namespace App\Http\Controllers\API\Admin;


use App\Events\NewNotifyMessage;
use App\Models\Admin\Group;
use App\Models\Admin\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Chat;

/**
 * Class ChatAPIController
 * @package App\Http\Controllers\API\Driver
 */
class ChatGroupAPIController extends AppBaseController
{
    public $student;

    public function __construct()
    {
        $this->middleware('auth:api-student');
        if (auth('api-student')->check()) {
            $student_id = auth('api-student')->id();
            $this->student = Student::find($student_id);
        }


    }


    public function chat(Request $request)
    {
        $group = Group::with('students')->find(\request('group_id'));


        if (!$group)
            return $this->sendError('conversation not found');

        $conversation = Chat::conversations()->getById($group->conversation_id);

        if (!$conversation)
            return $this->sendError('conversation not found');

        $sorting = $request->input('sorting', 'desc');


        if ($request->input('mark_as_read'))
            Chat::conversation($conversation)->setParticipant($this->student)->readAll();

        $messages = Chat::conversation($conversation)->setParticipant($this->student)
            ->setPaginationParams(['sorting' => $sorting,
                'page' => \request('page', 1),
                'perPage' => 10
            ])
            ->getMessages();


        $unreadCount = Chat::conversation($conversation)->setParticipant($this->student)->unreadCount();

        return $this->sendResponse(
            [
                'unreadCount' => $unreadCount,
                'messages' => $messages,
            ],
            __('lang.api.updated', ['model' => __('models/students.singular')])
        );
    }

    public function send(Request $request)
    {

        $group = Group::with('students')->find(\request('group_id'));


        if (!$group)
            return $this->sendError('conversation not found');

        $conversation = Chat::conversations()->getById($group->conversation_id);
        if (!$conversation)
            return $this->sendError('conversation not found');

        $type_messages = $request->input('type', 'text');
        $body = $request->body;


        if ($type_messages == 'image') {
            $this->validate($request, ['body' => 'required|file']);
            $body = asset(uploadImage('chats', $body));
        }


        $message = Chat::message($body)
            ->type($type_messages)
            ->data(['notification_image' => $this->student->photo, 'title' => $this->student->name, 'type' => 'student'])
            ->from($this->student)
            ->to($conversation)
            ->send();

        $messageData = [
            'id' => $conversation->id,
            'type' => 'chat',
            'image' => optional($this->student)->photo,
//            'link' => route('chats.show',['student_id'=>$this->student->id,'type'=>'student']),
            'link' => '#',
            'title' => $this->student->name,
            'body' => $body,

        ];
        event(new NewNotifyMessage($messageData));
        $other_revices=$group->students()->whereNot('students.id',$this->student->id)->pluck('device_token')->toArray();

        send_notification_FCM($other_revices,$this->student->name,$body,$group->id,'group_chat');

        return $this->sendResponse(
            $message,
            __('lang.api.updated', ['model' => __('models/students.singular')])
        );
    }


}
