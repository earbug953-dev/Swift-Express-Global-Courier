<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Swift Express Global Courier</title>

<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
}

/* NAVBAR */
.navbar {
    background: white;
    padding: 15px 40px;
}
.navbar-brand {
    font-weight: bold;
    color: #0d6efd;
    font-size: 22px;
}
.nav-link {
    font-weight: 500;
    margin-left: 20px;
}

/* HERO SECTION */
.hero {
    position: relative;
    height: 100vh;
    background: url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d') center/cover no-repeat;
}

/* DARK OVERLAY */
.hero::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.65);
}

/* HERO CONTENT */
.hero-content {
    position: relative;
    z-index: 2;
    height: 100%;
    display: flex;
    align-items: center;
}

/* LEFT TEXT */
.hero-text {
    color: white;
}
.hero-text h1 {
    font-size: 55px;
    font-weight: 700;
}
.hero-text p {
    font-size: 18px;
    max-width: 500px;
    opacity: 0.9;
}

/* BUTTON */
.btn-main {
    background: #0d6efd;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    font-weight: 600;
}

/* TRACKING CARD */
.track-card {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(12px);
    border-radius: 15px;
    padding: 30px;
    color: white;
}

.track-card input {
    background: transparent;
    border: 1px solid #ccc;
    color: white;
    border-radius: 10px;
    padding: 12px;
}

.track-card input::placeholder {
    color: #ddd;
}

.track-card button {
    background: #0d6efd;
    border: none;
    padding: 12px;
    border-radius: 10px;
    font-weight: 600;
}

/* MOBILE */
@media(max-width:768px){
    .hero-text h1 {
        font-size: 35px;
    }
    .hero {
        height: auto;
        padding: 60px 0;
    }
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">Swift Express Global Courier</a>

        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
<div class="container hero-content">
<div class="row w-100 align-items-center">

    <!-- LEFT TEXT -->
    <div class="col-md-6 hero-text">
        <h1>Swift Express Global Courier: Fast, Reliable, and Secure Delivery Solutions</h1>
        <p>
            At Swift Express, we're passionate about connecting you to the world. Our global courier services ensure your packages reach their destination quickly, safely, and efficiently. With a vast network of partners and cutting-edge tracking technology, we provide seamless logistics solutions for businesses and individuals alike. Whether it's urgent documents or large shipments, trust Swift Express to deliver excellence every time.
        </p>
        <button class="btn btn-main mt-3">Explore Services →</button>
    </div>

    <!-- RIGHT TRACKING -->
    <div class="col-md-5 offset-md-1">
        <div class="track-card">

            <h4 class="mb-3">Track & Trace</h4>

            <form action="{{ route('track') }}" method="POST">
                @csrf
                <input
                    type="text"
                    name="tracking_number"
                    class="form-control mb-3"
                    placeholder="Enter Tracking ID"
                    required
                >

                <button class="w-100">Track Shipment</button>
            </form>

            @if(session('error'))
                <p class="text-danger mt-3">{{ session('error') }}</p>
            @endif

        </div>
    </div>


</div>
</div>
</section>
<!-- LICENSED & VERIFIED -->
<section class="py-5 bg-light text-center">
    <div class="container">
        <h3 class="fw-bold text-primary">Licensed & Verified</h3>
        <p class="text-muted mb-4">
            We operate in compliance with international logistics regulations and maintain full transparency.
        </p>

        <div class="d-flex justify-content-center gap-4 flex-wrap">
            <div class="p-3 bg-white shadow-sm rounded" style="width:180px;">
                <strong>GOV.UK</strong>
                <p class="small text-muted">View Profile</p>
            </div>

            <div class="p-3 bg-white shadow-sm rounded" style="width:180px;">
                <strong>Endole</strong>
                <p class="small text-muted">Verify Company</p>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES -->
<section class="py-5" id="services">
    <div class="container text-center">
        <h3 class="fw-bold text-primary mb-5">Our Services</h3>

        <div class="row g-4">

            <div class="col-md-3">
                <div class="p-4 shadow-sm rounded bg-white h-100">
                    <h5>Same Day Courier</h5>
                    <p class="text-muted small">Fast and reliable same-day delivery service.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-4 shadow-sm rounded bg-white h-100">
                    <h5>Urgent Courier</h5>
                    <p class="text-muted small">Priority shipping for time-sensitive packages.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-4 shadow-sm rounded bg-white h-100">
                    <h5>Document Courier</h5>
                    <p class="text-muted small">Secure delivery of important documents.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-4 shadow-sm rounded bg-white h-100">
                    <h5>Next Day Delivery</h5>
                    <p class="text-muted small">Affordable next-day shipping worldwide.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ABOUT US -->
<section class="py-5 bg-light" id="adout">
    <div class="container">
        <div class="row align-items-center">

            <!-- IMAGE -->
            <div class="col-md-5">
                <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d"
                     class="img-fluid rounded shadow">
            </div>

            <!-- TEXT -->
            <div class="col-md-7">
                <h3 class="fw-bold text-primary">About Us</h3>
                <p class="text-muted">
                    Swift Express Global Courier Cargo is a trusted global logistics provider delivering fast, secure,
                    and efficient shipping solutions. With advanced tracking systems and a strong
                    international network, we ensure your goods reach their destination safely.
                </p>
            </div>

        </div>
    </div>
</section>
<!-- HOW CAN WE ASSIST -->
<section class="py-5" id="faq">
    <div class="container text-center">
        <h3 class="fw-bold text-primary mb-2">How Can We Assist?</h3>
        <p class="text-muted mb-5">We handle a wide range of cargo and logistics needs</p>

        <div class="row g-4">

            <!-- ITEM -->
            <div class="col-md-3 col-sm-6">
                <div class="assist-card p-3">
                    <img src="https://img.icons8.com/fluency/96/engine.png" class="mb-3">
                    <h6>Vehicle Parts</h6>
                    <p class="small text-muted">Safe transport of auto components.</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="assist-card p-3">
                    <img src="https://img.icons8.com/fluency/96/car.png" class="mb-3">
                    <h6>Vehicles</h6>
                    <p class="small text-muted">Reliable vehicle shipping worldwide.</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="assist-card p-3">
                    <img src="https://img.icons8.com/fluency/96/test-tube.png" class="mb-3">
                    <h6>Medical Kits</h6>
                    <p class="small text-muted">Secure handling of medical supplies.</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="assist-card p-3">
                    <img src="https://img.icons8.com/fluency/96/gas.png" class="mb-3">
                    <h6>Gas & Chemicals</h6>
                    <p class="small text-muted">Hazard-safe transportation services.</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="assist-card p-3">
                    <img src="https://img.icons8.com/fluency/96/oil-industry.png" class="mb-3">
                    <h6>Oil & Liquids</h6>
                    <p class="small text-muted">Handled with certified safety standards.</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="assist-card p-3">
                    <img src="https://img.icons8.com/fluency/96/battery.png" class="mb-3">
                    <h6>Batteries</h6>
                    <p class="small text-muted">Special care for hazardous batteries.</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="assist-card p-3">
                    <img src="https://img.icons8.com/fluency/96/spray.png" class="mb-3">
                    <h6>Aerosols</h6>
                    <p class="small text-muted">Safe packaging and handling.</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="assist-card p-3">
                    <img src="https://img.icons8.com/fluency/96/orange-juice.png" class="mb-3">
                    <h6>Beverages</h6>
                    <p class="small text-muted">Temperature-controlled delivery.</p>
                </div>
            </div>

        </div>
    </div>
</section>
</body>
</html>
