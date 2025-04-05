<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Attendance System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=geometry"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4f46e5',
                        secondary: '#10b981',
                        dark: '#1e293b',
                        danger: '#ef4444',
                        warning: '#f59e0b'
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s infinite',
                        'spin-slow': 'spin 2s linear infinite'
                    }
                }
            }
        }
    </script>
    <style>
        #videoElement {
            transform: scaleX(-1); /* Mirror effect for webcam */
            border-radius: 0.5rem;
        }
        #map {
            height: 250px;
            border-radius: 0.5rem;
        }
        .attendance-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-md">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-fingerprint text-2xl text-primary"></i>
                    <h1 class="text-xl font-bold text-gray-800">Smart<span class="text-primary">Attendance</span></h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center space-x-2 bg-gray-100 px-3 py-1 rounded-full">
                        <i class="fas fa-user-circle text-gray-600"></i>
                        <span class="font-medium">John Doe</span>
                    </div>
                    <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded-full transition">
                        <i class="fas fa-bell text-gray-600"></i>
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 container mx-auto px-4 py-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column (Attendance Form) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Face Recognition & GPS Section -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Check-In / Check-Out</h2>
                        
                        <!-- Real-time Clock -->
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <div class="text-4xl font-bold text-gray-800" id="realTimeClock">--:--:--</div>
                                <div class="text-gray-500" id="realTimeDate">-- --- ----</div>
                            </div>
                            <div class="bg-primary bg-opacity-10 text-primary px-4 py-2 rounded-full font-medium">
                                <i class="fas fa-clock mr-2"></i>
                                <span id="attendanceStatus">Not Checked In</span>
                            </div>
                        </div>

                        <!-- Webcam Face Recognition -->
                        <div class="mb-6">
                            <h3 class="font-medium text-gray-700 mb-2">Face Recognition</h3>
                            <div class="relative bg-gray-200 rounded-lg overflow-hidden">
                                <video id="videoElement" width="100%" autoplay></video>
                                <div id="faceOverlay" class="absolute inset-0 flex items-center justify-center hidden">
                                    <div class="bg-white bg-opacity-80 p-4 rounded-lg text-center">
                                        <i class="fas fa-check-circle text-4xl text-green-500 mb-2"></i>
                                        <p class="font-bold">Face Recognized!</p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-2">Ensure your face is clearly visible.</p>
                        </div>

                        <!-- Location Verification -->
                        <div class="mb-6">
                            <h3 class="font-medium text-gray-700 mb-2">Location Verification</h3>
                            <div id="map" class="w-full"></div>
                            <div class="mt-2 flex items-center">
                                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                <p class="text-sm text-gray-600">You must be within <span class="font-bold">2 km</span> of the office to check in.</p>
                            </div>
                            <div id="locationStatus" class="mt-3 p-3 rounded-lg bg-gray-100 hidden">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>You are within the allowed radius.</span>
                            </div>
                        </div>

                        <!-- Check-In/Out Button -->
                        <button id="attendanceButton" class="w-full bg-primary hover:bg-primary-dark text-white py-3 rounded-lg font-bold text-lg transition flex items-center justify-center gap-2 disabled:opacity-50">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Check In</span>
                        </button>
                    </div>

                    <!-- Recent Attendance History -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Attendance</h2>
                        <div class="space-y-4">
                            <!-- Attendance Record 1 -->
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg attendance-card transition">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-green-100 p-2 rounded-full">
                                        <i class="fas fa-sign-in-alt text-green-500"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Check In</p>
                                        <p class="text-sm text-gray-500">Today, 08:15 AM</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-green-500">On Time</p>
                                    <p class="text-xs text-gray-500">2.1 km from office</p>
                                </div>
                            </div>

                            <!-- Attendance Record 2 -->
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg attendance-card transition">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-blue-100 p-2 rounded-full">
                                        <i class="fas fa-sign-out-alt text-blue-500"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Check Out</p>
                                        <p class="text-sm text-gray-500">Yesterday, 05:30 PM</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-blue-500">Completed</p>
                                    <p class="text-xs text-gray-500">1.8 km from office</p>
                                </div>
                            </div>
                        </div>
                        <button class="mt-4 text-primary font-medium flex items-center">
                            <span>View Full History</span>
                            <i class="fas fa-chevron-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- Right Column (Employee Stats) -->
                <div class="space-y-6">
                    <!-- Employee Profile -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex flex-col items-center text-center">
                            <div class="h-20 w-20 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-user text-3xl text-blue-500"></i>
                            </div>
                            <h3 class="font-bold text-lg">John Doe</h3>
                            <p class="text-gray-500">Software Engineer</p>
                            <div class="mt-3 bg-gray-100 px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-id-badge mr-1"></i>
                                <span>EMP-00789</span>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Summary -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="font-bold text-gray-800 mb-4">Today's Summary</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status</span>
                                <span class="font-medium text-yellow-500">Not Checked In</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Working Hours</span>
                                <span class="font-medium">0h 0m</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Last Check-In</span>
                                <span class="font-medium">--:--</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Last Location</span>
                                <span class="font-medium">--</span>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Stats -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="font-bold text-gray-800 mb-4">Monthly Stats</h3>
                        <div class="space-y-3">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-600">Present</span>
                                    <span class="font-medium">18/20</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 90%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-600">Late Arrivals</span>
                                    <span class="font-medium">2</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 10%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-600">Absent</span>
                                    <span class="font-medium">0</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-red-500 h-2 rounded-full" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript for Functionality -->
    <script>
        // Real-time Clock
        function updateClock() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString();
            const dateStr = now.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
            
            document.getElementById('realTimeClock').textContent = timeStr;
            document.getElementById('realTimeDate').textContent = dateStr;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Face Recognition (Simulated)
        const videoElement = document.getElementById('videoElement');
        const faceOverlay = document.getElementById('faceOverlay');
        
        if (navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    videoElement.srcObject = stream;
                    
                    // Simulate face recognition after 3 seconds
                    setTimeout(() => {
                        faceOverlay.classList.remove('hidden');
                        document.getElementById('attendanceButton').disabled = false;
                    }, 3000);
                })
                .catch(err => {
                    console.error("Error accessing camera: ", err);
                });
        }

        // GPS & Map Integration
        function initMap() {
            // Office location (example: Jakarta)
            const officeLocation = { lat: -6.2088, lng: 106.8456 };
            
            // Create map centered on office
            const map = new google.maps.Map(document.getElementById('map'), {
                center: officeLocation,
                zoom: 15
            });
            
            // Add office marker
            new google.maps.Marker({
                position: officeLocation,
                map: map,
                title: 'Office Location'
            });
            
            // Draw 2km radius circle
            new google.maps.Circle({
                strokeColor: '#4f46e5',
                strokeOpacity: 0.4,
                strokeWeight: 2,
                fillColor: '#4f46e5',
                fillOpacity: 0.2,
                map: map,
                center: officeLocation,
                radius: 2000 // 2km in meters
            });
            
            // Get user's location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    position => {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        
                        // Add user marker
                        new google.maps.Marker({
                            position: userLocation,
                            map: map,
                            title: 'Your Location',
                            icon: {
                                url: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                            }
                        });
                        
                        // Calculate distance from office
                        const distance = google.maps.geometry.spherical.computeDistanceBetween(
                            new google.maps.LatLng(officeLocation),
                            new google.maps.LatLng(userLocation)
                        ) / 1000; // in km
                        
                        // Check if within 2km radius
                        if (distance <= 2) {
                            const locationStatus = document.getElementById('locationStatus');
                            locationStatus.classList.remove('hidden');
                            locationStatus.classList.add('bg-green-100');
                            locationStatus.innerHTML = `<i class="fas fa-check-circle text-green-500 mr-2"></i><span>You are within ${distance.toFixed(1)} km of the office.</span>`;
                        } else {
                            const locationStatus = document.getElementById('locationStatus');
                            locationStatus.classList.remove('hidden');
                            locationStatus.classList.add('bg-red-100');
                            locationStatus.innerHTML = `<i class="fas fa-times-circle text-red-500 mr-2"></i><span>You are ${distance.toFixed(1)} km away (max 2 km allowed).</span>`;
                            document.getElementById('attendanceButton').disabled = true;
                        }
                    },
                    error => {
                        console.error("Error getting location: ", error);
                        const locationStatus = document.getElementById('locationStatus');
                        locationStatus.classList.remove('hidden');
                        locationStatus.classList.add('bg-yellow-100');
                        locationStatus.innerHTML = `<i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i><span>Location access denied. Please enable GPS.</span>`;
                        document.getElementById('attendanceButton').disabled = true;
                    }
                );
            }
        }
        
        // Initialize map when Google Maps API is loaded
        window.initMap = initMap;

        // Attendance Button Action
        document.getElementById('attendanceButton').addEventListener('click', function() {
            const button = this;
            const statusElement = document.getElementById('attendanceStatus');
            
            button.disabled = true;
            button.innerHTML = `<i class="fas fa-spinner animate-spin-slow"></i><span>Processing...</span>`;
            
            // Simulate API call
            setTimeout(() => {
                button.classList.remove('bg-primary');
                button.classList.add('bg-green-500');
                button.innerHTML = `<i class="fas fa-check"></i><span>Checked In</span>`;
                statusElement.textContent = "Checked In at " + new Date().toLocaleTimeString();
                statusElement.parentElement.classList.remove('bg-primary', 'bg-opacity-10');
                statusElement.parentElement.classList.add('bg-green-100', 'text-green-800');
                
                // Update today's summary
                document.querySelector('.text-yellow-500').textContent = "Checked In";
                document.querySelector('.text-yellow-500').classList.remove('text-yellow-500');
                document.querySelector('.text-yellow-500').classList.add('text-green-500');
            }, 2000);
        });
    </script>
</body>
</html>