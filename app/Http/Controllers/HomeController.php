<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class HomeController extends Controller
{
    //
    public function sendEmailManually()
    {
        $recipient = 'kthirumal690@gmail.com';//Replace with actual recipient's email 
        $subject = 'Custom subject' ;
        $body = 'this is the body of the email. you can include HTMl here if needed.';

        Mail::raw($body, function(message $message) use ($recipient, $subject){
            $message->to($recipient);
            $message->subject($subject);
            // You can add attachments or other options here if needed
        });

        return "Email sent successfully!";
    }
}