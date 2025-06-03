@props([
    'image' => '/assets/images/default-course.jpg',
    'badge' => 'Débutant',
    'badgeColor' => 'bg-indigo-100 text-indigo-700',
    'price' => 'Gratuit',
    'title' => 'Titre du cours',
    'description' => 'Description du cours',
    'duration' => '10h',
    'students' => '0',
    'instructor' => 'Nom de l\'instructeur',
    'instructorImage' => '/assets/images/default-avatar.jpg',
    'link' => '#',
    'rating' => 0,
])

<div class="course-card modern-card h-100">
    <div class="position-relative course-image-container">
        <img src="{{ $image }}" alt="{{ $title }}" class="w-100 rounded-top" style="height: 180px; object-fit: cover;">
        <span class="course-badge position-absolute {{ $badgeColor }} px-2 py-1 rounded-pill">{{ $badge }}</span>
    </div>
    
    <div class="p-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="d-flex align-items-center">
                <img src="{{ $instructorImage }}" alt="{{ $instructor }}" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                <span class="text-secondary small">{{ $instructor }}</span>
            </div>
            <span class="text-primary fw-bold">{{ $price }}</span>
        </div>
        
        <h5 class="fw-bold mb-2 course-title">{{ $title }}</h5>
        
        <p class="text-secondary small mb-3" style="height: 40px; overflow: hidden;">{{ $description }}</p>
        
        <div class="border-top border-bottom py-2 my-3">
            <div class="d-flex justify-content-between align-items-center text-secondary small">
                <span><i class="far fa-clock me-1"></i> {{ $duration }}</span>
                <span><i class="far fa-user me-1"></i> {{ $students }} étudiants</span>
            </div>
        </div>
        
        <div class="d-flex justify-content-between align-items-center">
            @if($rating > 0)
                <div class="d-flex align-items-center">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $rating)
                            <i class="fas fa-star text-warning"></i>
                        @elseif($i - 0.5 <= $rating)
                            <i class="fas fa-star-half-alt text-warning"></i>
                        @else
                            <i class="far fa-star text-warning"></i>
                        @endif
                    @endfor
                    <span class="ms-1 small text-secondary">{{ $rating }}/5</span>
                </div>
            @else
                <div>
                    <span class="badge bg-secondary text-white">Nouveau</span>
                </div>
            @endif
            
            <a href="{{ $link }}" class="btn btn-sm btn-outline-primary">Détails</a>
        </div>
    </div>
</div> 