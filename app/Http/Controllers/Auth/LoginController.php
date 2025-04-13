<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserLoggedIn;
use App\Events\UserLoggedOut;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Login\LoginService;
use Illuminate\Support\Facades\Auth;
use App\Traits\ActivityLogger; // Import the activity logger trait
use App\Traits\SystemUsageLogger; // Import the system usage logger trait
use App\Traits\IpGeolocationTrait; // Import the IP geolocation trait
use App\Traits\TelegramNotificationTrait; // Import the Telegram notification trait

class LoginController extends Controller
{
    use ActivityLogger; // Use the activity logger trait
    use SystemUsageLogger; // Use the system usage logger trait
    use IpGeolocationTrait; // Use the IP geolocation trait
    use TelegramNotificationTrait; // Use the Telegram notification trait

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

                // Get the address from the IP address using the trait method
                $address = $this->getAddressFromIp($ipAddress);

                // Log activity for successful login
                $this->logActivity('Login successful', $user, 'login', $request, $startTime, $memoryBefore);
                $this->logSystemUsage($request, 'login', $startTime, $memoryBefore); // Log system usage

                // Dispatch the UserLoggedIn event
                event(new UserLoggedIn($user, $address, $ipAddress));

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

    public function loginPos(Request $request)
    {
        $startTime = microtime(true);
        $memoryBefore = memory_get_usage();

        try {
            // Validate login credentials
            $this->loginService->validateLogin($request);

            // Attempt to log in the user
            $user = $this->loginService->attemptLogin($request);

            if ($user) {
                // Set user as logged in
                $this->setUserLoggedIn($user, true);
                $this->loginService->logEvent($user, 'success', $request);

                $ipAddress = $request->ip();
                $address = $this->getAddressFromIp($ipAddress);

                // Log activity for successful login
                $this->logActivity('Login successful', $user, 'login', $request, $startTime, $memoryBefore);
                $this->logSystemUsage($request, 'login', $startTime, $memoryBefore);

                // Dispatch the UserLoggedIn event
                event(new UserLoggedIn($user, $address, $ipAddress));

                // Return JSON response with redirect information
                return response()->json([
                    'success' => true,
                    'redirect' => $this->determineRedirectPath($user),
                    'user' => [
                        'name' => $user->name,
                        'role' => $user->role // Make sure your user model has a role attribute
                    ],
                ]);
            }

            // Log failed login attempt
            $this->loginService->logFailedLogin($request);
            $this->logActivity('Failed login attempt', null, 'login', $request, $startTime, $memoryBefore);
            $this->logSystemUsage($request, 'login', $startTime, $memoryBefore);

            return response()->json(['error' => 'Invalid credentials'], 401);
        } catch (\Exception $e) {
            $this->loginService->logError($request, $e->getMessage());
            $this->logActivity('Login error: ' . $e->getMessage(), null, 'login', $request, $startTime, $memoryBefore);
            $this->logSystemUsage($request, 'login', $startTime, $memoryBefore);

            return response()->json(['error' => 'An error occurred during the login process. Please try again.'.$e->getMessage()], 500);
        }
    }

    protected function determineRedirectPath($user)
    {
            return route('poskasir.index');
     
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
        $startTime = microtime(true); // Start time for performance measurement
        $memoryBefore = memory_get_usage(); // Memory usage before logout attempt

        $user = Auth::user();

        if ($user) {
            // Log activity for successful logout
            $this->logActivity('Logout successful', $user, 'logout', $request, $startTime, $memoryBefore);
            $this->logSystemUsage($request, 'logout', $startTime, $memoryBefore); // Log system usage

            // Optionally, get the user's IP address for logging
            $ipAddress = $request->ip();

            // Dispatch the UserLoggedOut event
            event(new UserLoggedOut($user, $ipAddress));

            // Set user as logged out
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
}
