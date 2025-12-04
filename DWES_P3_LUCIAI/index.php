<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Everlia</title>

    <!-- Enlace al archivo CSS del chat -->
    <link rel="stylesheet" href="css/chat.css">
    
    <!-- Enlace al archivo CSS principal -->
    <link rel="stylesheet" href="css/index.css">

    <script>
      // Mostrar/ocultar botón al hacer scroll
      window.addEventListener('scroll', function() {
        const btn = document.getElementById('contactoBtn');
        if (window.scrollY > 300) {
          btn.classList.add('visible');
        } else {
          btn.classList.remove('visible');
        }
      });

      // Suavizar scroll al hacer clic
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            target.scrollIntoView({
              behavior: 'smooth'
            });
          }
        });
      });
    </script>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="./views/estilo.css">
    
  </head>
<body>
    <?php include_once "./views/menu.php"; ?>
    
    <main>
       
  <!-- seccion 1 -->
  <div class="seccion1">
    <div class="text-center">
      <h1>Diseña tu boda soñada</h1>
      <p>Todo lo que necesitas para tu día especial y más allá.</p>
      <a href="#shop" class="btn btn-custom btn-lg"> Explora ahora </a>
    </div>
  </div>


  <!-- Productos a la venta-->
  <section class="py-5" style="background: linear-gradient(135deg, #fff9fb 0%, #fff 100%);">
    <div class="container">
      <h2 class="text-center mb-5 section-title">A la venta</h2>
      <div class="row g-4">
        <!-- Decoración -->
        <div class="col-md-4">
          <div class="product-card">
            <div class="product-img-container">
              <img src="./imagenes/decoracion.jpg" class="product-img" alt="Decoración para bodas">
              <div class="product-overlay">
                <div class="product-info">
                  <h5>Decoración</h5>
                  <p>Decora a tu gusto tu gran día con nuestros servicios personalizados</p>
                  <span class="price-badge">Desde 30€</span>
                  <a href="./decoracion.php" class="btn btn-custom mt-3">Explorar</a>
                </div>
              </div>
            </div>
            <div class="product-preview">
              <h5>Decoración</h5>
              <p>Decora a tu gusto tu gran día</p>
            </div>
          </div>
        </div>

        <!-- Vestidos y Trajes -->
        <div class="col-md-4">
          <div class="product-card">
            <div class="product-img-container">
              <img src="./imagenes/trajeBoda.jpg" class="product-img" alt="Vestidos y trajes">
              <div class="product-overlay">
                <div class="product-info">
                  <h5>Vestidos y Trajes</h5>
                  <p>Encuentra el vestido o traje perfecto para tu día especial</p>
                  <span class="price-badge">Desde 380€</span>
                  <a href="./vestidos_trajes.php" class="btn btn-custom mt-3">Descubrir</a>
                </div>
              </div>
            </div>
            <div class="product-preview">
              <h5>Vestidos y Trajes</h5>
              <p>El vestido perfecto para ti</p>
            </div>
          </div>
        </div>

        <!-- Ramos de flores -->
        <div class="col-md-4">
          <div class="product-card">
            <div class="product-img-container">
              <img src="./imagenes/ramoFlores.jpg" class="product-img" alt="Ramos de flores">
              <div class="product-overlay">
                <div class="product-info">
                  <h5>Ramos de Flores</h5>
                  <p>Selecciona entre nuestra amplia variedad de flores y colores</p>
                  <span class="price-badge">Desde 100€</span>
                  <a href="./ramos_flores.php" class="btn btn-custom mt-3">Ver más</a>
                </div>
              </div>
            </div>
            <div class="product-preview">
              <h5>Ramos de flores</h5>
              <p>Flores frescas para tu día especial</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  </style>

  <!-- Por qué elegirnos -->
  <section class="py-5" style="background-color: #f8f9fa; background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYwZjkiIGZpbGwtb3BhY2l0eT0iMC42Ij48cGF0aCBkPSJNMCAwaDQwdjQwSDB6Ii8+PC9nPjwvZz48L3N2Zz4=');">
    <div class="container">
      <h2 class="text-center mb-5">¿Por qué elegirnos?</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="flip-card">
            <div class="flip-card-inner">
              <div class="flip-card-front">
                <div class="feature-icon">💍</div>
                <h4>Experiencia</h4>
              </div>
              <div class="flip-card-back">
                <p>Más de 5 años ayudando a parejas a planificar su día especial con atención personalizada y soluciones creativas para cada necesidad.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="flip-card">
            <div class="flip-card-inner">
              <div class="flip-card-front">
                <div class="feature-icon">🎁</div>
                <h4>Regalos Únicos</h4>
              </div>
              <div class="flip-card-back">
                <p>Amplia selección de regalos personalizados y experiencias inolvidables que harán de tu boda un evento inolvidable.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="flip-card">
            <div class="flip-card-inner">
              <div class="flip-card-front">
                <div class="feature-icon">✈️</div>
                <h4>Viajes Soñados</h4>
              </div>
              <div class="flip-card-back">
                <p>Destinos exclusivos y paquetes personalizados para tu luna de miel perfecta. ¡Hacemos realidad tus sueños de viaje!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <style>
    .flip-card {
      background-color: transparent;
      perspective: 1000px;
      height: 250px;
      cursor: pointer;
    }
    
    .flip-card-inner {
      position: relative;
      width: 100%;
      height: 100%;
      text-align: center;
      transition: transform 0.8s;
      transform-style: preserve-3d;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      border-radius: 15px;
    }
    
    .flip-card:hover .flip-card-inner {
      transform: rotateY(180deg);
    }
    
    .flip-card-front, .flip-card-back {
      position: absolute;
      width: 100%;
      height: 100%;
      -webkit-backface-visibility: hidden;
      backface-visibility: hidden;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 20px;
      border-radius: 15px;
      background: white;
    }
    
    .flip-card-back {
      transform: rotateY(180deg);
      background: linear-gradient(135deg, #fff5f9 0%, #fff 100%);
    }
    
    .flip-card h4 {
      margin: 15px 0;
      color: #333;
    }
    
    .flip-card p {
      color: #666;
      font-size: 0.95rem;
      line-height: 1.6;
    }
    
    .feature-icon {
      font-size: 2.5rem;
      margin-bottom: 15px;
      background: linear-gradient(45deg, #ff69b4, #ff8c66);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      color: transparent;
    }
  </style>

  <!-- Testimonios -->
  <section class="py-5" style="background: white;">
    <div class="container">
      <h2 class="text-center mb-5 section-title">Lo que dicen nuestros clientes</h2>
      <div class="testimonial-slider">
        <div class="testimonial-track">
          <!-- Testimonio 1 -->
          <div class="testimonial-slide active">
            <div class="testimonial-card">
              <div class="testimonial-content">
                <div class="quote-icon">"</div>
                <p class="testimonial-text">Gracias a Everlia pudimos organizar nuestra boda perfectamente. Desde la decoración hasta los pequeños detalles, todo fue exactamente como lo soñamos. ¡Los regalos fueron increíbles y el servicio excepcional!</p>
                <div class="testimonial-author">
                  <img src="./imagenes/testimonio1.jpg" alt="María y Juan" class="testimonial-avatar">
                  <div class="author-info">
                    <h5>María y Juan</h5>
                    <span class="wedding-date">Boda en 2023</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Testimonio 2 -->
          <div class="testimonial-slide">
            <div class="testimonial-card">
              <div class="testimonial-content">
                <div class="quote-icon">"</div>
                <p class="testimonial-text">La luna de miel en Bali fue un sueño hecho realidad. El equipo de Everlia se encargó de cada detalle, desde el vuelo hasta las excursiones. ¡Todo perfecto y sin preocupaciones!</p>
                <div class="testimonial-author">
                  <img src="./imagenes/testimonio2.jpg" alt="Ana y Carlos" class="testimonial-avatar">
                  <div class="author-info">
                    <h5>Ana y Carlos</h5>
                    <span class="wedding-date">Luna de Miel 2024</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Testimonio 3 -->
          <div class="testimonial-slide">
            <div class="testimonial-card">
              <div class="testimonial-content">
                <div class="quote-icon">"</div>
                <p class="testimonial-text">La decoración y los detalles fueron exactamente como los soñamos. El equipo de Everlia captó perfectamente nuestra visión y la hizo realidad. ¡Nuestros invitados quedaron impresionados!</p>
                <div class="testimonial-author">
                  <img src="./imagenes/testimonio3.jpg" alt="Laura y Pedro" class="testimonial-avatar">
                  <div class="author-info">
                    <h5>Laura y Pedro</h5>
                    <span class="wedding-date">Boda en 2024</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Controles del slider -->
        <button class="testimonial-nav prev">
          <span class="arrow">❮</span>
        </button>
        <button class="testimonial-nav next">
          <span class="arrow">❯</span>
        </button>
        
        <!-- Indicadores -->
        <div class="testimonial-dots">
          <span class="dot active" data-slide="0"></span>
          <span class="dot" data-slide="1"></span>
          <span class="dot" data-slide="2"></span>
        </div>
      </div>
    </div>
  </section>
  
  <style>
    /* Estilos específicos para la página de inicio */
    .testimonial-slider {
      position: relative;
      max-width: 900px;
      margin: 0 auto;
      padding: 0 40px;
    }
    
    .testimonial-track {
      position: relative;
      min-height: 300px;
      overflow: hidden;
    }
    
    .testimonial-slide {
      position: absolute;
      width: 100%;
      opacity: 0;
      transition: all 0.5s ease-in-out;
      transform: translateX(100%);
    }
    
    .testimonial-slide.active {
      opacity: 1;
      transform: translateX(0);
      position: relative;
    }
    
    .testimonial-card {
      background: white;
      border-radius: 15px;
      padding: 40px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.05);
      position: relative;
      transition: all 0.3s ease;
      border: 1px solid rgba(0,0,0,0.05);
    }
    
    .testimonial-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }
    
    .quote-icon {
      font-size: 4rem;
      color: #ff69b4;
      line-height: 1;
      margin-bottom: 20px;
      opacity: 0.2;
      position: absolute;
      top: 10px;
      left: 20px;
    }
    
    .testimonial-content {
      position: relative;
      z-index: 1;
    }
    
    .testimonial-text {
      font-size: 1.1rem;
      line-height: 1.8;
      color: #555;
      margin-bottom: 30px;
      font-style: italic;
    }
    
    .testimonial-author {
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .testimonial-avatar {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 15px;
      border: 3px solid #ff69b4;
      box-shadow: 0 5px 15px rgba(255, 105, 180, 0.2);
    }
    
    .author-info h5 {
      margin: 0;
      color: #333;
      font-size: 1.1rem;
    }
    
    .wedding-date {
      color: #ff69b4;
      font-size: 0.85rem;
      font-weight: 500;
    }
    
    .testimonial-nav {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: white;
      border: none;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
      z-index: 10;
    }
    
    .testimonial-nav:hover {
      background: #ff69b4;
      color: white;
    }
    
    .testimonial-nav.prev {
      left: -20px;
    }
    
    .testimonial-nav.next {
      right: -20px;
    }
    
    .testimonial-dots {
      text-align: center;
      margin-top: 30px;
    }
    
    .dot {
      display: inline-block;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: #ddd;
      margin: 0 5px;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .dot.active, .dot:hover {
      background: #ff69b4;
      transform: scale(1.2);
    }
  </style>
  
  <script>
    // Script para el slider de testimonios
    document.addEventListener('DOMContentLoaded', function() {
      const slides = document.querySelectorAll('.testimonial-slide');
      const dots = document.querySelectorAll('.dot');
      const prevBtn = document.querySelector('.testimonial-nav.prev');
      const nextBtn = document.querySelector('.testimonial-nav.next');
      let currentSlide = 0;
      
      function showSlide(index) {
        // Ocultar todos los slides
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        // Mostrar el slide actual
        slides[index].classList.add('active');
        dots[index].classList.add('active');
        currentSlide = index;
      }
      
      function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
      }
      
      function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
      }
      
      // Event listeners
      nextBtn.addEventListener('click', nextSlide);
      prevBtn.addEventListener('click', prevSlide);
      
      // Navegación por puntos
      dots.forEach((dot, index) => {
        dot.addEventListener('click', () => showSlide(index));
      });
      
      // Autoplay
      let slideInterval = setInterval(nextSlide, 5000);
      
      // Pausar autoplay al pasar el ratón
      const slider = document.querySelector('.testimonial-slider');
      slider.addEventListener('mouseenter', () => clearInterval(slideInterval));
      slider.addEventListener('mouseleave', () => {
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 5000);
      });
      
      // Iniciar con el primer slide
      showSlide(0);
    });
  </script>

  <!-- Carrusel de viajes -->
  <section id="trips" class="py-5" style="background: linear-gradient(135deg, #f5f9ff 0%, #edf5ff 100%);">
    <div class="container-fluid px-0">
      <h2 class="text-center mb-4">Nuestros Viajes</h2>
      <div id="tripCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="./imagenes/BALI.jpeg" class="d-block w-100" alt="Bali" style="height: 600px; object-fit: cover;">
            <div class="carousel-caption d-none d-md-block">
              <h3 class="display-5"><strong>BALI (INDONESIA)</strong></h3>
              <p class="lead">Descubre sus arrecifes de coral y disfruta de su clima tropical</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="./imagenes/ISLANDIA.jpg" class="d-block w-100" alt="Islandia" style="height: 600px; object-fit: cover;">
            <div class="carousel-caption d-none d-md-block">
              <h3 class="display-5"><strong>ISLANDIA</strong></h3>
              <p class="lead">Encuentra la paz que necesitas en sus impresionantes montañas y lagos</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="./imagenes/egipto.jpg" class="d-block w-100" alt="Egipto" style="height: 600px; object-fit: cover;">
            <div class="carousel-caption d-none d-md-block">
              <h3 class="display-5"><strong>EGIPTO</strong></h3>
              <p class="lead">Descubre los misterios de las pirámides y el río Nilo</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="./imagenes/laponia.jpg" class="d-block w-100" alt="Laponia" style="height: 600px; object-fit: cover;">
            <div class="carousel-caption d-none d-md-block">
              <h5><strong>LAPONIA</strong></h5>
              <p><strong>Vive la magia del norte de Europa y sus auroras boreales</strong></p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="./imagenes/maldivas.jpg" class="d-block w-100 h-100" alt="Maldivas">
            <div class="carousel-caption d-none d-md-block">
              <h5><strong>MALDIVAS</strong></h5>
              <p><strong>Sumérgete en el paraíso de las islas más exóticas del mundo</strong></p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="./imagenes/tanzania.jpg" class="d-block w-100 h-100" alt="Tanzania">
            <div class="carousel-caption d-none d-md-block">
              <h5><strong>TANZANIA</strong></h5>
              <p><strong>Experimenta la aventura del safari en la sabana africana</strong></p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="./imagenes/dubai.webp" class="d-block w-100 h-100" alt="Dubai">
            <div class="carousel-caption d-none d-md-block">
              <h5><strong>DUBAI</strong></h5>
              <p><strong>Descubre el lujo y la modernidad en el desierto</strong></p>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#tripCarousel" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#tripCarousel" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Siguiente</span>
        </a>
      </div>
    </div>
  </section>

  <!-- Contacto -->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <h2 class="text-center mb-4">Mantente informado</h2>
          <p class="text-center mb-4">Suscríbete para recibir nuestras ofertas especiales y novedades</p>
          <form class="row g-3 justify-content-center">
            <div class="col-md-8">
              <input type="email" class="form-control" placeholder="Tu correo electrónico" required>
            </div>
            <div class="col-md-4">
              <button type="submit" class="btn btn-custom w-100">Suscribirse</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

   
      </main>

    
    <?php include_once "./views/pie.php"; ?>



    <!-- Botón de chat flotante -->
    <div class="chat-container" id="chatContainer">
      <!-- Cabecera del chat -->
      <div class="chat-header">
        <div class="d-flex align-items-center">
          <div class="avatar">
            <i class="fas fa-user-tie"></i>
          </div>
          <div class="ms-3">
            <h6 class="mb-0">Soporte Everlia</h6>
            <small class="status online">En línea</small>
          </div>
        </div>
        <button class="btn-close-chat" id="closeChat">
          <i class="fas fa-times"></i>
        </button>
      </div>
      
      <!-- Cuerpo del chat -->
      <div class="chat-body" id="chatBody">
        <!-- Los mensajes se agregarán dinámicamente aquí -->
      </div>
      
      <!-- Entrada de mensaje -->
      <div class="chat-input">
        <input type="text" id="userMessage" placeholder="Escribe tu mensaje..." autocomplete="off">
        <button id="sendMessage">
          <i class="fas fa-paper-plane"></i>
        </button>
      </div>
    </div>
    
    <!-- Botón flotante para abrir el chat -->
    <button class="btn-chat" id="openChat">
      <i class="fas fa-comment-dots"></i>
    </button>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Elementos del chat
        const chatContainer = document.getElementById('chatContainer');
        const openChatBtn = document.getElementById('openChat');
        const closeChatBtn = document.getElementById('closeChat');
        const chatBody = document.getElementById('chatBody');
        const userMessage = document.getElementById('userMessage');
        const sendMessageBtn = document.getElementById('sendMessage');
        
        // Mostrar/ocultar chat
        openChatBtn.addEventListener('click', function() {
          chatContainer.classList.add('visible');
          openChatBtn.style.display = 'none';
          userMessage.focus();
        });
        
        closeChatBtn.addEventListener('click', function() {
          chatContainer.classList.remove('visible');
          setTimeout(() => {
            openChatBtn.style.display = 'flex';
          }, 300);
        });
        
        // Enviar mensaje al presionar Enter
        userMessage.addEventListener('keypress', function(e) {
          if (e.key === 'Enter' && userMessage.value.trim() !== '') {
            sendMessage();
          }
        });
        
        // Enviar mensaje al hacer clic en el botón
        sendMessageBtn.addEventListener('click', sendMessage);
        
        // Base de conocimiento de respuestas
        const respuestas = [
          {
            palabrasClave: ['hola', 'buenas', 'saludos', 'hi', 'hello'],
            respuesta: '¡Hola! Soy el asistente de Everlia. ¿En qué puedo ayudarte hoy? Puedes preguntarme por nuestros productos, precios o servicios.'
          },
          {
            palabrasClave: ['precio', 'cuanto cuesta', 'coste', 'cuesta', 'valen', 'precios'],
            respuesta: 'Puedes ver los precios de todos nuestros productos en las respectivas secciones de la web. ¿Te interesa ver precios de vestidos, ramos de flores o decoración? Cada producto tiene su precio detallado en su ficha.'
          },
          {
            palabrasClave: ['horario', 'abierto', 'abren', 'cierran', 'días', 'horas'],
            respuesta: 'Nuestro horario de atención es de lunes a viernes de 9:00 a 20:00 y sábados de 10:00 a 14:00. También puedes contactarnos por correo electrónico en cualquier momento.'
          },
          {
            palabrasClave: ['contacto', 'teléfono', 'email', 'correo', 'llamar'],
            respuesta: 'Puedes contactarnos de estas formas:\n- Teléfono: 900 123 456\n- Email: info@everlia.com\n- Dirección: Calle Ejemplo, 123, Madrid\n\nTambién puedes rellenar el formulario de contacto que encontrarás al final de la página.'
          },
          {
            palabrasClave: ['vestido', 'traje', 'vestidos', 'trajes', 'novia', 'novio'],
            respuesta: '¡Claro que sí! Tenemos una amplia selección de vestidos de novia y trajes. Puedes ver nuestra colección completa en la sección de "Productos" del menú principal, seleccionando la categoría de vestidos. Allí encontrarás fotos, descripciones y precios de todos los modelos disponibles.'
          },
          {
            palabrasClave: ['flores', 'ramo', 'ramos', 'flor', 'ramillete'],
            respuesta: '¡Por supuesto! Ofrecemos una gran variedad de ramos de flores frescas para bodas y eventos. Puedes ver todos nuestros diseños en la sección de "Productos" del menú, seleccionando la categoría de ramos de flores. Cada producto incluye su descripción, fotos y precio detallado.'
          },
          {
            palabrasClave: ['decoración', 'decorar', 'ornamento', 'centro', 'mesa', 'arco'],
            respuesta: 'Sí, ofrecemos servicio completo de decoración para bodas y eventos. En la sección de "Productos" encontrarás nuestra oferta de decoración, incluyendo centros de mesa, arcos florales y más. ¿Neitas ayuda para encontrar algo en concreto?'
          },
          {
            palabrasClave: ['producto', 'productos', 'artículo', 'artículos', 'tenéis', 'venden', 'vendes'],
            respuesta: 'Sí, tenemos una amplia variedad de productos para bodas. Puedes encontrar todo lo que necesitas en la sección "Productos" de nuestro menú principal. Dentro de ella, encontrarás diferentes categorías para que puedas navegar fácilmente. ¿Te gustaría que te ayude a encontrar algo específico?'
          },
          {
            palabrasClave: ['catálogo', 'ver productos', 'colección'],
            respuesta: 'Puedes ver nuestro catálogo completo en la sección "Productos" del menú principal. Allí encontrarás todas nuestras categorías disponibles. Cada producto incluye fotos, descripción detallada y precio. ¿Hay alguna categoría en particular que te interese explorar?'
          },
          {
            palabrasClave: ['gracias', 'gracias por la ayuda', 'muchas gracias', 'perfecto', 'vale'],
            respuesta: '¡De nada! Si necesitas algo más, no dudes en preguntar. Recuerda que puedes explorar nuestro catálogo en cualquier momento para ver todos nuestros productos y servicios.'
          },
          {
            palabrasClave: ['adiós', 'hasta luego', 'hasta pronto', 'chao', 'bye', 'adiós', 'hasta otra'],
            respuesta: '¡Hasta luego! Si tienes más preguntas o necesitas ayuda para encontrar algo en nuestra web, aquí estaré para ayudarte. ¡Que tengas un gran día!'
          }
        ];

        // Función para obtener respuesta basada en el mensaje del usuario
        function obtenerRespuesta(mensaje) {
          mensaje = mensaje.toLowerCase();
          
          // Buscar coincidencias de palabras clave
          for (const item of respuestas) {
            for (const palabra of item.palabrasClave) {
              if (mensaje.includes(palabra)) {
                return item.respuesta;
              }
            }
          }
          
          // Si no hay coincidencias, devolver una respuesta por defecto
          const respuestasPorDefecto = [
            '¿Podrías darme más detalles sobre lo que necesitas?',
            'No estoy seguro de entender. ¿Podrías reformular tu pregunta?',
            '¿Te gustaría que te ayude con información sobre nuestros servicios?',
            '¿Neitas ayuda con algo más específico?'
          ];
          return respuestasPorDefecto[Math.floor(Math.random() * respuestasPorDefecto.length)];
        }

        function sendMessage() {
          const message = userMessage.value.trim();
          if (message === '') return;
          
          // Agregar mensaje del usuario
          addMessage(message, 'sent');
          userMessage.value = '';
          
          // Obtener y mostrar respuesta después de un breve retraso
          setTimeout(() => {
            const respuesta = obtenerRespuesta(message);
            addMessage(respuesta, 'received');
          }, 800);
        }
        
        function addMessage(text, type) {
          const messageDiv = document.createElement('div');
          messageDiv.className = `message ${type}`;
          
          const now = new Date();
          const timeString = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes();
          
          messageDiv.innerHTML = `
            <div class="message-content">
              <p>${text}</p>
              <span class="time">${timeString}</span>
            </div>
          `;
          
          chatBody.appendChild(messageDiv);
          chatBody.scrollTop = chatBody.scrollHeight;
        }
        
        // Mostrar mensaje de bienvenida
        setTimeout(() => {
          addMessage('¡Hola! ¿En qué puedo ayudarte hoy?', 'received');
        }, 1000);
      });
    </script>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>