<?php

namespace App\Http\Controllers\API\Admin;


use App\Events\NewNotifyMessage;
use App\Models\Admin\Student;
use App\Models\Admin\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Chat;


class ChatAPIController extends AppBaseController
{
    public $student;
    public $teacher;

    public function __construct()
    {
        $this->middleware('auth:api-student');
        $this->teacher = Teacher::find(\request('teacher_id'));
        if (auth('api-student')->check()) {
            $student_id = auth('api-student')->id();
            $this->student = Student::find($student_id);
        }


    }


    public function directChats(Request $request)
    {

        $sorting = $request->input('sorting', 'desc');


        $conversations = Chat::conversations()->setParticipant($this->student)
            ->isDirect()
            ->setPaginationParams(['sorting' => $sorting,
                'page' => \request('page', 1),
                'perPage' => 10
            ])
            ->get();

        return $this->sendResponse(
            $conversations,
            __('lang.api.updated', ['model' => __('models/conversations.singular')])
        );
    }
    public function chat(Request $request)
    {
        if(!$this->teacher)
            return $this->sendError('Teacher not found');

        $sorting = $request->input('sorting', 'desc');

        $conversation = Chat::conversations()->between($this->student, $this->teacher);

        if (!$conversation)
            $conversation = Chat::makeDirect()->createConversation([$this->student, $this->teacher]);

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
        if(!$this->teacher)
            return $this->sendError('Teacher not found');

        $type_messages = $request->input('type', 'text');
        $body = $request->body;

        $conversation = Chat::conversations()->between($this->student, $this->teacher);

        if (!$conversation)
            $conversation = Chat::makeDirect()->createConversation([$this->student, $this->teacher]);

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
        $other_devices[]= $this->teacher->device_token;
        send_notification_FCM($other_devices,$this->student->name,$body,$this->student->id,'chat');

        return $this->sendResponse(
            $message,
            __('lang.api.updated', ['model' => __('models/students.singular')])
        );
    }


}
