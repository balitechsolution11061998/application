<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;

class OpenAIController extends Controller
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OPENAI_API_KEY'); // Ensure this is set in your .env file
    }

    public function generate(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $maxRetries = 5; // Maximum number of retries
        $retryCount = 0;

        while ($retryCount < $maxRetries) {
            try {
                // Prepare the messages array
                $messages = [
                    [
                        'role' => 'user',
                        'content' => $request->input('prompt'),
                    ],
                ];

                // Make a request to the OpenAI API
                $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'model' => 'gpt-3.5-turbo',
                        'messages' => $messages,
                    ],
                ]);

                // Decode the response and return it as JSON
                $result = json_decode($response->getBody()->getContents(), true);
                return response()->json($result);
            } catch (RequestException $e) {
                if ($e->getResponse() && $e->getResponse()->getStatusCode() == 429) {
                    // Handle 429 Too Many Requests
                    $retryCount++;
                    sleep(pow(2, $retryCount)); // Exponential backoff
                    continue; // Retry the request
                }

                // Handle other exceptions
                return response()->json([
                    'error' => $e->getMessage(),
                ], 500);
            }
        }

        // If we reach here, it means we exhausted all retries
        return response()->json([
            'error' => 'Too many requests. Please try again later.',
        ], 429);
    }

}
