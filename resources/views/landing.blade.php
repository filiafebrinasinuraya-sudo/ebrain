<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>E-Brain Kabanjahe</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

/* =========================
GLOBAL
========================= */

html{
    scroll-behavior:smooth;
}

:root{
    --blue1:#0f4c81;
    --blue2:#1d71b8;
    --orange1:#f59e0b;
    --orange2:#ea580c;
    --dark:#0f172a;
    --light:#f8fafc;
}

body{
    font-family:'Poppins',sans-serif;
    background:var(--light);
    overflow-x:hidden;
}

.container{
    padding-left:20px;
    padding-right:20px;
}

/* =========================
NAVBAR
========================= */

.navbar{
    background:rgba(15,23,42,.75);
    backdrop-filter:blur(12px);
    transition:.3s;
    padding:18px 0;
}

.navbar.scrolled{
    background:#0f172a;
    box-shadow:0 5px 20px rgba(0,0,0,.15);
}

.navbar-brand{
    font-size:30px;
    font-weight:800;
    color:white !important;
}

.nav-link{
    color:white !important;
    margin-left:18px;
    font-weight:500;
}

.nav-link:hover{
    color:#fbbf24 !important;
}

.navbar-collapse{
    margin-top:15px;
}

.btn-login{
    background:linear-gradient(
        45deg,
        var(--orange1),
        var(--orange2)
    );

    color:white;
    border:none;
    border-radius:40px;
    padding:10px 26px;
    font-weight:700;
    text-decoration:none;
}

.btn-login:hover{
    color:white;
}

/* =========================
HERO
========================= */

.hero{
    min-height:100vh;

    display:flex;
    align-items:center;

    position:relative;
    overflow:hidden;

    background:
    linear-gradient(
        135deg,
        rgba(15,76,129,.92),
        rgba(29,113,184,.88)
    ),
    url('/images/bg-class.jpg');

    background-size:cover;
    background-position:center;

    color:white;
}

.hero::before{
    content:'';
    position:absolute;

    width:600px;
    height:600px;

    background:rgba(255,255,255,.06);

    border-radius:50%;

    top:-200px;
    right:-200px;
}

.hero::after{
    content:'';
    position:absolute;

    width:300px;
    height:300px;

    background:rgba(255,255,255,.05);

    border-radius:50%;

    bottom:-100px;
    left:-100px;
}

.hero-badge{

    background:rgba(255,255,255,.15);

    border:1px solid rgba(255,255,255,.12);

    backdrop-filter:blur(8px);

    display:inline-flex;

    align-items:center;

    gap:10px;

    padding:10px 20px;

    border-radius:30px;

    margin-bottom:28px;
}

.hero h1{
    font-size:72px;
    font-weight:800;
    line-height:1.1;
}

.hero p{
    font-size:20px;
    color:#dbeafe;

    margin-top:28px;
    margin-bottom:40px;

    max-width:600px;
}

.hero-img{
    max-height:500px;
    position:relative;
    z-index:2;
}

/* =========================
BUTTON
========================= */

.btn-main{

    background:linear-gradient(
        45deg,
        var(--orange1),
        var(--orange2)
    );

    color:white;

    border:none;

    border-radius:40px;

    padding:15px 34px;

    font-weight:700;

    text-decoration:none;

    box-shadow:0 12px 30px rgba(234,88,12,.35);
}

.btn-main:hover{
    color:white;
    transform:translateY(-2px);
}

.btn-outline-custom{

    border:2px solid white;

    color:white;

    border-radius:40px;

    padding:15px 34px;

    font-weight:700;

    text-decoration:none;
}

.btn-outline-custom:hover{
    background:white;
    color:var(--blue1);
}

/* =========================
STATS
========================= */

.stats{
    margin-top:-80px;
    position:relative;
    z-index:20;
}

.stat-box{

    background:white;

    border-radius:24px;

    padding:30px;

    text-align:center;

    box-shadow:0 10px 35px rgba(0,0,0,.08);

    transition:.3s;
}

