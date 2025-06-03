@extends('layouts.app')

@section('title', 'Résultats de recherche - Study Course')

@section('content')
<!-- Hero Section -->
<section class="bg-primary-subtle py-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="fw-bold mb-4 text-primary">Résultats de recherche</h1>
                <p class="lead mb-5">Résultats pour : <span class="fw-bold">{{ $query }}</span></p>
                
                <!-- Search form -->
                <div class="mx-auto" style="max-width: 600px;">
                    <form action="{{ route('search') }}" method="GET" class="d-flex">
                        <div class="input-group input-group-lg">
                            <input type="text" name="q" class="form-control" placeholder="Rechercher un cours..." value="{{ $query }}" aria-label="Rechercher">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Results Section -->
<section class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">{{ $courses->total() }} cours trouvés</h2>
        </div>
    </div>

    @if($courses->count() > 0)
        <div class="row">
            @foreach($courses as $course)
                <div class="col-md-6 col-lg-4 mb-4 animate-on-scroll">
                    <x-course-card 
                        :image="$course->thumbnail ? asset('storage/' . $course->thumbnail) : '/assets/images/default-course.jpg'"
                        :badge="$course->level"
                        :badgeColor="$course->level == 'beginner' ? 'bg-success-subtle text-success' : ($course->level == 'intermediate' ? 'bg-warning-subtle text-warning' : 'bg-danger-subtle text-danger')"
                        :price="$course->price > 0 ? $course->price . '€' : 'Gratuit'"
                        :title="$course->title"
                        :description="Str::limit($course->description, 100)"
                        :duration="$course->duration ?? '0h'"
                        :students="$course->enrollments_count ?? 0"
                        :instructor="$course->teacher->name"
                        :instructorImage="$course->teacher->profile_photo_url ?? '/assets/images/default-avatar.jpg'"
                        :link="route('courses.show', $course)"
                        :rating="$course->ratings_avg_rating ?? 0"
                    />
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $courses->appends(['q' => $query])->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-search fa-5x text-muted"></i>
            </div>
            <h3 class="mb-3">Aucun résultat trouvé</h3>
            <p class="lead mb-4">Nous n'avons pas trouvé de cours correspondant à votre recherche.</p>
            <p>Essayez d'autres mots-clés ou consultez notre catalogue complet de cours.</p>
            <a href="{{ route('courses.index') }}" class="btn btn-primary mt-3">Voir tous les cours</a>
        </div>
    @endif
</section>

<!-- Related Categories Section -->
<section class="bg-light py-5 my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center animate-on-scroll">
                <h2 class="fw-bold text-primary mb-4">Parcourir par catégorie</h2>
                <p class="lead mb-5">Explorez nos cours par domaine d'expertise</p>
                
                <div class="row justify-content-center g-4">
                    <div class="col-6 col-md-3">
                        <a href="{{ route('courses.index', ['category' => 'programming']) }}" class="text-decoration-none">
                            <div class="category-card p-4 rounded-4 bg-white shadow-sm h-100 d-flex flex-column align-items-center">
                                <div class="icon-box bg-primary-subtle text-primary rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                    <i class="fas fa-code fa-2x"></i>
                                </div>
                                <h5 class="mb-0 text-dark">Programmation</h5>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-6 col-md-3">
                        <a href="{{ route('courses.index', ['category' => 'design']) }}" class="text-decoration-none">
                            <div class="category-card p-4 rounded-4 bg-white shadow-sm h-100 d-flex flex-column align-items-center">
                                <div class="icon-box bg-success-subtle text-success rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                    <i class="fas fa-palette fa-2x"></i>
                                </div>
                                <h5 class="mb-0 text-dark">Design</h5>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-6 col-md-3">
                        <a href="{{ route('courses.index', ['category' => 'business']) }}" class="text-decoration-none">
                            <div class="category-card p-4 rounded-4 bg-white shadow-sm h-100 d-flex flex-column align-items-center">
                                <div class="icon-box bg-info-subtle text-info rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                    <i class="fas fa-chart-line fa-2x"></i>
                                </div>
                                <h5 class="mb-0 text-dark">Business</h5>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-6 col-md-3">
                        <a href="{{ route('courses.index', ['category' => 'marketing']) }}" class="text-decoration-none">
                            <div class="category-card p-4 rounded-4 bg-white shadow-sm h-100 d-flex flex-column align-items-center">
                                <div class="icon-box bg-warning-subtle text-warning rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                    <i class="fas fa-bullhorn fa-2x"></i>
                                </div>
                                <h5 class="mb-0 text-dark">Marketing</h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate-on-scroll">
                <div class="card-body p-md-5 text-center">
                    <h2 class="fw-bold text-primary mb-4">Vous ne trouvez pas ce que vous cherchez ?</h2>
                    <p class="lead mb-4">Parcourez notre catalogue complet de cours ou contactez-nous pour des suggestions personnalisées.</p>
                    <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                        <a href="{{ route('courses.index') }}" class="btn btn-primary btn-lg px-4 py-2">Tous les cours</a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg px-4 py-2">Nous contacter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 