<x-app-layout>
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <nav class="flex items-center text-sm font-medium">
                <a href="{{ route('courses.show', $lesson->course) }}" class="text-gray-500 hover:text-gray-700">
                    {{ $lesson->course->title }}
                </a>
                <svg class="h-5 w-5 text-gray-400 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-900">{{ $lesson->title }}</span>
            </nav>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Lesson Content -->
                <div class="lg:col-span-3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $lesson->title }}</h1>
                            
                            @if($lesson->video_url)
                                <div class="aspect-w-16 aspect-h-9 mb-6">
                                    <iframe src="{{ $lesson->video_url }}" 
                                            frameborder="0" 
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                            allowfullscreen
                                            class="w-full h-full rounded-lg"></iframe>
                                </div>
                            @endif

                            <div class="prose max-w-none">
                                {!! $lesson->content !!}
                            </div>

                            @if($isEnrolled && !$lesson->isCompletedBy(auth()->user()))
                                <div class="mt-8 flex justify-end">
                                    <form action="{{ route('lessons.complete', [$lesson->course, $lesson]) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                            Mark as Complete
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @can('update', $lesson)
                                <div class="mt-8 flex justify-end space-x-4">
                                    <a href="{{ route('lessons.edit', $lesson) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
                                        Edit Lesson
                                    </a>
                                    <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700"
                                                onclick="return confirm('Are you sure you want to delete this lesson?')">
                                            Delete Lesson
                                        </button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                    </div>

                    <!-- Lesson Navigation -->
                    <div class="mt-8 flex justify-between">
                        @if($previousLesson)
                            <a href="{{ route('lessons.show', $previousLesson) }}" 
                               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                Previous Lesson
                            </a>
                        @else
                            <div></div>
                        @endif

                        @if($nextLesson)
                            <a href="{{ route('lessons.show', $nextLesson) }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Next Lesson
                                <svg class="h-5 w-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('courses.show', $lesson->course) }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                Complete Course
                                <svg class="h-5 w-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Course Progress -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-8">
                        <div class="p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Course Progress</h2>
                            
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>{{ $completedLessonsCount }} of {{ $totalLessonsCount }} lessons</span>
                                    <span>{{ $courseProgress }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $courseProgress }}%"></div>
                                </div>
                            </div>

                            <div class="space-y-2">
                                @foreach($courseLessons as $courseLesson)
                                    <a href="{{ route('lessons.show', $courseLesson) }}" 
                                       class="flex items-center p-2 rounded-lg {{ $courseLesson->id === $lesson->id ? 'bg-indigo-50 text-indigo-700' : 'hover:bg-gray-50' }}">
                                        <div class="flex-shrink-0 mr-3">
                                            @if($courseLesson->isCompletedBy(auth()->user()))
                                                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @else
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium {{ $courseLesson->id === $lesson->id ? 'text-indigo-700' : 'text-gray-900' }} truncate">
                                                {{ $courseLesson->title }}
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>

                            @if($courseProgress === 100 && !$course->certificates()->where('user_id', auth()->id())->exists())
                                <div class="mt-6">
                                    <form action="{{ route('certificates.generate', $course) }}" method="GET">
                                        <button type="submit" 
                                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                            Get Certificate
                                            <svg class="h-5 w-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 