.stat-box:hover{
    transform:translateY(-5px);
}

.stat-box h2{
    font-size:42px;
    font-weight:800;
    color:var(--blue1);
}

.stat-box p{
    color:#64748b;
    margin:0;
}

/* =========================
SECTION
========================= */

section{
    padding:100px 0;
}

.section-title{
    text-align:center;
    margin-bottom:60px;
}

.section-title h2{
    font-size:44px;
    font-weight:800;
    color:var(--dark);
}

.section-title p{
    color:#64748b;
    margin-top:15px;
}

/* =========================
FEATURE
========================= */

.feature-card{

    background:white;

    border-radius:28px;

    padding:35px;

    height:100%;

    transition:.3s;

    box-shadow:0 10px 30px rgba(0,0,0,.05);
}

.feature-card:hover{
    transform:translateY(-10px);
}

.feature-icon{

    width:80px;
    height:80px;

    border-radius:20px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:30px;

    margin-bottom:25px;

    background:linear-gradient(
        45deg,
        #dbeafe,
        #bfdbfe
    );

    color:var(--blue1);
}

/* =========================
PROGRAM
========================= */

.program-card{

    border-radius:30px;

    overflow:hidden;

    position:relative;

    height:500px;

    box-shadow:0 15px 40px rgba(0,0,0,.12);
}

.program-card img{

    width:100%;
    height:100%;

    object-fit:cover;
}

.program-overlay{

    position:absolute;

    inset:0;

    background:
    linear-gradient(
        to top,
        rgba(0,0,0,.85),
        rgba(0,0,0,.15)
    );

    display:flex;

    flex-direction:column;

    justify-content:end;

    padding:40px;

    color:white;
}

.program-overlay h3{
    font-size:34px;
    font-weight:800;
}

.program-overlay p{
    color:#e2e8f0;
}

/* =========================
SYSTEM
========================= */

.system-box{

    background:linear-gradient(
        135deg,
        var(--blue1),
        var(--blue2)
    );

    border-radius:35px;

    padding:60px;

    color:white;
}

.system-item{

    display:flex;

    gap:18px;

    margin-bottom:25px;
}

.system-item i{
    font-size:26px;
    margin-top:5px;
}

/* =========================
CTA
========================= */

.cta{

    background:
    linear-gradient(
        135deg,
        var(--orange1),
        var(--orange2)
    );

    border-radius:40px;

    padding:70px;

    color:white;

    text-align:center;
}

/* =========================
FOOTER
========================= */

footer{

    background:var(--dark);

    color:#cbd5e1;

    padding:80px 0 30px;
}

.footer-title{
    color:white;
    font-weight:700;
    margin-bottom:20px;
}

.social-icon{

    width:45px;
    height:45px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    background:rgba(255,255,255,.08);

    color:white;

    text-decoration:none;
}

.social-icon:hover{
    background:var(--orange1);
    color:white;
}

/* =========================
RESPONSIVE
========================= */

@media(max-width:991px){

    .hero{
        text-align:center;
        padding-top:120px;
    }

    .hero h1{
        font-size:50px;
    }

    .hero p{
        margin-left:auto;
        margin-right:auto;
    }

}

@media(max-width:768px){

    section{
        padding:80px 0;
    }

    .hero h1{
        font-size:42px;
    }

    .hero p{
        font-size:17px;
    }

    .hero-img{
        max-height:320px;
    }

    .section-title h2{
        font-size:34px;
    }

    .program-card{
        height:350px;
    }

    .gallery-img{
        height:220px;
    }

    .cta{
        padding:45px 25px;
        border-radius:25px;
    }

    .system-box{
        padding:35px 25px;
    }

}

@media(max-width:576px){

    .btn-main,
    .btn-outline-custom{

        width:100%;
        text-align:center;
    }

}

</style>
</head>

<body>

