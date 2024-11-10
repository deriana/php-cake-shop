<?php include __DIR__ . '../../../public/views/partials/header.php' ?>


<style>
    .carousel-caption {
        background: rgba(0, 0, 0, 0.5);
        padding: 20px;
        border-radius: 5px;
    }

    .carousel-caption h5 {
        font-size: 2rem;
        color: #f8d7da;
    }

    .carousel-caption p {
        font-size: 1.2rem;
        color: #fff;
    }

    @media (max-width: 768px) {
        .carousel-caption h5 {
            font-size: 1.5rem;
        }

        .carousel-caption p {
            font-size: 1rem;
        }
    }

    .card-img-top {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .card {
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .card-body {
        text-align: center;
        padding: 15px;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
</style>
<div class="main-content">
    <!-- Hero Section -->
    <section class="hero bg-primary text-white text-center py-5">
        <h1>Selamat Datang di Toko Kue Amanda</h1>
        <p>Temukan berbagai macam kue yang enak, tekstur yang pas, dan harga yang terjangkau</p>

    </section>

    <!-- Sekilas Tentang Kami -->
    <section class="about-us py-5">
        <div class="container">
            <h2>Tentang Kami</h2>
            <p>Toko Kue Amanda berdiri sejak tahun 2023, menyediakan berbagai macam kue yang enak, dengan tekstur yang pas dan harga yang terjangkau. Kami selalu berusaha memberikan yang terbaik untuk setiap pelanggan kami!</p>
        </div>
    </section>

    <!-- Foto Kue Kami (Acak) -->
    <section class="cakes py-5">
        <div class="container">
            <h2>Foto Kue Kami</h2>
            <div class="row">
                <?php foreach ($cakes as $cake): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?= htmlspecialchars($cake['imgurl']); ?>" class="card-img-top" alt="Kue">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($cake['name']); ?></h5>
                                <p class="card-text">Harga: Rp <?= number_format($cake['price'], 3, ',', '.'); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Menu Kue (Slide Foto) -->
    <section class="menu py-5 bg-light">
        <div class="container">
            <h2>Our Menu</h2>
            <div id="cakeMenuCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="\cake-shop\assets\img\cake1.jpeg" class="d-block w-100" alt="Menu 1">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Chocolate Cake</h5>
                            <p>Delicious chocolate cake with rich frosting.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="\cake-shop\assets\img\cake2.jpeg" class="d-block w-100" alt="Menu 2">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Vanilla Dream</h5>
                            <p>Smooth vanilla cake with a creamy finish.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="\cake-shop\assets\img\cake3.jpeg" class="d-block w-100" alt="Menu 3">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Fruit Fiesta</h5>
                            <p>Fresh fruit toppings on a light and fluffy cake.</p>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#cakeMenuCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#cakeMenuCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Alamat & Kontak -->
    <section class="contact py-5">
        <div class="container">
            <h2>Alamat Kami</h2>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Alamat:</strong> Jl. Lodaya II, RT.02/RW.06, Babakan, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16128</p>
                    <p><strong>No Telp:</strong> 088 xxx xxx xxx</p>
                </div>
                <div class="col-md-6">
                    <div class="map-container">
                        <!-- Menambahkan Google Maps Embed -->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.702037174799!2d106.8066268!3d-6.5877788!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c5d32191cd27%3A0x9dbe298ad7de0e00!2sJl.+Lodaya+II%2C+Babakan%2C+Kecamatan+Bogor+Tengah%2C+Kota+Bogor%2C+Jawa+Barat+16128!5e0!3m2!1sen!2sid!4v1698926210048!5m2!1sen!2sid"
                            width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni Pelanggan -->
    <section class="testimonials py-5 bg-light">
        <div class="container">
            <h2>Apa Kata Pelanggan Kami?</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <p>"Kue-kue di Toko Kue Amanda selalu fresh dan enak. Harga terjangkau, kualitas terbaik!"</p>
                        <p><strong>- Rusdi, Bogor</strong></p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <p>"Saya sangat suka dengan pilihan kue lapis talasnya. Rasanya unik dan enak sekali!"</p>
                        <p><strong>- Amba, Jakarta</strong></p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <p>"Pelayanan cepat, dan kue-kue selalu dalam kondisi terbaik. Recommended!"</p>
                        <p><strong>- Si Imut, Bandung</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<?php include __DIR__ . '../../../public/views/partials/footer.php' ?>