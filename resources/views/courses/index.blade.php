@extends('layouts.app') {{-- ou student.blade.php si spécifique --}}

@section('content')
<div class="course-listing-container">
    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <h1 class="text-2xl font-bold mb-4 page-title">Liste des cours</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 course-grid">
        @foreach ($courses as $course)
            <div class="p-4 border rounded shadow course-card">
                <div class="course-header">
                    <h2 class="text-xl font-semibold course-title">{{ $course->title }}</h2>
                    <p class="text-sm text-gray-600 teacher-name">Par {{ $course->teacher->name ?? 'N/A' }}</p>
                </div>
                
                <div class="course-content">
                    <p class="mt-2 course-description">{{ $course->description }}</p>
                    <p class="mt-2 font-bold course-price {{ $course->price == 0 ? 'free-course' : '' }}">
                        {{ $course->price == 0 ? 'Gratuit' : $course->price . ' €' }}
                    </p>
                </div>

                <div class="course-footer">
                    @auth
                        @if(in_array($course->id, $enrolledCourseIds))
                            <button class="mt-3 bg-green-500 text-white px-4 py-2 rounded enrolled-button" disabled>
                                <i class="fas fa-check me-1"></i> Déjà inscrit
                            </button>
                        @else
                            <form action="{{ route('enroll', $course->id) }}" method="POST" class="mt-3">
                                @csrf
                                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 enroll-button">
                                    <i class="fas fa-sign-in-alt me-1"></i> S'inscrire
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-blue-600 mt-3 inline-block login-link">
                            <i class="fas fa-lock me-1"></i> Connectez-vous pour vous inscrire
                        </a>
                    @endauth
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    :root {
        --primary: #4361ee;
        --primary-light: #4895ef;
        --primary-dark: #3a0ca3;
        --success: #4cc9f0;
        --success-light: #90e0ef;
        --success-dark: #0077b6;
        --danger: #e63946;
        --warning: #f72585;
        --info: #4895ef;
        --secondary: #6c757d;
        --light: #f8f9fa;
        --dark: #212529;
    }
    
    body {
        background-color: #f9fafb;
        font-family: 'Inter', 'Segoe UI', Roboto, sans-serif;
    }
    
    .course-listing-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    
    .page-title {
        font-size: 1.75rem;
        color: var(--dark);
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.75rem;
    }
    
    .page-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--primary-light));
        border-radius: 2px;
    }
    
    /* Alert styles */
    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    .alert-success {
        background-color: rgba(76, 201, 240, 0.1);
        border-left: 4px solid var(--success);
        color: var(--success-dark);
    }
    
    .alert-danger {
        background-color: rgba(230, 57, 70, 0.1);
        border-left: 4px solid var(--danger);
        color: var(--danger);
    }
    
    /* Course card styles */
    .course-card {
        background: white;
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
    }
    
    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }
    
    .course-header {
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 0.75rem;
    }
    
    .course-title {
        color: var(--dark);
        font-weight: 600;
        line-height: 1.4;
        margin-bottom: 0.25rem;
    }
    
    .teacher-name {
        color: var(--secondary);
        font-size: 0.875rem;
        display: flex;
        align-items: center;
    }
    
    .teacher-name:before {
        content: '\f007';
        font-family: 'Font Awesome 6 Free';
        margin-right: 0.5rem;
        font-size: 0.75rem;
        opacity: 0.7;
    }
    
    .course-content {
        flex: 1;
        padding: 0.5rem 0;
    }
    
    .course-description {
        color: #6b7280;
        font-size: 0.95rem;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .course-price {
        font-weight: 700;
        font-size: 1.125rem;
        color: var(--primary-dark);
    }
    
    .free-course {
        color: var(--success-dark);
    }
    
    .free-course:before {
        content: '\f02b';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        margin-right: 0.5rem;
    }
    
    .course-footer {
        margin-top: auto;
        padding-top: 1rem;
    }
    
    /* Button styles */
    .bg-blue-500 {
        background-color: var(--primary) !important;
        transition: all 0.3s ease;
    }
    
    .bg-blue-500:hover {
        background-color: var(--primary-dark) !important;
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }
    
    .bg-green-500 {
        background-color: var(--success) !important;
    }
    
    .enrolled-button, .enroll-button {
        width: 100%;
        border-radius: 8px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.6rem 1rem;
    }
    
    .enrolled-button {
        cursor: not-allowed;
        opacity: 0.9;
    }
    
    .login-link {
        color: var(--primary);
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
    }
    
    .login-link:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }
    
    .me-1 {
        margin-right: 0.25rem;
    }
    
    .me-2 {
        margin-right: 0.5rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .course-grid {
            grid-template-columns: repeat(1, 1fr);
        }
    }
    
    @media (min-width: 769px) and (max-width: 1024px) {
        .course-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endpush
@endsection