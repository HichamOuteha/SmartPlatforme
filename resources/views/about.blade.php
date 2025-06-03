@extends('layouts.app')

@section('title', 'À propos - Study Course')

@section('content')
<!-- Hero Section -->
<section class="bg-primary-subtle py-5 mb-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="fw-bold mb-4 text-primary">À propos de Study Course</h1>
                <p class="lead">Votre plateforme d'apprentissage en ligne pour développer des compétences qui comptent</p>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="container py-5">
    <!-- Our Story -->
    <div class="row mb-5 pb-5 border-bottom">
        <div class="col-lg-6 mb-4 mb-lg-0 animate-on-scroll">
            <h2 class="fw-bold text-primary mb-4">Notre Histoire</h2>
            <p class="mb-4">Fondée en 2023, Study Course est née d'une passion pour l'éducation et la conviction que l'apprentissage de qualité devrait être accessible à tous, partout.</p>
            <p>Notre équipe d'experts en éducation et en technologie a travaillé sans relâche pour créer une plateforme qui offre non seulement un contenu de haute qualité, mais aussi une expérience d'apprentissage engageante et interactive.</p>
        </div>
        <div class="col-lg-6 animate-on-scroll">
            <img src="/assets/images/about-story.jpg" alt="Notre Histoire" class="img-fluid rounded-4 shadow">
        </div>
    </div>

    <!-- Our Mission -->
    <div class="row mb-5 pb-5 border-bottom">
        <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0 animate-on-scroll">
            <h2 class="fw-bold text-primary mb-4">Notre Mission</h2>
            <p class="mb-4">Chez Study Course, notre mission est de démocratiser l'éducation en offrant des cours de qualité supérieure à un prix abordable.</p>
            <p>Nous croyons que l'éducation a le pouvoir de transformer des vies, et nous nous engageons à aider nos apprenants à atteindre leurs objectifs personnels et professionnels.</p>
        </div>
        <div class="col-lg-6 order-lg-1 animate-on-scroll">
            <img src="/assets/images/about-mission.jpg" alt="Notre Mission" class="img-fluid rounded-4 shadow">
        </div>
    </div>

    <!-- Our Team -->
    <div class="row">
        <div class="col-12 text-center mb-5 animate-on-scroll">
            <h2 class="fw-bold text-primary mb-4">Notre Équipe</h2>
            <p class="lead mb-5">Des professionnels passionnés qui rendent Study Course possible</p>
        </div>
    </div>

    <div class="row">
        <!-- Team Member 1 -->
        <div class="col-md-6 col-lg-3 mb-4 animate-on-scroll">
            <div class="card team-card h-100 border-0 shadow-sm">
                <img src="/assets/images/team-1.jpg" class="card-img-top" alt="Membre de l'équipe">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold mb-1">Sophie Martin</h5>
                    <p class="text-muted mb-3">Fondatrice & CEO</p>
                    <div class="social-icons">
                        <a href="#" class="text-muted me-2"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-muted me-2"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Member 2 -->
        <div class="col-md-6 col-lg-3 mb-4 animate-on-scroll">
            <div class="card team-card h-100 border-0 shadow-sm">
                <img src="/assets/images/team-2.jpg" class="card-img-top" alt="Membre de l'équipe">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold mb-1">Lucas Dubois</h5>
                    <p class="text-muted mb-3">Directeur Pédagogique</p>
                    <div class="social-icons">
                        <a href="#" class="text-muted me-2"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-muted me-2"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Member 3 -->
        <div class="col-md-6 col-lg-3 mb-4 animate-on-scroll">
            <div class="card team-card h-100 border-0 shadow-sm">
                <img src="/assets/images/team-3.jpg" class="card-img-top" alt="Membre de l'équipe">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold mb-1">Emma Blanc</h5>
                    <p class="text-muted mb-3">Responsable Marketing</p>
                    <div class="social-icons">
                        <a href="#" class="text-muted me-2"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-muted me-2"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Member 4 -->
        <div class="col-md-6 col-lg-3 mb-4 animate-on-scroll">
            <div class="card team-card h-100 border-0 shadow-sm">
                <img src="/assets/images/team-4.jpg" class="card-img-top" alt="Membre de l'équipe">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold mb-1">Thomas Lefèvre</h5>
                    <p class="text-muted mb-3">Lead Développeur</p>
                    <div class="social-icons">
                        <a href="#" class="text-muted me-2"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-muted me-2"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<section class="bg-primary text-white py-5 my-5">
    <div class="container py-4">
        <div class="row text-center">
            <div class="col-md-3 mb-4 mb-md-0 animate-on-scroll">
                <h2 class="display-4 fw-bold">5000+</h2>
                <p class="mb-0">Étudiants</p>
            </div>
            <div class="col-md-3 mb-4 mb-md-0 animate-on-scroll">
                <h2 class="display-4 fw-bold">200+</h2>
                <p class="mb-0">Cours</p>
            </div>
            <div class="col-md-3 mb-4 mb-md-0 animate-on-scroll">
                <h2 class="display-4 fw-bold">50+</h2>
                <p class="mb-0">Instructeurs</p>
            </div>
            <div class="col-md-3 animate-on-scroll">
                <h2 class="display-4 fw-bold">98%</h2>
                <p class="mb-0">Satisfaction</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-md-5 text-center">
                    <h2 class="fw-bold text-primary mb-4">Prêt à commencer votre parcours d'apprentissage ?</h2>
                    <p class="lead mb-4">Rejoignez notre communauté d'apprenants aujourd'hui et développez les compétences qui vous mèneront au succès.</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-primary btn-lg px-4 py-2">Découvrir nos cours</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 