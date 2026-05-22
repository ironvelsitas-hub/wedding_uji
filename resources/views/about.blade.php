@extends('layouts.app')

@section('title', 'Tentang Kami - Perfect Wedding')

@section('content')
<div class="container py-5 mt-5">
    <div class="row">
        <div class="col-lg-6" data-aos="fade-right">
            <h2 class="mb-4">Tentang Perfect Wedding</h2>
            <p class="lead">Didirikan pada tahun 2015, Perfect Wedding telah menjadi salah satu Wedding Organizer terpercaya di Indonesia.</p>
            <p>Kami memahami bahwa setiap pernikahan adalah unik dan istimewa. Oleh karena itu, kami berkomitmen untuk memberikan pelayanan yang personal dan detail yang sempurna untuk setiap klien kami.</p>
            <p>Dengan tim profesional yang berpengalaman, kami siap mewujudkan pernikahan impian Anda sesuai dengan budget dan keinginan Anda.</p>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
            <img src="{{ asset('images/dekorasi.jpg') }}" class="img-fluid rounded" alt="About Us">
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-md-6" data-aos="fade-up">
            <h3 class="mb-4">Visi</h3>
            <p>Menjadi Wedding Organizer terkemuka di Indonesia yang dikenal dengan kreativitas, profesionalisme, dan dedikasi dalam mewujudkan pernikahan impian setiap pasangan.</p>
        </div>
        <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
            <h3 class="mb-4">Misi</h3>
            <ul>
                <li>Memberikan pelayanan terbaik yang melebihi ekspektasi klien</li>
                <li>Menciptakan momen pernikahan yang tak terlupakan dengan detail yang sempurna</li>
                <li>Bekerja sama dengan vendor terpercaya untuk hasil terbaik</li>
                <li>Terus berinovasi dalam konsep dan dekorasi pernikahan</li>
            </ul>
        </div>
    </div>
    


    
    <div class="row mt-5">
        <h3 class="text-center mb-5" data-aos="fade-up">Tim Kami</h3>
        <div class="col-md-4 text-center" data-aos="fade-up" data-aos-delay="0">
            <img src="{{ asset('images/about.jpg') }}" class="rounded-circle mb-3" width="200" height="200" alt="Team">
            <h5>Sarah Wijaya</h5>
            <p class="text-muted">Founder & Wedding Planner</p>
        </div>
        <div class="col-md-4 text-center" data-aos="fade-up" data-aos-delay="100">
            <img src="{{ asset('images/about.jpg') }}" class="rounded-circle mb-3" width="200" height="200" alt="Team">
            <h5>Budi Santoso</h5>
            <p class="text-muted">Creative Director</p>
        </div>
        <div class="col-md-4 text-center" data-aos="fade-up" data-aos-delay="200">
            <img src="{{ asset('images/about.jpg') }}" class="rounded-circle mb-3" width="200" height="200" alt="Team">
            <h5>Linda Susanti</h5>
            <p class="text-muted">Event Coordinator</p>
        </div>
    </div>
</div>
@endsection