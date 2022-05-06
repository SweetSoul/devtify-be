<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FeedBackController extends Controller
{
    public function send(Request $request): Response
    {
        $feedback = $request->get("feedback");
        $feedbackPage = $request->get("feedbackFrom");

        $from = "feedbacks@devtify.com";
        $to = env("FEEDBACK_MAIL_RECIPIENT");
        $subject = "Feed back for - $feedbackPage";
        $headers = "From:" . $from;
        $status = mail($to,$subject,$feedback, $headers) ? 'send' : 'fail';

        return new Response(json_encode(['status' => $status ]));
    }
}
