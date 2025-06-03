@extends('layouts.app')

@section('title', 'Accueil - Study Course')

@section('content')
<div class="hero-section" style="background-color: #6C3AE7; min-height: 400px; padding: 80px 0;">
    <div class="container text-center text-white">
        <h1 class="display-4 mb-4" style="font-weight: 600;">Apprenez sans limites</h1>
        <p class="lead mb-5">Découvrez des milliers de cours en ligne dispensés par des experts dans leur domaine.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('courses.index') }}" class="btn btn-light btn-lg px-4">Commencer maintenant</a>
            <a href="{{ route('courses.index') }}" class="btn btn-outline-light btn-lg px-4">Explorer les cours</a>
        </div>
    </div>
</div>

<div class="features-section py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-laptop-code fa-3x mb-3 text-primary"></i>
                        <h3 class="h5 mb-3">Apprentissage en ligne</h3>
                        <p class="text-muted">Accédez à vos cours n'importe où, n'importe quand.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-certificate fa-3x mb-3 text-primary"></i>
                        <h3 class="h5 mb-3">Certification</h3>
                        <p class="text-muted">Obtenez des certificats reconnus après chaque formation.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x mb-3 text-primary"></i>
                        <h3 class="h5 mb-3">Experts qualifiés</h3>
                        <p class="text-muted">Apprenez avec les meilleurs experts du domaine.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="courses-section py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Nos cours populaires</h2>
        <div class="row g-4">
            @foreach($courses ?? [] as $course)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="{{ $course->image ?? asset('assets/images/course-default.jpg') }}" class="card-img-top" alt="{{ $course->title ?? 'Course image' }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->title ?? 'Titre du cours' }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($course->description ?? 'Description du cours', 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-primary">{{ $course->price ?? 'Gratuit' }}</span>
                            <a href="{{ route('courses.show', $course->id ?? 1) }}" class="btn btn-outline-primary">En savoir plus</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="cta-section py-5" style="background-color: #6C3AE7;">
    <div class="container text-center text-white">
        <h2 class="mb-4">Prêt à commencer votre apprentissage ?</h2>
        <p class="lead mb-4">Rejoignez des milliers d'étudiants qui apprennent déjà sur notre plateforme</p>
        <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">S'inscrire gratuitement</a>
    </div>
</div>
@endsection

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #6C3AE7 0%, #7C4FF1 100%);
    }
    .card {
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .features-section .fas {
        color: #6C3AE7;
    }
</style>
@endpush
