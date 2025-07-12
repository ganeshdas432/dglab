<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Patient Login -DG SKIN & HAIR CLINIC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen font-sans">

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-20 w-20 bg-blue-600 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-user-injured text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900">Patient Portal</h2>
                <p class="mt-2 text-sm text-gray-600">Access your medical reports and information</p>
            </div>

            <!-- Login Form -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
                @endif

                @if (session('success'))
                <div
                    class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('patient.login') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="mobile_no" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-mobile-alt mr-2 text-blue-600"></i>Mobile Number
                        </label>
                        <input type="text" name="mobile_no" id="mobile_no" value="{{ old('mobile_no') }}"
                            placeholder="Enter your mobile number"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required autofocus>
                        @error('mobile_no')
                        <p class="text-sm text-red-500 mt-2 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Enter the mobile number associated with your reports</p>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Access My Reports
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Need help?</span>
                        </div>
                    </div>

                    <div class="mt-4 space-y-2">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-phone text-blue-600 mr-1"></i>
                            Contact us at: <a href="tel:+918100644924" class="text-blue-600 hover:text-blue-700">+91
                                8100644924</a>
                        </p>
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-envelope text-blue-600 mr-1"></i>
                            Email: <a href="mailto:doctorghoshsclinic@gmail.com"
                                class="text-blue-600 hover:text-blue-700">doctorghoshsclinic@gmail.com</a>
                        </p>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <a href="/" class="text-sm text-gray-500 hover:text-gray-700 flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back to Main Website
                    </a>
                </div>
            </div>

            <!-- Features -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 text-center">What you can do:</h3>
                <div class="space-y-3">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-file-medical text-blue-600 mr-3"></i>
                        View all your medical reports
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-download text-green-600 mr-3"></i>
                        Download reports instantly
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-history text-purple-600 mr-3"></i>
                        Track download history
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-calendar text-orange-600 mr-3"></i>
                        View appointment history
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>