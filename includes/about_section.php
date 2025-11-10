<section id="home-about" class="home-about section position-relative overflow-hidden bg-white py-5">
  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <!-- Section Title -->
    <div class="text-center mb-5">
      <h1 class="fw-bold text-primary display-5" data-aos="zoom-in" data-aos-delay="150">
        <i class="bi bi-tools me-2"></i> About <span class="text-dark">Us</span>
      </h1>
      <p class="text-muted col-lg-8 mx-auto">Driven by passion, powered by precision — MEU GearUp keeps your motorcycle running at its best, always.</p>
    </div>

    <div class="row gy-5 align-items-center">
      
      <!-- Image Side -->
      <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
        <div class="about-image position-relative">
          <div class="image-frame rounded-4 shadow-lg overflow-hidden">
            <img src="img/about.jpg" alt="MEU GearUp Workshop" class="img-fluid zoom-img">
          </div>
          <div class="experience-badge position-absolute top-100 start-50 translate-middle text-center bg-primary text-white rounded-circle shadow-lg">
            <div class="p-3">
              <span class="years fw-bold fs-3 d-block">10+</span>
              <span class="text small">Years of<br>Service</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Content Side -->
      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
        <div class="about-content">
          <h2 class="fw-bold mb-3 text-dark">Dedicated to Keeping You Riding Safely</h2>
          <p class="lead text-muted mb-4">At <strong>MEU GearUp</strong>, we’re passionate about delivering quality motorcycle services — from quick maintenance to full restorations.</p>
          <p class="text-secondary">Our skilled mechanics and technicians ensure your ride performs at its best. Whether it’s a tune-up, engine rebuild, or a custom upgrade, we handle it with precision and care.</p>

          <div class="row g-4 mt-4">
            <div class="col-md-6" data-aos="zoom-in" data-aos-delay="400">
              <div class="feature-item p-4 rounded-4 shadow-sm border text-center h-100 hover-rise">
                <div class="icon mb-3 text-primary fs-1">
                  <i class="bi bi-wrench-adjustable-circle"></i>
                </div>
                <h4 class="fw-bold text-dark">Expert Mechanics</h4>
                <p class="text-muted mb-0">Certified professionals using the latest diagnostic tools and repair methods.</p>
              </div>
            </div>

            <div class="col-md-6" data-aos="zoom-in" data-aos-delay="500">
              <div class="feature-item p-4 rounded-4 shadow-sm border text-center h-100 hover-rise">
                <div class="icon mb-3 text-primary fs-1">
                  <i class="bi bi-gear-wide-connected"></i>
                </div>
                <h4 class="fw-bold text-dark">Quality Service</h4>
                <p class="text-muted mb-0">We use only genuine parts and deliver honest, top-tier service every time.</p>
              </div>
            </div>
          </div>

          <div class="cta-wrapper mt-5 d-flex gap-3" data-aos="fade-up" data-aos-delay="600">
            <a href="services.html" class="btn btn-primary rounded-pill px-4 py-2 d-flex align-items-center gap-2">
              <i class="bi bi-bicycle"></i> Explore Our Services
            </a>
            <a href="contact.html" class="btn btn-outline-dark rounded-pill px-4 py-2 d-flex align-items-center gap-2">
              <i class="bi bi-envelope"></i> Contact Us
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Custom Styles -->
<style>
  #home-about {
    background: linear-gradient(180deg, #ffffff 0%, #f9fafb 100%);
    position: relative;
  }

  .about-image .image-frame {
    border: 6px solid #f1f1f1;
    transition: transform 0.5s ease;
  }

  .zoom-img {
    transition: transform 0.5s ease;
  }

  .image-frame:hover .zoom-img {
    transform: scale(1.05);
  }

  .experience-badge {
    width: 140px;
    height: 150px;
    border: 4px solid #fff;
    animation: floatBadge 3s ease-in-out infinite;
  }

  @keyframes floatBadge {
    0%, 100% { transform: translate(-50%, 10px); }
    50% { transform: translate(-50%, -10px); }
  }

  .feature-item {
    background-color: #fff;
    transition: all 0.3s ease;
  }

  .hover-rise:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
  }

  .cta-wrapper .btn-primary {
    background: linear-gradient(45deg, #0066ff, #00bcd4);
    border: none;
    transition: all 0.3s ease;
  }

  .cta-wrapper .btn-primary:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(0, 102, 255, 0.4);
  }

  .cta-wrapper .btn-outline-dark:hover {
    background: #212529;
    color: #fff;
    transform: scale(1.05);
  }
</style>
