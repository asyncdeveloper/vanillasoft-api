<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomEmailRequest;
use App\Mail\SendCustomEmail;
use App\Models\CustomEmail;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class CustomEmailController extends Controller
{

    public function store(CustomEmailRequest $request)
    {
        $data = $request->validated();

        $data->each(function($datum) {
            $datum['attachments'] = $datum['attachments'] ?? [];
            $customEmail = CustomEmail::create($datum);
            Mail::to($datum['email'])->queue(new SendCustomEmail($customEmail));
        });
        return response()->json([ 'message' => 'Emails Sent successfully' ],Response::HTTP_ACCEPTED);
    }

    public function index()
    {
        return response()->json([
            'message' => 'Emails Fetched successfully',
            'data' => CustomEmail::paginate()
        ]);
    }


}
