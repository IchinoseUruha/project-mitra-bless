@extends('layouts.app')

@section('content')
<div class="container-elegant animate-background">
    <div class="elegant-header">
        <h1 class="text-center text-pink mb-4">About Us</h1>
        <div class="elegant-divider"></div>
    </div>
    
    <!-- Deskripsi Toko -->
    <div class="about-description">
        <div class="description-grid">
            <div class="description-card description-card-1 card-hover">
                <h3 class="card-title">Paradise</h3>
                <p class="card-text" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d; text-align: justify;">
                    Bless Kosmetik adalah toko kecantikan yang menghadirkan rangkaian produk premium yang merevolusi cara perempuan Indonesia merawat diri. Kami tidak hanya menjual kosmetik, tetapi menciptakan pengalaman transformatif dalam setiap sentuhan kecantikan.
                </p>
            </div>
            <div class="description-card description-card-2 card-hover">
                <h3 class="card-title">Elegance</h3>
                <p class="card-text" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d; text-align: justify;">
                    Kami percaya bahwa kecantikan adalah ekspresi tertinggi dari kepercayaan diri. Setiap produk yang kami tawarkan dirancang untuk merangkul keunikan Anda, mengubah rutinitas perawatan kulit menjadi momen istimewa yang memanjakan dan menginspirasi.
                </p>
            </div>
            <div class="description-card description-card-3 card-hover">
                <h3 class="card-title">Philosophy</h3>
                <p class="card-text" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d; text-align: justify;">
                    Dengan tagline revolusioner "Glow up, starts here," "Pamper yourself, you deserve it," dan "From skincare to self-care," kami menawarkan lebih dari sekadar produk – kami membawa gerakan kecantikan yang mendalam dan personal.
                </p>
            </div>
            <div class="description-card description-card-4 card-hover">
                <h3 class="card-title">Care</h3>
                <p class="card-text" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d; text-align: justify;">
                    Kami berdiri teguh pada prinsip cruelty-free, dengan filosofi bahwa kecantikan sejati tidak boleh merugikan siapapun. Setiap produk adalah bukti cinta kami untuk kulit Anda dan planet ini – aman, ramah, dan penuh kasih.
                </p>
            </div>
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
    --text-color: #333; /* Ubah ke warna abu-abu gelap */
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
    color: var(--text-color); /* Warna teks diganti menjadi abu-abu gelap */
}

.card-hover:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
}

/* Tambahan untuk responsif */
@media screen and (max-width: 768px) {
    .description-card {
        font-size: 0.9rem;
    }
}
</style>
