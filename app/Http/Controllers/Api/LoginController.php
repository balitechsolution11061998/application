<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Login\LoginService;
use Illuminate\Support\Facades\Auth;
use App\Traits\ActivityLogger; // Import the activity logger trait
use App\Traits\SystemUsageLogger; // Import the system usage logger trait

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
            $this->loginService->validateLogin($request);

            $user = $this->loginService->attemptLogin($request);

            if ($user) {
                $this->setUserLoggedIn($user, true);
                $this->loginService->logEvent($user, 'success', $request);
                $this->logActivity($user, 'Login successful', $request, $startTime, $memoryBefore, $user, 'login', $user->id); // Pass user as subject and ID
                $this->logSystemUsage($request, 'login', $startTime, $memoryBefore); // Log system usage
                return $this->redirectUser($user);
            }

            $this->loginService->logFailedLogin($request);
            $this->logActivity(null, 'Failed login attempt', $request, $startTime, $memoryBefore, null, 'login'); // No subject for failed login
            $this->logSystemUsage($request, 'login', $startTime, $memoryBefore); // Log system usage
            return response()->json(['error' => 'Invalid credentials'], 401);
        } catch (\Exception $e) {
            $this->loginService->logError($request, $e->getMessage());
            $this->logActivity(null, 'Login error: ' . $e->getMessage(), $request, $startTime, $memoryBefore, null, 'login'); // No subject for error
            $this->logSystemUsage($request, 'login', $startTime, $memoryBefore); // Log system usage
            return response()->json(['error' => 'An error occurred during the login process. Please try again.'], 500);
        }
    }

    protected function redirectUser($user)
    {
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
}