<!-- =========================
NAVBAR
========================= -->

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">

    <div class="container">

            <a class="navbar-brand" href="#">
                E-Brain
            </a>

            <button class="navbar-toggler"
                    data-bs-toggle="collapse"
                    data-bs-target="#menu">

            <span class="navbar-toggler-icon"></span>

        </button>

    <div class="collapse navbar-collapse" id="menu">

<ul class="navbar-nav ms-auto align-items-lg-center">

<li class="nav-item">
<a class="nav-link" href="#home">Home</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#about">Tentang</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#program">Program</a>
</li>



<li class="nav-item ms-lg-3">

<a href="/login" class="btn-login">

Masuk Sistem

</a>

</li>

</ul>

</div>

</div>

</nav>

<!-- =========================
HERO
========================= -->

<section id="home" class="hero">

<div class="container position-relative" style="z-index:2;">

<div class="row align-items-center gy-5">

<div class="col-lg-6">

    <h1>
    Belajar Jadi
    Lebih Terarah
    dan Modern.
    </h1>

    <p>

    E-Brain membantu siswa meningkatkan prestasi
    akademik melalui pembelajaran modern,
    tentor profesional, dan monitoring belajar
    yang terintegrasi.

    </p>

<div class="d-flex gap-3 flex-wrap">

</div>

</div>

<div class="col-lg-6 text-center">

<img src="{{ asset('images/logo ebrain3.png') }}"
class="img-fluid hero-img">

</div>

</div>

</div>

</section>

<!-- =========================
ABOUT
========================= -->

<section id="about">

<div class="container">

<div class="section-title">

<h2>
Tentang E-Brain
</h2>

<p>

E-Brain merupakan lembaga bimbingan belajar modern
yang membantu siswa SD, SMP, dan SMA meningkatkan
prestasi akademik secara efektif dan terarah.

</p>

</div>

<div class="row g-4">

<div class="col-md-4">

<div class="feature-card">

<div class="feature-icon">

<i class="fa-solid fa-user-graduate"></i>

</div>

<h4 class="fw-bold mb-3">

Fokus Prestasi

</h4>

<p class="text-muted">

Pembelajaran dirancang untuk meningkatkan
pemahaman dan prestasi akademik siswa.

</p>

</div>

</div>

<div class="col-md-4">

<div class="feature-card">

<div class="feature-icon">

<i class="fa-solid fa-chalkboard-user"></i>

</div>

<h4 class="fw-bold mb-3">

Tentor Profesional

</h4>

<p class="text-muted">

Dibimbing oleh pengajar berpengalaman
dan kompeten di bidangnya.

</p>

</div>

</div>

<div class="col-md-4">

<div class="feature-card">

<div class="feature-icon">

<i class="fa-solid fa-chart-line"></i>

</div>

<h4 class="fw-bold mb-3">

Monitoring Belajar

</h4>

<p class="text-muted">

Perkembangan siswa dapat dipantau
melalui sistem akademik terintegrasi.

</p>

</div>

</div>

</div>

</div>

</section>

<!-- =========================
PROGRAM
========================= -->

<section id="program" class="bg-white">

<div class="container">

<div class="section-title">

<h2>
Program E-Brain
</h2>

<p>

Program belajar unggulan dengan metode modern
dan pembelajaran terarah.

</p>

</div>

<!-- ======================
PROGRAM UNGGULAN
====================== -->

<div class="row align-items-center gy-5 mb-5">

<!-- IMAGE -->
<div class="col-lg-4">

<div class="position-relative">

<img src="{{ asset('images/unggulan.jpeg') }}"
     class="img-fluid rounded-5 shadow-lg">

<div class="position-absolute top-0 start-0
            bg-danger text-white px-4 py-2
            rounded-pill m-4 fw-bold">

🔥 Program Unggulan

</div>

</div>

</div>

<!-- CONTENT -->
<div class="col-lg-6">

<span class="badge bg-primary px-3 py-2 mb-3">

Program Unggulan

</span>

<h2 class="fw-bold mb-4 display-6">

