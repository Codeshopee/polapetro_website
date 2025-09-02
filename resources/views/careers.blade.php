@extends('components.navigation')

@section('title', 'Careers - Pola Petro Development')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
    /* Fix horizontal scroll */
    html,
    body {
        overflow-x: hidden;
        width: 100%;
        max-width: 100vw;
    }

    * {
        box-sizing: border-box;
    }

    .font-poppins {
        font-family: 'Poppins', sans-serif;
    }

    .job-card {
        transition: all 0.3s ease;
        transform: translateY(0);
        opacity: 0;
        transform: translateY(20px);
        display: flex !important;
        flex-direction: column !important;
        width: auto !important;
        max-width: none !important;
        min-width: 0 !important;
    }

    .job-card.show {
        opacity: 1;
        transform: translateY(0);
    }

    .job-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .badge-success {
        background-color: #dcfce7;
        color: #166534;
    }

    .badge-warning {
        background-color: #fef3c7;
        color: #92400e;
    }

    .badge-info {
        background-color: #dbeafe;
        color: #1e40af;
    }

    .badge-gray {
        background-color: #f3f4f6;
        color: #374151;
    }

    .badge-danger {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .badge-primary {
        background-color: #ede9fe;
        color: #7c3aed;
    }

    .deadline-warning {
        animation: pulse 2s infinite;
    }

    /* Ensure container doesn't overflow */
    .container {
        max-width: 100%;
        margin-left: auto;
        margin-right: auto;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    /* Fix hero section text positioning */
    .hero-text {
        padding-left: 2rem;
        padding-right: 2rem;
    }

    @media (min-width: 768px) {
        .container {
            max-width: 1280px;
        }

        .hero-text {
            padding-left: 8rem;
            padding-right: 2rem;
        }
    }

    /* Pastikan grid layout konsisten di semua halaman - FIXED */
    .jobs-grid {
        display: grid !important;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)) !important;
        gap: 2rem !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    @media (min-width: 768px) {
        .jobs-grid {
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)) !important;
        }
    }

    @media (min-width: 1024px) {
        .jobs-grid {
            grid-template-columns: repeat(3, 1fr) !important;
        }
    }

    /* Fix untuk job card dalam grid */
    .jobs-grid>.job-card {
        display: flex !important;
        flex-direction: column !important;
    }

    /* Override any conflicting styles */
    .jobs-grid::after,
    .jobs-grid::before {
        display: none !important;
    }

    /* Pagination Styles */
    .pagination-controls {
        transition: all 0.3s ease;
    }

    .pagination-btn {
        transition: all 0.2s ease;
    }

    .pagination-btn:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Hero Section -->
        <div class="relative from-green-600 to-blue-500 py-[169px] overflow-hidden">
            <div class="absolute inset-0">
                <img src="/images/FreeGreatPicture-newclr.jpg" alt="Team Background"
                    class="w-full h-full object-cover object-top">
            </div>
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="relative hero-text text-left text-white font-sans mt-16">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-2">Opportunities</h1>
                <p class="text-xl md:text-2xl lg:text-3xl font-light text-white">at Pola Petro Development Group</p>
            </div>
        </div>

        <div class="container mx-auto px-6 pt-20 pb-3 font-sans">
            <!-- Heading Section -->
            <div class="text-center mb-12">
                <h2 class="text-5xl md:text-6xl font-light text-teal-400 mb-6">
                    "Growing together to a brighter future"
                </h2>
                <p class="text-gray-600 text-base max-w-4xl mx-auto opacity-80 leading-relaxed">
                    By visiting this page we know you are wondering what it's like to work for Pola Petro Development Group
                </p>
                <p class="text-gray-600 text-base max-w-4xl mx-auto opacity-80 leading-relaxed mt-4">
                    Competitive, exciting, diverse, and synergised. These are a few words we use to describe our businesses
                    and our people.
                </p>
                <p class="text-gray-600 text-base max-w-4xl mx-auto opacity-80 leading-relaxed mt-4">
                    We are looking to attract people and retain employees who share the same values and vision. People who
                    Focus on what's important, Honest and Passionate about their work, Resilient and Deliver what they say
                    they will do, and Show their energy to energise others around them.
                </p>
                <p class="text-gray-600 text-base max-w-4xl mx-auto opacity-80 leading-relaxed mt-4">
                    We would like to thrive with you in becoming one of the most efficient, effective and sustainable
                    organization. Emphasizing our strategy in high quality human resources, products and operations
                </p>
                <p class="text-gray-600 text-base max-w-4xl mx-auto opacity-80 leading-relaxed mt-4">
                    Browse through our opportunities below:
                </p>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="container px-20 mx-auto mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6 w-full">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                        <select id="department-filter" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <option value="">All Departments</option>
                            @foreach($allJobs->pluck('department')->unique()->filter() as $department)
                                <option value="{{ $department }}">{{ $department }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <select id="location-filter" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <option value="">All Locations</option>
                            @foreach($allJobs->pluck('location')->unique()->filter() as $location)
                                <option value="{{ $location }}">{{ $location }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Job Type</label>
                        <select id="type-filter" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <option value="">All Types</option>
                            <option value="Full-time">Full-time</option>
                            <option value="Part-time">Part-time</option>
                            <option value="Contract">Contract</option>
                            <option value="Internship">Internship</option>
                            <option value="Freelance">Freelance</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Experience</label>
                        <select id="experience-filter" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <option value="">All Levels</option>
                            <option value="Entry Level">Entry Level</option>
                            <option value="Junior">Junior</option>
                            <option value="Mid Level">Mid Level</option>
                            <option value="Senior">Senior</option>
                            <option value="Manager">Manager</option>
                            <option value="Director">Director</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-20 pt-3 pb-20 font-sans">
            <!-- Pagination Info -->
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        Showing <span id="showing-start">{{ $jobs->firstItem() ?? 0 }}</span>-<span
                            id="showing-end">{{ $jobs->lastItem() ?? 0 }}</span> of <span
                            id="total-jobs">{{ $totalJobs }}</span> jobs
                    </div>
                    <div class="text-sm text-gray-600">
                        Page <span id="current-page">{{ $jobs->currentPage() }}</span> of <span
                            id="total-pages">{{ $jobs->lastPage() }}</span>
                    </div>
                </div>
            </div>

            <div class="jobs-grid" id="jobs-container">
                @forelse($jobs as $job)
                    <div class="job-card border rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-8 flex flex-col h-full text-center bg-white show"
                        data-department="{{ $job->department }}" data-location="{{ $job->location }}"
                        data-type="{{ $job->type }}" data-experience="{{ $job->experience_level }}">
                        <!-- Company Logo & Job Title -->
                        <div class="mb-6 flex items-center justify-start space-x-4 w-full">
                            @php
                                $logoPath = $job->company_logo;
                                $logoExists = false;

                                if ($logoPath) {
                                    // Mengikuti logika dari show.blade.php
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

                            @if($logoExists)
                                <img src="{{ asset($logoPath) }}" alt="{{ $job->company_name }}"
                                    class="w-16 h-16 md:w-20 md:h-20 object-contain rounded-lg shadow-sm flex-shrink-0"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            @endif

                            <div
                                class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-teal-400 to-blue-500 rounded-lg flex items-center justify-center flex-shrink-0 {{ $logoExists ? 'hidden' : '' }}">
                                <span
                                    class="text-white font-bold text-lg md:text-xl">{{ substr($job->company_name, 0, 2) }}</span>
                            </div>

                            <!-- Job Information -->
                            <div class="text-left flex-1 min-w-0">
                                <p class="text-sm text-gray-600 mb-1">{{ $job->company_name }}</p>
                                <h3 class="text-lg md:text-xl lg:text-2xl font-bold text-gray-800 break-words">
                                    {{ $job->title }}
                                </h3>
                            </div>
                        </div>
                        <!-- Job Meta Info -->
                        <div class="space-y-3 mb-6">
                            <!-- Location -->
                            <div class="flex items-center justify-center text-gray-600">
                                <i class="fas fa-map-marker-alt text-teal-500 mr-2"></i>
                                <span class="text-sm md:text-base">{{ $job->location }}</span>
                            </div>

                            <!-- Job Type & Experience -->
                            <div class="flex items-center justify-center space-x-2 flex-wrap">
                                <span class="badge bg-gray-100 text-black">
                                    {{ $job->type }}
                                </span>
                                @if($job->experience_level)
                                    <span class="badge bg-gray-100 text-black">
                                        {{ $job->experience_level }}
                                    </span>
                                @endif
                            </div>

                            <!-- Department -->
                            <div class="flex items-center justify-center text-gray-600">
                                <i class="fas fa-building text-teal-500 mr-2"></i>
                                <span class="text-sm md:text-base">{{ $job->department }}</span>
                            </div>

                            <!-- Deadline Warning -->
                            @if($job->deadline && now()->diffInDays($job->deadline, false) <= 7)
                                <div class="deadline-warning">
                                    <span class="badge badge-danger">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Deadline: {{ $job->deadline->format('d M Y') }}
                                    </span>
                                </div>
                            @endif

                            <!-- Posted Time -->
                            <div class="flex items-center justify-center text-sm text-gray-500">
                                <i class="fas fa-calendar-alt text-teal-500 mr-2"></i>
                                <span>Posted {{ $job->created_at->diffForHumans() }}</span>
                            </div>

                            <!-- Salary Range (if available) -->
                            @if($job->salary_min || $job->salary_max || $job->salary_negotiable)
                                <div class="flex items-center justify-center text-gray-600">
                                    <i class="fas fa-money-bill-wave text-green-500 mr-2"></i>
                                    <span class="text-sm">
                                        @if($job->salary_min || $job->salary_max)
                                            @if($job->salary_min && $job->salary_max)
                                                Rp {{ number_format($job->salary_min, 0, ',', '.') }} -
                                                {{ number_format($job->salary_max, 0, ',', '.') }}
                                            @else
                                                {{ $job->salary_min ? 'From Rp ' . number_format($job->salary_min, 0, ',', '.') : 'Up to Rp ' . number_format($job->salary_max, 0, ',', '.') }}
                                            @endif
                                            <span class="text-xs text-gray-500">/ {{ $job->salary_type ?? 'month' }}</span>
                                        @else
                                            Negotiable
                                        @endif
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Job Description -->
                        <div class="flex-1 mb-6">
                            <p class="text-gray-700 text-sm md:text-base line-clamp-3">
                                {!! strip_tags($job->description) !!}
                            </p>
                        </div>

                        <!-- Read More Button -->
                        <a href="{{ route('careers.show', $job->slug) }}"
                            class="mt-auto mx-auto bg-gradient-to-r from-teal-400 to-teal-500 hover:from-teal-500 hover:to-teal-600 text-white px-6 py-3 rounded-lg text-sm md:text-base font-medium transition-all duration-200 transform hover:scale-105 shadow-md w-full max-w-xs">
                            <i class="fas fa-arrow-right mr-2"></i>
                            View Details
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="mb-4">
                            <i class="fas fa-briefcase text-gray-300 text-6xl"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-500 mb-2">No Open Positions</h3>
                        <p class="text-gray-400">Check back later for new opportunities</p>
                    </div>
                @endforelse
            </div>

            <!-- No Results Message -->
            <div id="no-results" class="hidden text-center py-16">
                <div class="mb-4">
                    <i class="fas fa-search text-gray-300 text-6xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-500 mb-2">No Matching Positions</h3>
                <p class="text-gray-400">Try adjusting your filters to see more results</p>
            </div>

            <!-- Simple Pagination Controls -->
            @if($jobs->hasPages())
                <div class="pagination-controls mt-12">
                    <div class="flex justify-between items-center">
                        <!-- Pagination Info -->
                        <div class="text-sm text-gray-600">
                            Menampilkan {{ $jobs->firstItem() ?? 0 }} - {{ $jobs->lastItem() ?? 0 }} dari {{ $totalJobs }} data
                        </div>

                        <!-- Page Numbers -->
                        <div class="flex items-center space-x-1">
                            @php
                                $currentPage = $jobs->currentPage();
                                $lastPage = $jobs->lastPage();
                                $showPages = [];

                                // Always show first few pages
                                for ($i = 1; $i <= min(5, $lastPage); $i++) {
                                    $showPages[] = $i;
                                }

                                // Add dots and last page if needed
                                if ($lastPage > 5) {
                                    if ($lastPage > 6) {
                                        $showPages[] = '...';
                                    }
                                    $showPages[] = $lastPage;
                                }
                            @endphp

                            @foreach($showPages as $page)
                                @if($page === '...')
                                    <span class="px-3 py-2 text-gray-500">...</span>
                                @elseif($page == $currentPage)
                                    <button class="px-3 py-2 text-blue-600 border-b-2 border-blue-600 font-medium text-sm">
                                        {{ $page }}
                                    </button>
                                @else
                                    <a href="{{ $jobs->url($page) }}"
                                        class="px-3 py-2 text-gray-600 hover:text-blue-600 font-medium text-sm transition-colors">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            <!-- Next Arrow -->
                            @if($jobs->hasMorePages())
                                <a href="{{ $jobs->nextPageUrl() }}"
                                    class="px-3 py-2 text-gray-600 hover:text-blue-600 transition-colors">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Footer - Responsive -->
        <footer
            class="bg-[#1f1f1f] text-[#696969] text-xs py-4 sm:py-6 text-center sm:text-left px-4 sm:px-8 lg:pl-40 font-poppins">
            &copy; 2017 PT Pola Petro Development
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const departmentFilter = document.getElementById('department-filter');
            const locationFilter = document.getElementById('location-filter');
            const typeFilter = document.getElementById('type-filter');
            const experienceFilter = document.getElementById('experience-filter');
            const jobCards = document.querySelectorAll('.job-card');
            const jobsContainer = document.getElementById('jobs-container');
            const noResults = document.getElementById('no-results');

            // Animate job cards on load
            setTimeout(() => {
                jobCards.forEach((card, index) => {
                    setTimeout(() => {
                        card.classList.add('show');
                    }, index * 100);
                });
            }, 100);

            function filterJobs() {
                const departmentValue = departmentFilter.value.toLowerCase();
                const locationValue = locationFilter.value.toLowerCase();
                const typeValue = typeFilter.value.toLowerCase();
                const experienceValue = experienceFilter.value.toLowerCase();

                let visibleCount = 0;

                jobCards.forEach(card => {
                    const department = card.dataset.department.toLowerCase();
                    const location = card.dataset.location.toLowerCase();
                    const type = card.dataset.type.toLowerCase();
                    const experience = (card.dataset.experience || '').toLowerCase();

                    const matchesDepartment = !departmentValue || department.includes(departmentValue);
                    const matchesLocation = !locationValue || location.includes(locationValue);
                    const matchesType = !typeValue || type === typeValue;
                    const matchesExperience = !experienceValue || experience.includes(experienceValue);

                    if (matchesDepartment && matchesLocation && matchesType && matchesExperience) {
                        // FIXED: Gunakan visibility bukan display untuk mempertahankan grid layout
                        card.style.visibility = 'visible';
                        card.style.opacity = '1';
                        card.style.position = 'relative';
                        visibleCount++;
                    } else {
                        card.style.visibility = 'hidden';
                        card.style.opacity = '0';
                        card.style.position = 'absolute';
                    }
                });

                // Update showing count
                document.getElementById('showing-end').textContent = visibleCount;
                document.getElementById('total-jobs').textContent = visibleCount;

                if (visibleCount === 0) {
                    noResults.classList.remove('hidden');
                } else {
                    noResults.classList.add('hidden');
                }
            }

            // Add event listeners
            departmentFilter.addEventListener('change', filterJobs);
            locationFilter.addEventListener('change', filterJobs);
            typeFilter.addEventListener('change', filterJobs);
            experienceFilter.addEventListener('change', filterJobs);
        });
    </script>
@endsection