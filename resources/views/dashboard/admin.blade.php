<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="text-sm font-medium text-gray-500 truncate">Total Students</div>
        <div class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($totalStudents) }}</div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="text-sm font-medium text-gray-500 truncate">Total Teachers</div>
        <div class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($totalTeachers) }}</div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="text-sm font-medium text-gray-500 truncate">Total Courses</div>
        <div class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($totalCourses) }}</div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="text-sm font-medium text-gray-500 truncate">Total Revenue</div>
        <div class="mt-1 text-3xl font-semibold text-gray-900">${{ number_format($totalRevenue, 2) }}</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Enrollments -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Enrollments</h3>
            <div class="flow-root">
                <ul role="list" class="-my-5 divide-y divide-gray-200">
                    @foreach($recentEnrollments as $enrollment)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img class="h-8 w-8 rounded-full" src="{{ $enrollment->student->profile_photo_url }}" alt="">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $enrollment->student->name }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Enrolled in {{ $enrollment->course->title }}
                                    </p>
                                </div>
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        ${{ number_format($enrollment->amount, 2) }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Popular Courses -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Popular Courses</h3>
            <div class="flow-root">
                <ul role="list" class="-my-5 divide-y divide-gray-200">
                    @foreach($popularCourses as $course)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img class="h-8 w-8 rounded-lg object-cover" 
                                         src="{{ $course->thumbnail ? Storage::url($course->thumbnail) : asset('images/default-course.jpg') }}" 
                                         alt="">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $course->title }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $course->enrollments_count }} students enrolled
                                    </p>
                                </div>
                                <div>
                                    <a href="{{ route('courses.show', $course) }}" 
                                       class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                        View
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue Chart -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Monthly Revenue</h3>
            <div class="h-72">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Courses by Category -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Courses by Category</h3>
            <div class="h-72">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyRevenue->pluck('month')) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($monthlyRevenue->pluck('revenue')) !!},
                borderColor: 'rgb(79, 70, 229)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($coursesByCategory->pluck('category')) !!},
            datasets: [{
                data: {!! json_encode($coursesByCategory->pluck('count')) !!},
                backgroundColor: [
                    'rgb(79, 70, 229)',
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)',
                    'rgb(245, 158, 11)',
                    'rgb(239, 68, 68)',
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush 