<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>{{ config('app.name', 'Study Course') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles -->
        <style>
            :root {
                --primary: #6C3AE7;
                --primary-dark: #5C2CD7;
                --secondary: #7C4FF1;
                --text-color: #2D3748;
                --light-bg: #F7FAFC;
            }
            
            body {
                font-family: 'Inter', sans-serif;
                color: var(--text-color);
            }
            
            .navbar {
                padding: 1rem 0;
                background-color: white !important;
            }
            
            .navbar-brand {
                font-weight: 600;
                font-size: 1.5rem;
                color: var(--primary) !important;
            }
            
            .nav-link {
                font-weight: 500;
                color: var(--text-color) !important;
                padding: 0.5rem 1rem !important;
            }
            
            .nav-link:hover {
                color: var(--primary) !important;
            }
            
            .btn-primary {
                background-color: var(--primary);
                border-color: var(--primary);
            }
            
            .btn-primary:hover {
                background-color: var(--primary-dark);
                border-color: var(--primary-dark);
            }
            
            .btn-outline-primary {
                color: var(--primary);
                border-color: var(--primary);
            }
            
            .btn-outline-primary:hover {
                background-color: var(--primary);
                border-color: var(--primary);
            }
            
            .search-box {
                border: 1px solid #E2E8F0;
                border-radius: 8px;
                padding: 0.5rem 1rem;
            }
        </style>

        @stack('styles')
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fas fa-graduation-cap me-2"></i>Study Course
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('courses.index') }}">Cours</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about') }}">À propos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('chat') }}">
                                <i class="fas fa-robot"></i> Assistant IA
                            </a>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center gap-3">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">Connexion</a>
                            <a href="{{ route('register') }}" class="btn btn-primary">Inscription</a>
                        @else
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if(Auth::user()->role === 'admin')
                                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                                    @elseif(Auth::user()->role === 'teacher')
                                        <li><a class="dropdown-item" href="{{ route('teacher.dashboard') }}">Dashboard Formateur</a></li>
                                    @else
                                        <li><a class="dropdown-item" href="{{ route('student.dashboard') }}">Mon Dashboard</a></li>
                                    @endif
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">Déconnexion</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-4" style="margin-top: 76px;">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white py-5 border-top">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <h5 class="mb-3">Study Course</h5>
                        <p class="text-muted">Votre plateforme d'apprentissage en ligne pour développer vos compétences et atteindre vos objectifs professionnels.</p>
                    </div>
                    <div class="col-lg-2">
                        <h5 class="mb-3">Liens rapides</h5>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('courses.index') }}" class="text-muted text-decoration-none">Cours</a></li>
                            <li><a href="{{ route('about') }}" class="text-muted text-decoration-none">À propos</a></li>
                            <li><a href="{{ route('contact') }}" class="text-muted text-decoration-none">Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2">
                        <h5 class="mb-3">Support</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-muted text-decoration-none">FAQ</a></li>
                            <li><a href="#" class="text-muted text-decoration-none">Aide</a></li>
                            <li><a href="#" class="text-muted text-decoration-none">Conditions</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h5 class="mb-3">Newsletter</h5>
                        <p class="text-muted">Restez informé de nos dernières actualités</p>
                        <form class="d-flex gap-2">
                            <input type="email" class="form-control" placeholder="Votre email">
                            <button type="submit" class="btn btn-primary">S'abonner</button>
                        </form>
                    </div>
                </div>
                <hr class="my-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="text-muted mb-md-0">© {{ date('Y') }} Study Course. Tous droits réservés.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="d-flex gap-3 justify-content-md-end">
                            <a href="#" class="text-muted"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>
</html>
