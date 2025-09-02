@extends('components.navshowdetail')

@section('title', $jobListing->title . ' - ' . $jobListing->company_name)

@push('styles')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Prevent horizontal overflow */
        html,
        body {
            overflow-x: hidden;
        }

        /* Ensure responsive behavior on mobile */
        @media (max-width: 639px) {
            .mobile-force-stack {
                flex-direction: column !important;
            }

            .mobile-force-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endpush

@section('content')

    <!-- Tambahkan di bagian atas show.blade.php untuk debugging -->

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8 font-sans">
        <!-- Header Section -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center mb-4 space-y-4 sm:space-y-0 mobile-force-stack">
                @php
                    $logoPath = $jobListing->company_logo;
                    $logoExists = false;

                    if ($logoPath) {
                        // Coba beberapa kemungkinan path
                        $possiblePaths = [
                            $logoPath, // Path asli dari database
                            'images/' . $logoPath, // Jika perlu tambah images/
                            'images/company-logos/' . basename($logoPath), // Path ke folder company-logos
                            str_replace('public/', '', $logoPath), // Hapus public/ jika ada
                        ];

                        foreach ($possiblePaths as $path) {
                            if (file_exists(public_path($path))) {
                                $logoPath = $path;
                                $logoExists = true;
                                break;
                            }
                        }
                    }
                @endphp

                <!-- Company Logo -->
                <div class="flex-shrink-0">
                    @if($logoExists)
                        <img src="{{ asset($logoPath) }}" alt="{{ $jobListing->company_name }}"
                            class="w-16 h-16 sm:w-20 sm:h-20 object-contain rounded-lg"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    @endif

                    <div
                        class="w-16 h-16 sm:w-20 sm:h-20 bg-blue-600 rounded-lg flex items-center justify-center {{ $logoExists ? 'hidden' : '' }}">
                        <span
                            class="text-white font-bold text-lg sm:text-xl">{{ substr($jobListing->company_name, 0, 1) }}</span>
                    </div>
                </div>

                {{-- Company and Job Info --}}
                <div class="flex-1 sm:ml-4">
                    <p class="text-sm text-gray-600 mb-1">{{ $jobListing->company_name }}</p>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">{{ $jobListing->title }}</h1>
                </div>
            </div>

            <!-- Job Meta Info -->
            <div
                class="grid grid-cols-1 sm:grid-cols-2 lg:flex lg:flex-wrap gap-2 lg:gap-4 text-sm text-gray-600 mb-6 mobile-force-grid">
                @if($jobListing->location)
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 w-4"></i>
                        <span class="truncate">{{ $jobListing->location }}</span>
                    </div>
                @endif

                @if($jobListing->type)
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-2 w-4"></i>
                        <span>{{ $jobListing->type }}</span>
                    </div>
                @endif

                @if($jobListing->department)
                    <div class="flex items-center">
                        <i class="fas fa-building mr-2 w-4"></i>
                        <span>{{ $jobListing->department }}</span>
                    </div>
                @endif

                <div class="flex items-center">
                    <i class="fas fa-calendar mr-2 w-4"></i>
                    <span>Posted {{ $jobListing->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <!-- Job Description Section -->
        @if($jobListing->description)
            <div class="mb-6 sm:mb-8">
                <div class="prose max-w-none text-gray-700 leading-relaxed text-sm sm:text-base">
                    {!! $jobListing->description !!}
                </div>
            </div>
        @endif

        <!-- Requirements Section -->
        @if($jobListing->requirements)
            <div class="mb-6 sm:mb-8">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">SALES ENGINEER REQUIREMENTS:</h3>
                <div class="text-gray-700 leading-relaxed text-sm sm:text-base">
                    @php
                        // Check if content is HTML
                        if (strip_tags($jobListing->requirements) != $jobListing->requirements) {
                            echo $jobListing->requirements;
                        } else {
                            // Parse plain text with bullet points
                            $lines = explode("\n", $jobListing->requirements);
                            echo '<ul class="list-disc list-inside space-y-2 pl-2">';
                            foreach ($lines as $line) {
                                $line = trim($line);
                                if (!empty($line)) {
                                    // Remove existing bullet points or numbers
                                    $line = preg_replace('/^[•\-\*\d+\.\s]*/', '', $line);
                                    if (!empty(trim($line))) {
                                        echo '<li class="break-words">' . trim($line) . '</li>';
                                    }
                                }
                            }
                            echo '</ul>';
                        }
                    @endphp
                </div>
            </div>
        @endif

        <!-- Benefits Section -->
        @if($jobListing->benefits)
            <div class="mb-6 sm:mb-8">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">BENEFITS:</h3>
                <div class="text-gray-700 leading-relaxed text-sm sm:text-base">
                    @php
                        // Check if content is HTML
                        if (strip_tags($jobListing->benefits) != $jobListing->benefits) {
                            echo $jobListing->benefits;
                        } else {
                            // Parse plain text with bullet points
                            $lines = explode("\n", $jobListing->benefits);
                            echo '<ul class="list-disc list-inside space-y-2 pl-2">';
                            foreach ($lines as $line) {
                                $line = trim($line);
                                if (!empty($line)) {
                                    // Remove existing bullet points or numbers
                                    $line = preg_replace('/^[•\-\*\d+\.\s]*/', '', $line);
                                    if (!empty(trim($line))) {
                                        echo '<li class="break-words">' . trim($line) . '</li>';
                                    }
                                }
                            }
                            echo '</ul>';
                        }
                    @endphp
                </div>
            </div>
        @endif

        <!-- Application Form Section -->
        <div class="bg-gray-50 rounded-lg p-4 sm:p-6">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-4 sm:mb-6">Apply for this job</h3>

            <form action="{{ route('careers.submit', $jobListing->slug) }}" method="POST" enctype="multipart/form-data"
                id="jobApplicationForm">
                @csrf

                <div class="space-y-4 sm:space-y-6">
                    <!-- Job Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Job Category*</label>
                        <select name="job_category" required
                            class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Position</option>
                            <option value="Sales" {{ $jobListing->department == 'Sales' ? 'selected' : '' }}>Sales</option>
                            <option value="Marketing" {{ $jobListing->department == 'Marketing' ? 'selected' : '' }}>Marketing
                            </option>
                            <option value="Engineering" {{ $jobListing->department == 'Engineering' ? 'selected' : '' }}>
                                Engineering</option>
                            <option value="IT" {{ $jobListing->department == 'IT' ? 'selected' : '' }}>IT</option>
                            <option value="HR" {{ $jobListing->department == 'HR' ? 'selected' : '' }}>HR</option>
                            <option value="Finance" {{ $jobListing->department == 'Finance' ? 'selected' : '' }}>Finance
                            </option>
                        </select>
                    </div>

                    <!-- Name & Email Row for larger screens -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mobile-force-grid">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name*</label>
                            <input type="text" name="name" required
                                class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('name') }}">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email*</label>
                            <input type="email" name="email" required
                                class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('email') }}">
                        </div>
                    </div>

                    <!-- Phone & Date of Birth Row for larger screens -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mobile-force-grid">
                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone*</label>
                            <div class="flex">
                                <div
                                    class="flex items-center bg-gray-100 border border-r-0 border-gray-300 rounded-l-md px-2 sm:px-3">
                                    <img src="/images/logo_indo.png" alt="ID" class="w-3 h-2 sm:w-4 sm:h-3 mr-1 sm:mr-2">
                                    <span class="text-gray-600 text-sm">+62</span>
                                </div>
                                <input type="tel" name="phone" required
                                    class="flex-1 px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="812-345-678" value="{{ old('phone') }}">
                            </div>
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth*</label>
                            <input type="date" name="date_of_birth" required
                                class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('date_of_birth') }}">
                        </div>
                    </div>

                    <!-- Attach Resume -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Attach Resume*</label>
                        <div class="flex flex-col sm:flex-row mobile-force-stack">
                            <input type="file" id="resume" name="resume" required accept=".pdf,.doc,.docx" class="hidden">
                            <div class="flex w-full">
                                <div id="file-display"
                                    class="flex-1 px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-l-md bg-gray-50 text-gray-500 min-h-[38px] flex items-center">
                                    No file chosen
                                </div>
                                <button type="button" id="browse-btn"
                                    class="px-3 sm:px-4 py-2 text-sm sm:text-base text-white border border-l-0 border-gray-300 rounded-r-md transition-colors whitespace-nowrap"
                                    style="background-color: #48D1CC;" onmouseover="this.style.backgroundColor='#40C5C0'"
                                    onmouseout="this.style.backgroundColor='#48D1CC'">
                                    Browse
                                </button>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Accepted formats: PDF, DOC, DOCX (Max size: 5MB)</p>
                    </div>

                    <!-- Cover Letter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cover Letter</label>
                        <textarea name="cover_letter" rows="4"
                            class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                            placeholder="Tell us why you're interested in this position...">{{ old('cover_letter') }}</textarea>
                    </div>

                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="p-3 sm:p-4 bg-green-100 border border-green-400 text-green-700 rounded-md text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="p-3 sm:p-4 bg-red-100 border border-red-400 text-red-700 rounded-md text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="p-3 sm:p-4 bg-red-100 border border-red-400 text-red-700 rounded-md text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-2">
                        <button type="submit"
                            class="w-full sm:w-auto text-white px-6 py-3 sm:py-2 rounded-md transition-colors font-medium text-sm sm:text-base"
                            style="background-color: #48D1CC;" onmouseover="this.style.backgroundColor='#40C5C0'"
                            onmouseout="this.style.backgroundColor='#48D1CC'">
                            Submit Application
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer Note -->
        <div class="mt-6 sm:mt-8 p-3 sm:p-4 bg-blue-50 rounded-lg">
            <p class="text-xs sm:text-sm text-gray-600 text-center leading-relaxed">
                <i class="fas fa-info-circle mr-2"></i>
                Hanya apply dan kirim lamaran yang sesuai dengan posisi ini. Untuk bisa kirim di
                karir lainnya, silahkan kunjungi halaman <a href="{{ route('careers') }}"
                    class="text-blue-600 hover:underline">karir kami</a>.
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // File upload functionality
            const fileInput = document.getElementById('resume');
            const browseBtn = document.getElementById('browse-btn');
            const fileDisplay = document.getElementById('file-display');

            browseBtn.addEventListener('click', function () {
                fileInput.click();
            });

            fileInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    const fileName = file.name;
                    const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB

                    if (file.size > 5 * 1024 * 1024) { // 5MB limit
                        alert('File size must be less than 5MB');
                        this.value = '';
                        fileDisplay.textContent = 'No file chosen';
                        return;
                    }

                    // Truncate filename on mobile
                    const maxLength = window.innerWidth < 640 ? 20 : 30;
                    const displayName = fileName.length > maxLength
                        ? fileName.substring(0, maxLength) + '...'
                        : fileName;

                    fileDisplay.innerHTML = `
                            <div class="flex items-center justify-between w-full">
                                <span class="text-gray-900 truncate mr-2" title="${fileName}">${displayName}</span>
                                <span class="text-gray-500 text-xs whitespace-nowrap">${fileSize} MB</span>
                            </div>
                        `;
                } else {
                    fileDisplay.textContent = 'No file chosen';
                }
            });

            // Phone number formatting
            const phoneInput = document.querySelector('input[name="phone"]');
            phoneInput.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 3 && value.length <= 11) {
                    if (value.length <= 3) {
                        value = value;
                    } else if (value.length <= 6) {
                        value = value.slice(0, 3) + '-' + value.slice(3);
                    } else {
                        value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6);
                    }
                }
                e.target.value = value;
            });

            // Form validation
            const form = document.getElementById('jobApplicationForm');
            form.addEventListener('submit', function (e) {
                const requiredFields = form.querySelectorAll('input[required], select[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('border-red-500');
                        isValid = false;
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });

                // Validate file
                if (!fileInput.files || !fileInput.files[0]) {
                    document.querySelector('#file-display').parentElement.classList.add('border-red-500');
                    isValid = false;
                } else {
                    document.querySelector('#file-display').parentElement.classList.remove('border-red-500');
                }

                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields');
                }
            });

            // Simple mobile detection and force update
            function updateMobileLayout() {
                const isMobile = window.innerWidth < 640;
                const stackElements = document.querySelectorAll('.mobile-force-stack');
                const gridElements = document.querySelectorAll('.mobile-force-grid');

                if (isMobile) {
                    stackElements.forEach(el => {
                        el.style.flexDirection = 'column';
                    });
                    gridElements.forEach(el => {
                        el.style.gridTemplateColumns = '1fr';
                    });
                } else {
                    stackElements.forEach(el => {
                        el.style.flexDirection = '';
                    });
                    gridElements.forEach(el => {
                        el.style.gridTemplateColumns = '';
                    });
                }
            }

            // Apply on load and resize
            updateMobileLayout();
            window.addEventListener('resize', updateMobileLayout);
            // Handle window resize for file display
            window.addEventListener('resize', function () {
                updateMobileLayout(); // Update layout

                if (fileInput.files && fileInput.files[0]) {
                    const file = fileInput.files[0];
                    const fileName = file.name;
                    const fileSize = (file.size / 1024 / 1024).toFixed(2);

                    const maxLength = window.innerWidth < 640 ? 20 : 30;
                    const displayName = fileName.length > maxLength
                        ? fileName.substring(0, maxLength) + '...'
                        : fileName;

                    fileDisplay.innerHTML = `
                            <div class="flex items-center justify-between w-full">
                                <span class="text-gray-900 truncate mr-2" title="${fileName}">${displayName}</span>
                                <span class="text-gray-500 text-xs whitespace-nowrap">${fileSize} MB</span>
                            </div>
                        `;
                }
            });
        });
    </script>

    <!-- Responsive Footer -->
    <footer class="bg-[#1f1f1f] text-[#696969] text-xs py-4 sm:py-6 text-center sm:text-left px-4 sm:pl-40 font-poppins">
        &copy; 2017 PT Pola Petro Development
    </footer>
@endsection