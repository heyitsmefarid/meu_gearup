<section id="services" class="services section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2 class="fw-bold text-primary">Our Services</h2>
    <p>We specialize in professional motorcycle repair, maintenance, customization, and genuine parts — keeping your ride smooth, powerful, and road-ready.</p>
  </div>
  <!-- End Section Title -->

  <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">

    <!-- floating light waves -->
    <div class="bg-wave"></div>

    <div class="row gy-4">

      <!-- 1. General Maintenance -->
      <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
        <div class="service-card">
          <div class="service-image">
            <img src="img/services1.jpg" alt="General Maintenance" class="img-fluid">
          </div>
          <div class="service-content">
            <div class="service-icon"><i class="fas fa-tools"></i></div>
            <h3>General Maintenance</h3>
            <p>Oil changes, chain cleaning, tire checks, and tune-ups — everything to keep your bike in top performance.</p>
            <a href="#" class="btn-learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <!-- 2. Engine Repair -->
      <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
        <div class="service-card">
          <div class="service-image">
            <img src="img/services2.jpg" alt="Engine Repair" class="img-fluid">
          </div>
          <div class="service-content">
            <div class="service-icon"><i class="fas fa-motorcycle"></i></div>
            <h3>Engine Repair & Overhaul</h3>
            <p>From carburetor cleaning to full rebuilds, we restore your motorcycle’s power and smooth acceleration.</p>
            <a href="#" class="btn-learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <!-- 3. Electrical Work -->
      <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
        <div class="service-card">
          <div class="service-image">
            <img src="img/services3.jpg" alt="Electrical Work" class="img-fluid">
          </div>
          <div class="service-content">
            <div class="service-icon"><i class="fas fa-bolt"></i></div>
            <h3>Electrical System Repair</h3>
            <p>Expert solutions for batteries, ignition, signal lights, and wiring to keep your motorcycle reliable.</p>
            <a href="#" class="btn-learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <!-- 4. Customization -->
      <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="400">
        <div class="service-card">
          <div class="service-image">
            <img src="img/services4.jpg" alt="Customization" class="img-fluid">
          </div>
          <div class="service-content">
            <div class="service-icon"><i class="fas fa-paint-roller"></i></div>
            <h3>Motorcycle Customization</h3>
            <p>Unique designs, decals, custom paint, and exhaust mods — your bike, your personality, your rules.</p>
            <a href="#" class="btn-learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <!-- 5. Tire & Brake Service -->
      <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="500">
        <div class="service-card">
          <div class="service-image">
            <img src="img/services5.jpg" alt="Tire and Brake Service" class="img-fluid">
          </div>
          <div class="service-content">
            <div class="service-icon"><i class="fas fa-tachometer-alt"></i></div>
            <h3>Tire & Brake Service</h3>
            <p>Precision tire replacement, wheel balancing, and brake system inspection for safe and stable rides.</p>
            <a href="#" class="btn-learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <!-- 6. Motorcycle Parts -->
      <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="600">
        <div class="service-card">
          <div class="service-image">
            <img src="img/services6.jpg" alt="Parts & Accessories" class="img-fluid">
          </div>
          <div class="service-content">
            <div class="service-icon"><i class="fas fa-cogs"></i></div>
            <h3>Parts & Accessories</h3>
            <p>Genuine motorcycle parts, oils, helmets, and performance gear — we’ve got everything you need.</p>
            <a href="#" class="btn-learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<style>
.services {
  padding: 80px 0;
  background: #ffffff;
  position: relative;
  overflow: hidden;
}

.bg-wave {
  position: absolute;
  top: -100px;
  left: 0;
  width: 200%;
  height: 400px;
  background: radial-gradient(circle at 20% 20%, rgba(0,123,255,0.1), transparent 70%),
              radial-gradient(circle at 80% 80%, rgba(0,123,255,0.1), transparent 70%);
  animation: waveFloat 8s infinite ease-in-out alternate;
  z-index: 0;
}

@keyframes waveFloat {
  0% { transform: translateY(0px); }
  100% { transform: translateY(30px); }
}

.section-title {
  text-align: center;
  margin-bottom: 50px;
  z-index: 2;
  position: relative;
}

.section-title h2 {
  font-size: 2.5rem;
  font-weight: 800;
  color: #102868;
}

.section-title p {
  color: #475569;
  max-width: 700px;
  margin: 0 auto;
  font-size: 1rem;
}

.service-card {
  background: #fff;
  border-radius: 18px;
  overflow: hidden;
  transition: all 0.4s ease;
  border: 2px solid rgba(37, 99, 235, 0.1);
  position: relative;
  z-index: 1;
}

.service-card:hover {
  transform: translateY(-8px);
  border-color: #2563eb;
  box-shadow: 0 12px 30px rgba(37, 99, 235, 0.15);
}

.service-image img {
  width: 100%;
  height: 220px;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.service-card:hover .service-image img {
  transform: scale(1.1);
}

.service-content {
  padding: 25px;
  text-align: center;
  position: relative;
}

.service-icon {
  font-size: 2.5rem;
  color: #2563eb;
  margin-bottom: 15px;
  transition: transform 0.5s ease;
  animation: floatIcon 3s ease-in-out infinite;
}

@keyframes floatIcon {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-6px); }
}

.service-content h3 {
  font-size: 1.3rem;
  font-weight: 700;
  color: #102868;
  margin-bottom: 10px;
}

.service-content p {
  font-size: 0.95rem;
  color: #475569;
  line-height: 1.6;
  min-height: 80px;
}

.btn-learn-more {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  color: #2563eb;
  font-weight: 600;
  text-decoration: none;
  border: 1.5px solid #2563eb;
  border-radius: 30px;
  padding: 8px 18px;
  transition: all 0.3s ease;
}

.btn-learn-more:hover {
  background: #2563eb;
  color: #fff;
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
  transform: translateY(-2px);
}

.btn-learn-more i {
  margin-left: 8px;
  transition: transform 0.3s ease;
}

.btn-learn-more:hover i {
  transform: translateX(4px);
}

/* Responsive */
@media (max-width: 992px) {
  .service-image img { height: 200px; }
}
@media (max-width: 768px) {
  .section-title h2 { font-size: 2rem; }
}
</style>
