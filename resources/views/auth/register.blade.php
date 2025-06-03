@extends('layouts.app')

@section('title', 'Inscription - Study Course')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="modern-card p-4 p-md-5 animate-on-scroll">
                <div class="text-center mb-4">
                    <h1 class="fw-bold text-primary mb-2">Créer un compte</h1>
                    <p class="text-secondary">Rejoignez notre communauté d'apprentissage dès aujourd'hui</p>
                </div>
                
                <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                    @csrf
                    
                    <div class="row">
                        <!-- Nom -->
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label fw-medium">Nom complet</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-secondary"></i></span>
                                <input id="name" type="text" class="form-control custom-input border-start-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Entrez votre nom">
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-12 mb-3">
                            <label for="email" class="form-label fw-medium">Adresse email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-secondary"></i></span>
                                <input id="email" type="email" class="form-control custom-input border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="votre@email.com">
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Rôle -->
                        <div class="col-md-12 mb-3">
                            <label for="role" class="form-label fw-medium">Vous êtes</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-user-tag text-secondary"></i></span>
                                <select id="role" name="role" class="form-select custom-input border-start-0 @error('role') is-invalid @enderror" required>
                                    <option value="student" selected>Étudiant</option>
                                    <option value="teacher">Enseignant</option>
                                </select>
                            </div>
                            @error('role')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mot de passe -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-medium">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-secondary"></i></span>
                                <input id="password" type="password" class="form-control custom-input border-start-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="8 caractères minimum">
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirmation du mot de passe -->
                        <div class="col-md-6 mb-4">
                            <label for="password_confirmation" class="form-label fw-medium">Confirmer le mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-secondary"></i></span>
                                <input id="password_confirmation" type="password" class="form-control custom-input border-start-0" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmation">
                            </div>
                        </div>

                        <!-- Conditions d'utilisation -->
                        <div class="col-12 mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label small" for="terms">
                                    J'accepte les <a href="#" class="text-primary">conditions d'utilisation</a> et la <a href="#" class="text-primary">politique de confidentialité</a>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mb-4">
                        <button type="submit" class="btn btn-primary py-3 fw-medium">
                            <i class="fas fa-user-plus me-2"></i> Créer mon compte
                        </button>
                    </div>
                    
                    <div class="text-center">
                        <p class="mb-0 text-secondary small">Déjà inscrit ? <a href="{{ route('login') }}" class="text-primary fw-medium">Se connecter</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Section des avantages -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 text-center mb-5">
            <h2 class="fw-bold">Pourquoi nous rejoindre ?</h2>
            <p class="text-secondary">Découvrez les avantages d'apprendre avec Study Course</p>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="modern-card p-4 text-center h-100 animate-on-scroll">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-flex mb-3">
                    <i class="fas fa-laptop-code text-primary fa-2x"></i>
                </div>
                <h4 class="fw-bold mb-2">Apprentissage flexible</h4>
                <p class="text-secondary mb-0">Apprenez à votre rythme, où que vous soyez et quand vous le souhaitez</p>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="modern-card p-4 text-center h-100 animate-on-scroll">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-flex mb-3">
                    <i class="fas fa-certificate text-primary fa-2x"></i>
                </div>
                <h4 class="fw-bold mb-2">Certification reconnue</h4>
                <p class="text-secondary mb-0">Obtenez des certifications pour valoriser votre profil professionnel</p>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="modern-card p-4 text-center h-100 animate-on-scroll">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-flex mb-3">
                    <i class="fas fa-users text-primary fa-2x"></i>
                </div>
                <h4 class="fw-bold mb-2">Communauté active</h4>
                <p class="text-secondary mb-0">Rejoignez une communauté d'apprenants et partagez vos connaissances</p>
            </div>
        </div>
    </div>
</div>
@endsection