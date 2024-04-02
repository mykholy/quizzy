<?php

namespace App\Http\Controllers\API\Admin\Teacher;


use App\Events\NewNotifyMessage;
use App\Models\Admin\Student;
use App\Models\Admin\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Chat;


class ChatTeacherAPIController extends AppBaseController
{
    public $student;
    public $teacher;

    public function __construct()
    {
        $this->middleware('auth:api-teacher');
        $this->student = Student::find(\request('student_id'));
        if (auth('api-teacher')->check()) {
            $teacher_id = auth('api-teacher')->id();
            $this->teacher = Teacher::find($teacher_id);
        }


    }


    public function directChats(Request $request)
    {

        $sorting = $request->input('sorting', 'desc');


        $conversations = Chat::conversations()->setParticipant($this->teacher)
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
        if(!$this->student)
            return $this->sendError('Student not found');

        $sorting = $request->input('sorting', 'desc');

        $conversation = Chat::conversations()->between( $this->teacher,$this->student);

        if (!$conversation)
            $conversation = Chat::makeDirect()->createConversation([$this->teacher,$this->student]);

        if ($request->input('mark_as_read'))
            Chat::conversation($conversation)->setParticipant($this->teacher)->readAll();

        $messages = Chat::conversation($conversation)->setParticipant($this->teacher)
            ->setPaginationParams(['sorting' => $sorting,
                'page' => \request('page', 1),
                'perPage' => 10
            ])
            ->getMessages();
        $unreadCount = Chat::conversation($conversation)->setParticipant($this->teacher)->unreadCount();

        return $this->sendResponse(
            [
                'unreadCount' => $unreadCount,
                'messages' => $messages,
            ],
            __('lang.api.updated', ['model' => __('models/teachers.singular')])
        );
    }

    public function send(Request $request)
    {
        if(!$this->student)
            return $this->sendError('Student not found');

        $type_messages = $request->input('type', 'text');
        $body = $request->body;

        $conversation = Chat::conversations()->between($this->teacher,$this->student);

        if (!$conversation)
            $conversation = Chat::makeDirect()->createConversation([$this->teacher,$this->student]);

        if ($type_messages == 'image') {
            $this->validate($request, ['body' => 'required|file']);
            $body = asset(uploadImage('chats', $body));
        }


        $message = Chat::message($body)
            ->type($type_messages)
            ->data(['notification_image' => $this->teacher->photo, 'title' => $this->teacher->name, 'type' => 'teacher'])
            ->from($this->teacher)
            ->to($conversation)
            ->send();

        $messageData = [
            'id' => $conversation->id,
            'type' => 'chat',
            'image' => optional($this->teacher)->photo,
//            'link' => route('chats.show',['student_id'=>$this->student->id,'type'=>'student']),
            'link' => '#',
            'title' => $this->teacher->name,
            'body' => $body,

        ];
        event(new NewNotifyMessage($messageData));

        $other_devices[]= $this->student->device_token;
        send_notification_FCM($other_devices,$this->teacher->name,$body,$this->teacher->id,'chat');


        return $this->sendResponse(
            $message,
            __('lang.api.updated', ['model' => __('models/teachers.singular')])
        );
    }


}
