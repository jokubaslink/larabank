<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GPTController extends Controller
{
    public function showAdvice()
    {
        return view('profile.advice');
    }

    public function getAdvice(Request $request)
    {
        /*         $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.openai.key'),
            'Content-Type' => 'application/json'
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "You are a helpful assistant."
                ],
                [
                    'role' => 'user',
                    'content' => "Hello!"
                ],
            ]
        ]); */


        /* $response = Http::withHeaders([
            "Content-Type" => "application/json",
            "Authorization" => "Bearer " . config('services.openai.key')
        ])->post('https://api.openai.com/v1/chat/completions', [
            "model" => 'gpt-3.5-turbo',
            "messages" => [
                [
                    "role" => "user",
                    "content" => 'Hello'
                ]
            ],
            "temperature" => 0,
            "max_tokens" => 2048
        ]);
 */


        /*  $chatResponse  = $response->json(); */

        $chatResponse = 'neveikia';
        return response()->json(['mesage' => $chatResponse]);
    }
}
