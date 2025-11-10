<!-- ======= Contact Section ======= -->
<section id="contact" class="contact bg-white py-5">

  <div class="container" data-aos="fade-up">
    <div class="section-header text-center mb-5">
      <h2 class="fw-bold text-dark">Contact Us</h2>
      <p class="text-muted">Need help or service? Reach out to MEU GearUp anytime — we’ll get your motorcycle back on the road!</p>
    </div>

    <div class="row gy-4">

      <!-- Contact Info -->
      <div class="col-lg-5 d-flex flex-column justify-content-center" data-aos="fade-right" data-aos-delay="200">
        <div class="info-box d-flex align-items-start mb-4 p-4 rounded-4 shadow-sm border">
          <i class="bi bi-geo-alt-fill fs-3 text-primary me-3"></i>
          <div>
            <h5 class="fw-bold text-dark mb-1">Our Location</h5>
            <p class="text-muted mb-0">Singko | Masipit | Baco</p>
          </div>
        </div>

        <div class="info-box d-flex align-items-start mb-4 p-4 rounded-4 shadow-sm border">
          <i class="bi bi-telephone-fill fs-3 text-primary me-3"></i>
          <div>
            <h5 class="fw-bold text-dark mb-1">Call Us</h5>
            <p class="text-muted mb-0">+63 987 654 3210</p>
          </div>
        </div>

        <div class="info-box d-flex align-items-start p-4 rounded-4 shadow-sm border">
          <i class="bi bi-envelope-fill fs-3 text-primary me-3"></i>
          <div>
            <h5 class="fw-bold text-dark mb-1">Email Us</h5>
            <p class="text-muted mb-0">support@meugearup.com</p>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="col-lg-7" data-aos="fade-left" data-aos-delay="300">
        <form action="forms/contact.php" method="post" class="php-email-form p-4 rounded-4 shadow-sm border bg-white">
          <div class="row gy-3">
            <div class="col-md-6">
              <input type="text" name="name" class="form-control rounded-pill" placeholder="Your Name" required>
            </div>
            <div class="col-md-6">
              <input type="email" name="email" class="form-control rounded-pill" placeholder="Your Email" required>
            </div>
            <div class="col-12">
              <input type="text" name="subject" class="form-control rounded-pill" placeholder="Subject" required>
            </div>
            <div class="col-12">
              <textarea name="message" rows="5" class="form-control rounded-4" placeholder="Your Message" required></textarea>
            </div>
            <div class="col-12 text-center">
              <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                <i class="bi bi-send-fill"></i> Send Message
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Optional Map -->
    <div class="row mt-5" data-aos="fade-up" data-aos-delay="400">
      <div class="col-12">
        <div class="map-container rounded-4 shadow-sm overflow-hidden">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15457.176067708894!2d121.0975!3d13.4155!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bce0b79f3cd56b%3A0xe2e1a741fcb9a3f!2sCalapan%20City%2C%20Oriental%20Mindoro!5e0!3m2!1sen!2sph!4v1697148000000!5m2!1sen!2sph" 
            width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ======= Contact Section CSS ======= -->
<style>
  .contact .info-box {
    background: #fff;
    transition: all 0.3s ease;
  }
  .contact .info-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
  }
  .contact .form-control {
    border-color: #dee2e6;
    transition: all 0.3s ease;
  }
  .contact .form-control:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.1);
  }
  .map-container iframe {
    border: 0;
  }
</style>