Persiapan PTN,
Kedinasan, dan TNI/Polri

</h2>

<p class="text-muted mb-4">

Program intensif dengan pembelajaran terarah
untuk membantu siswa mempersiapkan ujian
masuk perguruan tinggi dan sekolah kedinasan.

</p>

<div class="row g-3 mb-4">

<div class="col-6">

<div class="bg-light rounded-4 p-3">

✅ Try Out Rutin

</div>

</div>

<div class="col-6">

<div class="bg-light rounded-4 p-3">

✅ Pembahasan Intensif

</div>

</div>

<div class="col-6">

<div class="bg-light rounded-4 p-3">

✅ Mentor Profesional

</div>

</div>

<div class="col-6">

<div class="bg-light rounded-4 p-3">

✅ Monitoring Nilai

</div>

</div>

</div>

</div>

</div>

<!-- ======================
PROGRAM REGULER
====================== -->

<div class="row align-items-center gy-5 flex-lg-row-reverse">

<!-- IMAGE -->
<div class="col-lg-4">

<div class="position-relative">

<img src="{{ asset('images/reguler.jpeg') }}"
     class="img-fluid rounded-5 shadow-lg">

<div class="position-absolute top-0 start-0
            bg-warning text-dark px-4 py-2
            rounded-pill m-4 fw-bold">

⭐ Program Reguler

</div>

</div>

</div>

<!-- CONTENT -->
<div class="col-lg-6">

<span class="badge bg-success px-3 py-2 mb-3">

Program Reguler

</span>

<h2 class="fw-bold mb-4 display-6">

Program SD,
SMP, dan SMA

</h2>

<p class="text-muted mb-4">

Pembelajaran terstruktur sesuai kurikulum
untuk membantu siswa memahami materi sekolah
dan meningkatkan prestasi akademik.

</p>

<div class="row g-3 mb-4">

<div class="col-6">

<div class="bg-light rounded-4 p-3">

✅ Kelas Nyaman

</div>

</div>

<div class="col-6">

<div class="bg-light rounded-4 p-3">

✅ Belajar Interaktif

</div>

</div>

<div class="col-6">

<div class="bg-light rounded-4 p-3">

✅ Jadwal Teratur

</div>

</div>

<div class="col-6">

<div class="bg-light rounded-4 p-3">

✅ Quiz Berkala

</div>

</div>

</div>


</a>

</div>

</div>

</div>

</section>



<!-- =========================
     FOOTER
========================= -->

<footer class="py-4">
    <div class="container">
<footer class="py-3">
    <div class="container">

        <div class="row justify-content-between g-3">

                <!-- Kontak -->
                <div class="col-lg-5">
                    <h5 class="footer-title mb-3">Kontak</h5>

                    <p class="mb-2">
                        📍 Jl. Jamin Ginting No. 19 & 21, Ketaren,
                        Kec. Kabanjahe, Kabupaten Karo,
                        Sumatera Utara 22111
                    </p>

                    <p class="mb-0">
                        📞 0813-6003-7196
                    </p>
                </div>

                <!-- Sosial Media -->
                <div class="col-lg-3 text-lg-end">
                    <h5 class="footer-title mb-3">Sosial Media</h5>

                    <div class="d-flex gap-3 justify-content-lg-end">
                        <a href="https://www.instagram.com/e_brain2022"
                            class="social-icon"
                            target="_blank"
                            rel="noopener noreferrer">
                                <i class="fab fa-instagram"></i>
                        </a>

                        <a href="https://www.facebook.com/e.Brain23"
                            class="social-icon"
                            target="_blank"
                            rel="noopener noreferrer">
                                <i class="fab fa-facebook-f"></i>
                        </a>

                    </div>
                </div>

            </div>

            <hr class="border-secondary my-3">

            <div class="text-center">
                <p class="mb-0 small">
                    © 2026 E-Brain Kabanjahe. All Rights Reserved.
                </p>
            </div>

        </div>
</footer>
