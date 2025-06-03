@extends('layouts.app')

@section('title', 'Contact - Study Course')

@section('content')
<!-- Hero Section -->
<section class="bg-primary-subtle py-5 mb-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="fw-bold mb-4 text-primary">Contactez-nous</h1>
                <p class="lead">Nous sommes là pour vous aider et répondre à toutes vos questions</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<div class="container py-5">
    <div class="row">
        <!-- Contact Info -->
        <div class="col-lg-5 mb-5 mb-lg-0 animate-on-scroll">
            <h2 class="fw-bold text-primary mb-4">Nos Coordonnées</h2>
            <p class="mb-5">N'hésitez pas à nous contacter pour toute question concernant nos cours, notre plateforme ou pour explorer des opportunités de partenariat.</p>
            
            <div class="contact-info">
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box bg-primary-subtle text-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-envelope fs-5"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Email</h5>
                        <p class="mb-0">contact@studycourse.com</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box bg-primary-subtle text-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-phone fs-5"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Téléphone</h5>
                        <p class="mb-0">+33 1 23 45 67 89</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box bg-primary-subtle text-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-map-marker-alt fs-5"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Adresse</h5>
                        <p class="mb-0">123 Avenue de l'Éducation<br>75001 Paris, France</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-primary-subtle text-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-clock fs-5"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Heures de Support</h5>
                        <p class="mb-0">Lun-Ven: 9h-18h<br>Sam: 10h-15h</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-5">
                <h5 class="fw-bold mb-3">Suivez-nous</h5>
                <div class="social-icons d-flex gap-3">
                    <a href="#" class="text-primary fs-4"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-primary fs-4"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-primary fs-4"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-primary fs-4"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="text-primary fs-4"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        
        <!-- Contact Form -->
        <div class="col-lg-7 animate-on-scroll">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h2 class="fw-bold text-primary mb-4">Envoyez-nous un message</h2>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Votre nom" value="{{ old('name') }}" required>
                                    <label for="name">Votre nom</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Votre email" value="{{ old('email') }}" required>
                                    <label for="email">Votre email</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="Sujet" value="{{ old('subject') }}" required>
                                <label for="subject">Sujet</label>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-floating">
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" placeholder="Votre message" style="height: 150px" required>{{ old('message') }}</textarea>
                                <label for="message">Votre message</label>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-lg px-5">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Map Section -->
<div class="container-fluid px-0 mt-5">
    <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.142047353738!2d2.3354308159024745!3d48.87456167928919!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e38f817b573%3A0x48d69c30470e7aeb!2sOp%C3%A9ra%20Garnier!5e0!3m2!1sfr!2sfr!4v1635688243625!5m2!1sfr!2sfr" 
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</div>

<!-- FAQ Section -->
<section class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5 animate-on-scroll">
                <h2 class="fw-bold text-primary mb-4">Questions Fréquemment Posées</h2>
                <p class="lead">Retrouvez les réponses aux questions les plus courantes</p>
            </div>
            
            <div class="accordion" id="faqAccordion">
                <!-- FAQ Item 1 -->
                <div class="accordion-item border mb-4 rounded-3 shadow-sm animate-on-scroll">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Comment puis-je m'inscrire à un cours ?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Pour vous inscrire à un cours, vous devez d'abord créer un compte sur notre plateforme. Ensuite, naviguez vers le cours qui vous intéresse, cliquez sur "S'inscrire" et suivez les instructions pour compléter votre inscription.
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="accordion-item border mb-4 rounded-3 shadow-sm animate-on-scroll">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Quelles sont les méthodes de paiement acceptées ?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Nous acceptons les cartes de crédit (Visa, MasterCard, American Express), PayPal, et les virements bancaires pour certains pays. Toutes les transactions sont sécurisées et cryptées.
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="accordion-item border mb-4 rounded-3 shadow-sm animate-on-scroll">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Comment obtenir un certificat de réussite ?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Pour obtenir un certificat, vous devez compléter toutes les leçons du cours et réussir l'évaluation finale avec un score minimum de 70%. Les certificats sont générés automatiquement et peuvent être téléchargés depuis votre tableau de bord.
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="accordion-item border mb-4 rounded-3 shadow-sm animate-on-scroll">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Comment devenir instructeur sur Study Course ?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Pour devenir instructeur, vous devez soumettre une candidature détaillant votre expertise et le type de cours que vous souhaitez proposer. Notre équipe examinera votre profil et vous contactera pour discuter des prochaines étapes.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-primary-subtle py-5 my-5">
    <div class="container py-4">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8 animate-on-scroll">
                <h2 class="fw-bold text-primary mb-4">Vous avez encore des questions ?</h2>
                <p class="lead mb-4">Notre équipe de support est disponible pour vous aider à tout moment.</p>
                <a href="mailto:support@studycourse.com" class="btn btn-primary btn-lg px-4 py-2">Contacter le support</a>
            </div>
        </div>
    </div>
</section>
@endsection 