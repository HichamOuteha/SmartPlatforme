@extends('layouts.app')

@section('title', 'Connexion - Study Course')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="modern-card p-4 p-md-5 animate-on-scroll">
                <div class="text-center mb-4">
                    <h1 class="fw-bold text-primary mb-2">Connexion</h1>
                    <p class="text-secondary">Ravis de vous revoir ! Connectez-vous pour continuer</p>
                </div>
                
                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                    @csrf
                    
                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium">Adresse email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-secondary"></i></span>
                            <input id="email" type="email" class="form-control custom-input border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="votre@email.com">
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="password" class="form-label fw-medium">Mot de passe</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-primary small">Mot de passe oublié ?</a>
                            @endif
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-secondary"></i></span>
                            <input id="password" type="password" class="form-control custom-input border-start-0 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Votre mot de passe">
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                            <label class="form-check-label small" for="remember_me">
                                Se souvenir de moi
                            </label>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mb-4">
                        <button type="submit" class="btn btn-primary py-3 fw-medium">
                            <i class="fas fa-sign-in-alt me-2"></i> Connexion
                        </button>
                    </div>
                    
                    <div class="text-center">
                        <p class="mb-0 text-secondary small">Pas encore inscrit ? <a href="{{ route('register') }}" class="text-primary fw-medium">Créer un compte</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Témoignages d'utilisateurs -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 text-center mb-5">
            <h2 class="fw-bold">Ce que disent nos étudiants</h2>
            <p class="text-secondary">Rejoignez des milliers d'apprenants satisfaits</p>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="modern-card p-4 h-100 animate-on-scroll">
                <div class="d-flex mb-3">
                    <div class="text-warning me-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="text-secondary small">il y a 2 jours</span>
                </div>
                <p class="mb-4">"Les cours sont très bien structurés et les enseignants sont extrêmement compétents. J'ai acquis de nouvelles compétences en un temps record !"</p>
                <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/images/testimonial1.jpg') }}" alt="Marie Dubois" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                    <div>
                        <h6 class="fw-bold mb-0">Marie Dubois</h6>
                        <p class="text-secondary small mb-0">Développeuse Web</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="modern-card p-4 h-100 animate-on-scroll">
                <div class="d-flex mb-3">
                    <div class="text-warning me-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="text-secondary small">il y a 1 semaine</span>
                </div>
                <p class="mb-4">"La plateforme est intuitive et accessible partout. J'ai pu apprendre à mon rythme et les exercices pratiques m'ont permis de progresser rapidement."</p>
                <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/images/testimonial2.jpg') }}" alt="Thomas Martin" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                    <div>
                        <h6 class="fw-bold mb-0">Thomas Martin</h6>
                        <p class="text-secondary small mb-0">Designer UX/UI</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="modern-card p-4 h-100 animate-on-scroll">
                <div class="d-flex mb-3">
                    <div class="text-warning me-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="text-secondary small">il y a 3 jours</span>
                </div>
                <p class="mb-4">"Grâce à Study Course, j'ai pu me reconvertir dans le digital. Le support est réactif et la communauté très bienveillante. Je recommande !"</p>
                <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/images/testimonial3.jpg') }}" alt="Sophie Petit" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                    <div>
                        <h6 class="fw-bold mb-0">Sophie Petit</h6>
                        <p class="text-secondary small mb-0">Product Manager</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
