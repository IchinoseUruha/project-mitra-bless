@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center text-pink mb-4">About Us</h1>
    
    <!-- Deskripsi Toko -->
    <div class="about-description text-center mb-5">
        <p class="text-muted mb-4" style="font-size: 1.1rem;">
            Toko Bless Kosmetik adalah destinasi kecantikan yang hadir untuk memenuhi kebutuhan perempuan Indonesia akan produk kecantikan berkualitas tinggi. Kami menyediakan berbagai pilihan produk kosmetik, skincare, dan perawatan rambut dari berbagai merek lokal dan internasional.
        </p>
        
        <p class="text-muted mb-4" style="font-size: 1.1rem;">
            Misi kami adalah meningkatkan kecantikan dan kepercayaan diri perempuan Indonesia melalui rangkaian produk yang dirancang untuk mempercantik, merawat, dan memberikan kepuasan setiap harinya.
        </p>
        
        <p class="text-muted mb-4" style="font-size: 1.1rem;">
            Dengan tagline “Glow up, starts here”, “Pamper yourself, you deserve it”, dan “From skincare to self-care”, kami berkomitmen untuk memberikan pengalaman berbelanja yang menyenangkan, dimulai dari kemasan produk yang menarik hingga formula berkualitas tinggi yang aman dan efektif.
        </p>

        <p class="text-muted mb-4" style="font-size: 1.1rem;">
            Kami berpedoman pada prinsip cruelty-free, tanpa melakukan pengujian pada hewan, dan selalu mengutamakan produk dengan bahan yang aman dan ramah di kulit. Toko Bless Kosmetik selalu mengikuti tren kecantikan global dan mendengarkan kebutuhan pelanggan, sehingga kami dapat terus berinovasi dan menyediakan produk-produk terbaik yang sesuai dengan keinginan dan kebutuhan Anda.
        </p>

        <p class="text-muted mb-4" style="font-size: 1.1rem;">
            Kami ingin setiap perempuan merasa lebih percaya diri dan cantik setiap hari dengan produk-produk dari Toko Bless.
        </p>
    </div>

    <!-- Foto Tim -->
    <h2 class="text-center text-pink mb-4">Our Team</h2>
    <div class="team-container">
        <div class="team-member">
            <img src="{{ asset('uploads/about/photo1.jpg') }}" alt="Foto 1">
            <p class="mt-3">Deskripsi 1</p>
        </div>
        <div class="team-member">
            <img src="{{ asset('uploads/about/photo2.jpg') }}" alt="Foto 2">
            <p class="mt-3">Deskripsi 2</p>
        </div>
        <div class="team-member">
            <img src="{{ asset('uploads/about/photo3.jpg') }}" alt="Foto 3">
            <p class="mt-3">Deskripsi 3</p>
        </div>
        <div class="team-member">
            <img src="{{ asset('uploads/about/photo4.jpg') }}" alt="Foto 4">
            <p class="mt-3">Deskripsi 4</p>
        </div>
        <div class="team-member">
            <img src="{{ asset('uploads/about/photo5.jpg') }}" alt="Foto 5">
            <p class="mt-3">Deskripsi 5</p>
        </div>
    </div>
</div>
@endsection

<style>
/* Warna utama */
.text-pink {
    color: #F062A8;
}

/* Container utama */
.container {
    max-width: 1200px;
    margin: 0 auto;
}

/* Styling Foto Tim */
.team-container {
    display: grid;
    grid-template-columns: repeat(5, 1fr); /* 5 kolom sejajar */
    gap: 30px; /* Jarak antar elemen */
    justify-items: center;
    align-items: center;
}

.team-member {
    text-align: center;
}

.team-member img {
    width: 150px;
    height: 150px;
    border-radius: 50%; /* Membuat foto bulat */
    border: 5px solid #F062A8; /* Border pink */
    object-fit: cover;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Tambahan untuk styling judul section */
h2 {
    font-size: 2rem;
    color: #F062A8;
    font-weight: bold;
    margin-bottom: 30px;
}

/* Responsif */
@media screen and (max-width: 768px) {
    .team-container {
        grid-template-columns: repeat(2, 1fr); /* 2 kolom untuk layar kecil */
        gap: 20px;
    }

    .team-member img {
        width: 120px;
        height: 120px;
    }

    h2 {
        font-size: 1.5rem;
    }
}
</style>
