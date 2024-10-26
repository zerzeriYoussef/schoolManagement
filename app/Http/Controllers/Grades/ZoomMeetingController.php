<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jubaer\Zoom\Facades\Zoom;

class ZoomMeetingController extends Controller
{
    public function createMeeting(Request $request)
    {
        // Validate request data if necessary
        $request->validate([
            'agenda' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'start_time' => 'required|date',
        ]);

        // Create the Zoom meeting
        $meeting = Zoom::createMeeting([
            "agenda" => $request->input('agenda'),
            "topic" => $request->input('topic'),
            "type" => 2, // scheduled meeting
            "duration" => 60, // in minutes
            "timezone" => 'Asia/Dhaka', // or set based on user preference
            "password" => '123456', // optional password
            "start_time" => $request->input('start_time'), // required start time
            "settings" => [
                'join_before_host' => false,
                'host_video' => true,
                'participant_video' => false,
                'mute_upon_entry' => true,
                'waiting_room' => true,
                'audio' => 'both',
                'auto_recording' => 'none',
                'approval_type' => 0, // Automatically Approve
            ],
        ]);

        // Return the created meeting details or redirect as needed
        return response()->json([
            'message' => 'Zoom meeting created successfully!',
            'meeting' => $meeting,
        ]);
    }
}
