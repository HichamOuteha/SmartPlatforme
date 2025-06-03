<!-- Cours en cours -->
<div class="mb-5">
    <h2 class="h4 mb-4">Cours en cours</h2>
    <div class="row g-4">
        @forelse($inProgressCourses as $enrollment)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="position-relative">
                        <img src="{{ $enrollment->course->thumbnail ? Storage::url($enrollment->course->thumbnail) : asset('images/default-course.jpg') }}" 
                             alt="{{ $enrollment->course->title }}" 
                             class="card-img-top" style="height: 180px; object-fit: cover;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title mb-2">
                            <a href="{{ route('courses.show', $enrollment->course) }}" class="text-decoration-none text-dark">
                                {{ $enrollment->course->title }}
                            </a>
                        </h5>
                        <p class="card-text text-muted small mb-3">
                            Par {{ $enrollment->course->teacher->name }}
                        </p>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between text-muted small mb-1">
                                <span>Progression</span>
                                <span>{{ $enrollment->progress }}%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $enrollment->progress }}%" aria-valuenow="{{ $enrollment->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <a href="{{ route('courses.show', $enrollment->course) }}" 
                           class="btn btn-primary btn-sm">
                            Continuer l'apprentissage
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <p class="text-muted mb-3">Vous n'avez pas encore commencé de cours.</p>
                        <a href="{{ route('courses.index') }}" 
                           class="btn btn-primary">
                            Parcourir les cours
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Cours terminés -->
@if($completedCourses->isNotEmpty())
    <div class="mb-5">
        <h2 class="h4 mb-4">Cours terminés</h2>
        <div class="row g-4">
            @foreach($completedCourses as $enrollment)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="position-relative">
                            <img src="{{ $enrollment->course->thumbnail ? Storage::url($enrollment->course->thumbnail) : asset('images/default-course.jpg') }}" 
                                 alt="{{ $enrollment->course->title }}" 
                                 class="card-img-top" style="height: 180px; object-fit: cover;">
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-25">
                                <div class="bg-white rounded-circle p-3">
                                    <i class="fas fa-check text-success fa-2x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-2">
                                {{ $enrollment->course->title }}
                            </h5>
                            <p class="card-text text-muted small mb-3">
                                Par {{ $enrollment->course->teacher->name }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-success">Terminé</span>
                                @if($certificates->contains('course_id', $enrollment->course_id))
                                    <a href="{{ route('certificates.download', $certificates->where('course_id', $enrollment->course_id)->first()) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-certificate me-1"></i> Voir le certificat
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

<!-- Activité récente et recommandations -->
<div class="row g-4">
    <!-- Activité récente -->
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Activité récente</h5>
                <ul class="list-group list-group-flush">
                    @forelse($recentLessons as $completion)
                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-check text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-0">Terminé <strong>{{ $completion->lesson->title }}</strong> dans <a href="{{ route('courses.show', $completion->lesson->course) }}" class="text-primary">{{ $completion->lesson->course->title }}</a></p>
                                        <small class="text-muted">{{ $completion->completed_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-center py-4">
                            Aucune activité récente
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Cours recommandés -->
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Cours recommandés</h5>
                <div class="d-flex flex-column gap-4">
                    @foreach($recommendedCourses as $course)
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <img class="rounded" style="width: 64px; height: 64px; object-fit: cover;" 
                                     src="{{ $course->thumbnail ? Storage::url($course->thumbnail) : asset('images/default-course.jpg') }}" 
                                     alt="">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $course->title }}</h6>
                                <p class="text-muted small mb-1">Par {{ $course->teacher->name }}</p>
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= ($course->ratings_avg_rating ?? 0) ? 'text-warning' : 'text-muted' }} small"></i>
                                        @endfor
                                    </div>
                                    <small class="text-muted">({{ $course->enrollments_count }} inscrits)</small>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ms-2">
                                <a href="{{ route('courses.show', $course) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    Voir
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div> 