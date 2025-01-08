<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Login\LoginService;
use Illuminate\Support\Facades\Auth;
use App\Traits\ActivityLogger; // Import the activity logger trait
use App\Traits\SystemUsageLogger; // Import the system usage logger trait
use Illuminate\Support\Facades\Http; // Ensure Http is imported for sending requests

class LoginController extends Controller
{
    use ActivityLogger; // Use the activity logger trait
    use SystemUsageLogger; // Use the system usage logger trait

    protected LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showLoginFormKoperasi()
    {
        return view('auth.loginkoperasi');
    }

    public function login(Request $request)
    {
        $startTime = microtime(true); // Start time for performance measurement
        $memoryBefore = memory_get_usage(); // Memory usage before login attempt

        try {
            // Validate login credentials
            $this->loginService->validateLogin($request);

            // Attempt to log in the user
            $user = $this->loginService->attemptLogin($request);

            if ($user) {
                // Set user as logged in
                $this->setUserLoggedIn($user, true);
                $this->loginService->logEvent($user, 'success', $request);

                // Get the user's IP address
                $ipAddress = $request->ip();

                // Get the address from the IP address
                $address = $this->getAddressFromIp($ipAddress);

                // Log activity for successful login
                $this->logActivity('Login successful', $user, 'login', $request, $startTime, $memoryBefore);
                $this->logSystemUsage($request, 'login', $startTime, $memoryBefore); // Log system usage

                // Send Telegram notification for successful login
                $this->sendTelegramNotification(
                    $user->name, // User name
                    $address, // User address from IP
                    'User logged in', // Status
                    $user->channel_id // Dynamic chat_id from user
                );

                return $this->redirectUser($user);
            }

            // Log failed login attempt
            $this->loginService->logFailedLogin($request);
            $this->logActivity('Failed login attempt', null, 'login', $request, $startTime, $memoryBefore); // No subject for failed login
            $this->logSystemUsage($request, 'login', $startTime, $memoryBefore); // Log system usage

            return response()->json(['error' => 'Invalid credentials'], 401);
        } catch (\Exception $e) {
            // Log error during login process
            $this->loginService->logError($request, $e->getMessage());
            $this->logActivity('Login error: ' . $e->getMessage(), null, 'login', $request, $startTime, $memoryBefore); // No subject for error
            $this->logSystemUsage($request, 'login', $startTime, $memoryBefore); // Log system usage

            return response()->json(['error' => 'An error occurred during the login process. Please try again.'], 500);
        }
    }

    private function getAddressFromIp($ipAddress)
    {
        $url = "https://ipinfo.io/{$ipAddress}/json"; // Using ipinfo.io for geolocation
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();

            // Check if the keys exist before accessing them
            $city = $data['city'] ?? null;
            $region = $data['region'] ?? null;
            $country = $data['country'] ?? null;
            $postal = $data['postal'] ?? null; // Postal code if available
            $hostname = $data['hostname'] ?? null; // Hostname if available

            // Construct a formatted address
            $formattedAddress = [];
            if ($hostname) {
                $formattedAddress[] = $hostname; // Include hostname if available
            }
            if ($city) {
                $formattedAddress[] = $city;
            }
            if ($region) {
                $formattedAddress[] = $region;
            }
            if ($postal) {
                $formattedAddress[] = $postal; // Include postal code if available
            }
            if ($country) {
                $formattedAddress[] = $country;
            }

            // Join the address components with a comma
            return implode(', ', $formattedAddress) ?: 'Address not found'; // Fallback if no address components are found
        }

        return 'Address not found'; // Fallback if the request was not successful
    }




    protected function redirectUser($user)
    {
        // Determine the redirect route based on user role
        $redirectRoute = $user->hasRole('supplier') ? route('home.supplier') : route('home.index');

        return response()->json([
            'message' => 'Login successful',
            'success' => true,
            'user' => $user,
            'redirect' => $redirectRoute,
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $this->setUserLoggedIn($user, false);
        }

        Auth::logout();
        return redirect('/login/form');
    }

    protected function setUserLoggedIn($user, $status)
    {
        $user->is_logged_in = $status;
        $user->save();
    }

    private function sendTelegramNotification($userName, $userAddress, $status, $chatId)
    {
        // Create a more engaging message
        $message = "👤 **User Login Notification** 👤\n\n";
        $message .= "🏢 *User:* **$userName**\n";
        $message .= "🏠 *User Address:* **$userAddress**\n\n";
        $message .= "🎉 *Status:* **$status**\n\n";

        // Send the message to Telegram
        $this->sendMessageToTelegram($message, $chatId);
    }

    private function sendMessageToTelegram($message, $chatId)
    {
        $telegramToken = env('TELEGRAM_BOT_TOKEN');
        $url = "https://api.telegram.org/bot$telegramToken/sendMessage";

        // Construct the full URL for debugging
        $fullUrl = $url . "?chat_id=" . $chatId . "&text=" . urlencode($message) . "&parse_mode=Markdown";
        try {
            // Log the full URL for debugging

            // Send the message to Telegram
            $response = Http::post($fullUrl, [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown', // Use Markdown for formatting
            ]);

            // Check if the response is successful
            if ($response->successful()) {
                activity('Telegram Notification Sent')
                    ->withProperties([
                        'chat_id' => $chatId,
                        'message' => $message,
                    ])
                    ->log('Telegram notification sent successfully for chat ID: ' . $chatId);
            } else {
                // Log the error response for debugging
                $errorMessage = $response->json()['description'] ?? 'Unknown error';
                activity('Telegram Notification Failed')
                    ->withProperties([
                        'chat_id' => $chatId,
                        'error' => $response->body(),
                    ])
                    ->log('Failed to send Telegram notification for chat ID: ' . $chatId . '. Error: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            // Log the exception
            activity('Telegram Notification Exception')
                ->withProperties([
                    'chat_id' => $chatId,
                    'error_message' => $e->getMessage(),
                ])
                ->log('Exception occurred while sending Telegram notification for chat ID: ' . $chatId);
        }
    }
}
