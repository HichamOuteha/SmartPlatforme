@auth
    @if(auth()->user()->role === 'student')
        @if(auth()->user()->enrolledCourses->contains($course))
            <span class="badge bg-success">Déjà inscrit</span>
            @if(!auth()->user()->enrolledCourses->find($course->id)->pivot->completed_at)
                <form action="{{ route('courses.complete', $course) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-warning">
                        Marquer comme terminé
                    </button>
                </form>
            @else
                <span class="badge bg-primary">Terminé le {{ $course->pivot->completed_at->format('d/m/Y') }}</span>
            @endif
        @else
            <form action="{{ route('enroll', $course) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">
                    S'inscrire ({{ $course->is_free ? 'Gratuit' : $course->price.' €' }})
                </button>
            </form>
        @endif
    @endif
@endauth