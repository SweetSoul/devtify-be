<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Illuminate\Http\Request;

class JitsiMeetingController extends Controller
{
    public static function createMeeting(Workshop $workshop)
    {
        $meetingId = strtolower(preg_replace('/\s+/', '_', $workshop->title) . '-' . uniqid());
        return "https://meet.jit.si/{$meetingId}";
    }
}
