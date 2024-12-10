@extends('layouts.app')

@section('content')
<div class="container-elegant animate-background">
    <div class="elegant-header">
        <h1 class="text-pink elegant-title">About Bless Kosmetik</h1>
        <div class="elegant-divider"></div>
    </div>
    
    <!-- Deskripsi Toko -->
    <div class="about-description">
        <div class="description-grid">
            <div class="description-card description-card-1 card-hover">
                <h3 class="card-title">Surga Kecantikan</h3>
                <p class="card-text">
                    Toko Bless Kosmetik hadir sebagai oase kecantikan eksklusif, menghadirkan rangkaian produk premium yang merevolusi cara perempuan Indonesia merawat diri. Kami tidak sekadar menjual kosmetik, tetapi menciptakan pengalaman transformatif dalam setiap sentuhan kecantikan.
                </p>
            </div>
            <div class="description-card description-card-2 card-hover">
                <h3 class="card-title">Keindahan Sejati</h3>
                <p class="card-text">
                    Kami percaya kecantikan adalah ekspresi tertinggi kepercayaan diri. Setiap produk kami dirancang untuk memeluk keunikan Anda, mengubah rutinitas perawatan menjadi momen istimewa yang memanjakan dan menginspirasi.
                </p>
            </div>
            <div class="description-card description-card-3 card-hover">
                <h3 class="card-title">Filosofi Cantik</h3>
                <p class="card-text">
                    Dengan tagline revolusioner "Glow up, starts here", "Pamper yourself, you deserve it", dan "From skincare to self-care", kami menghadirkan lebih dari sekadar produk – kami menghadirkan gerakan kecantikan yang mendalam dan personal.
                </p>
            </div>
            <div class="description-card description-card-4 card-hover">
                <h3 class="card-title">Peduli Bersama</h3>
                <p class="card-text">
                    Kami berdiri teguh pada prinsip cruelty-free, dengan filosofi bahwa kecantikan sejati tidak boleh merugikan siapapun. Setiap produk adalah bukti cinta kami pada kulit Anda dan planet ini – aman, ramah, dan penuh kasih.
                </p>
            </div>
        </div>
    </div>
    
    <!-- Foto Tim -->
            <div class="team-section">
                <h2 class="text-pink elegant-title team-header">Our Fabulous Team</h2>
                <div class="team-container">
                    @foreach (range(1, 5) as $i)
                    <div class="team-member">
                        <img src="{{ asset('uploads/about/photo' . $i . '.jpg') }}" alt="Foto {{ $i }}">
                        <div class="member-overlay">
                            <p>Team Member {{ $i }}</p>
                        </div>
                    </div>
                    @endforeach
        </div>
    </div>
</div>
 @endsection 
<style>
:root {
    --primary-pink: #FF69B4;
    --secondary-pink: #FFB6C1;
    --soft-pink: #FFF0F5;
    --gradient-pink: linear-gradient(135deg, #FF69B4 0%, #FFB6C1 100%);
    --text-color: #333;
}

.container-elegant {
    background: var(--gradient-pink);
    padding: 2rem;
    border-radius: 10px;
}

.elegant-header {
    text-align: center;
    margin-bottom: 2rem;
}

.elegant-title {
    font-size: 2.5rem;
    color: var(--primary-pink);
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
    font-weight: 700;
    letter-spacing: 1px;
    background: linear-gradient(120deg, var(--primary-pink), var(--primary-pink));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    transition: all 0.3s ease;
    animation: titleFade 1s ease-in-out;
}

.elegant-title::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--primary-pink), transparent);
    transform: scaleX(0);
    animation: underlineExpand 1.5s ease-in-out forwards;
}

@keyframes titleFade {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes underlineExpand {
    from {
        transform: scaleX(0);
    }
    to {
        transform: scaleX(1);
    }
}

/* Rest of your existing styles remain the same */
.description-grid {
    display: grid;
    gap: 20px;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    margin-top: 2rem;
}

.description-card {
    background: var(--soft-pink);
    border-radius: 8px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.card-hover:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
}

.team-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    margin-top: 4rem;
    padding: 0 1rem;
    width: 100%;
    overflow-x: auto;
}

.team-header {
    margin-bottom: 1rem; 
    font-size: 2rem; 
    color: var(--primary-pink); 

.team-container {
    display: flex;
    justify-content: center;
    gap: 2rem;
    padding: 2rem 0;
    min-width: min-content;
}

.team-member {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    width: 200px; 
    height: 200px; 
    flex-shrink: 0; 
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.team-member img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.team-member:hover {
    transform: translateY(-10px) scale(1.05);
    box-shadow: var(--hover-shadow);
}

.team-member:hover img {
    transform: scale(1.1);
}

.member-overlay {
    position: absolute;
    bottom: 0;
    width: 100%;
    background: rgba(255, 105, 180, 0.8);
    backdrop-filter: blur(5px);
    color: white;
    text-align: center;
    padding: 1rem;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.team-member:hover .member-overlay {
    transform: translateY(0);
}

.animate-background {
    background: linear-gradient(-45deg, var(--soft-pink), #FFFFFF, var(--secondary-pink), #FFE4E1);
    background-size: 400% 400%;
    animation: gradient-animation 15s ease infinite;
    position: relative;
    z-index: 1;
}

@keyframes gradient-animation {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    .container-elegant {
        padding: 2rem;
    }
    
    .elegant-title {
        font-size: 2.5rem;
    }
    
    .description-grid {
        gap: 20px;
    }
}

@media screen and (max-width: 480px) {
    .container-elegant {
        padding: 1.5rem;
    }
    
    .elegant-title {
        font-size: 2rem;
    }
    
    .card-title {
        font-size: 1.3rem;
    }
    
    .card-text {
        font-size: 1rem;
    }
}
</style>