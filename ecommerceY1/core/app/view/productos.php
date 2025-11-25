<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Virtual Multinegocios</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #2563eb;
            --primary-dark: #1e40af;
            --secondary-color: #f59e0b;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f9fafb;
            --white: #ffffff;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* NAVBAR */
        .navbar {
            background: var(--white);
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            box-shadow: var(--shadow-lg);
        }

        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            color: var(--text-dark);
            transition: transform 0.3s ease;
        }

        .nav-brand:hover {
            transform: scale(1.05);
        }

        .nav-logo {
            width: 50px;
            height: 50px;
            object-fit: contain;
            border-radius: 8px;
        }

        .nav-brand-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 500;
            position: relative;
            padding: 0.5rem 0;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: width 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link.active {
            color: var(--primary-color);
        }

        .nav-link.active::after {
            width: 100%;
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--secondary-color);
            color: var(--white);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .nav-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 4px;
        }

        .nav-toggle span {
            width: 25px;
            height: 3px;
            background: var(--text-dark);
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .nav-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .nav-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .nav-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        /* SLIDER */
        .slider-container {
            position: relative;
            max-width: 1280px;
            margin: 2rem auto;
            overflow: hidden;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
        }

        .slider-wrapper {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            min-width: 100%;
            position: relative;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        }

        .slide-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            width: 100%;
            padding: 0 4rem;
            gap: 4rem;
        }

        .slide-info {
            flex: 1;
            color: var(--white);
        }

        .slide-badge {
            display: inline-block;
            background: var(--secondary-color);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .slide-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .slide-description {
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }

        .slide-price {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
        }

        .slide-price span {
            font-size: 1.5rem;
            text-decoration: line-through;
            opacity: 0.7;
            margin-left: 1rem;
        }

        .slide-btn {
            display: inline-block;
            background: var(--secondary-color);
            color: var(--white);
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .slide-btn:hover {
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
        }

        .slide-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .slide-image img {
            max-width: 100%;
            max-height: 400px;
            object-fit: contain;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.3));
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* Slider Controls */
        .slider-controls {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 1rem;
            z-index: 10;
        }

        .slider-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            border: 2px solid var(--white);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .slider-dot.active {
            background: var(--white);
            width: 40px;
            border-radius: 6px;
        }

        .slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.9);
            color: var(--text-dark);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .slider-arrow:hover {
            background: var(--white);
            transform: translateY(-50%) scale(1.1);
        }

        .slider-arrow.prev {
            left: 2rem;
        }

        .slider-arrow.next {
            right: 2rem;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .nav-container {
                padding: 1rem;
            }

            .nav-menu {
                position: fixed;
                left: -100%;
                top: 70px;
                flex-direction: column;
                background: var(--white);
                width: 100%;
                padding: 2rem;
                box-shadow: var(--shadow-lg);
                transition: left 0.3s ease;
                gap: 1.5rem;
            }

            .nav-menu.active {
                left: 0;
            }

            .nav-toggle {
                display: flex;
            }

            .nav-brand-name {
                font-size: 1.25rem;
            }

            .nav-logo {
                width: 40px;
                height: 40px;
            }

            .slide {
                height: auto;
                min-height: 400px;
            }

            .slide-content {
                flex-direction: column;
                padding: 2rem 1rem;
                gap: 2rem;
            }

            .slide-info {
                text-align: center;
            }

            .slide-title {
                font-size: 2rem;
            }

            .slide-description {
                font-size: 1rem;
            }

            .slide-price {
                font-size: 2rem;
            }

            .slide-image img {
                max-height: 250px;
            }

            .slider-arrow {
                width: 40px;
                height: 40px;
                font-size: 1.25rem;
            }

            .slider-arrow.prev {
                left: 1rem;
            }

            .slider-arrow.next {
                right: 1rem;
            }
        }

        @media (max-width: 480px) {
            .slide-title {
                font-size: 1.5rem;
            }

            .slide-price {
                font-size: 1.5rem;
            }

            .slide-price span {
                font-size: 1rem;
            }

            .slider-controls {
                bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="#" class="nav-brand">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect fill='%232563eb' width='100' height='100' rx='15'/%3E%3Cpath fill='%23fff' d='M30 25h40v15H30zM25 45h50v30H25z'/%3E%3Ccircle fill='%23f59e0b' cx='50' cy='60' r='8'/%3E%3C/svg%3E" alt="Logo" class="nav-logo" id="businessLogo">
                <span class="nav-brand-name" id="businessName">Mi Tienda Pro</span>
            </a>

            <ul class="nav-menu" id="navMenu">
                <li><a href="#inicio" class="nav-link active">Inicio</a></li>
                <li><a href="#productos" class="nav-link">Productos</a></li>
                <li><a href="#nosotros" class="nav-link">Nosotros</a></li>
                <li><a href="#contacto" class="nav-link">Contacto</a></li>
                <li>
                    <a href="#carrito" class="nav-link cart-icon">
                        🛒
                        <span class="cart-badge">3</span>
                    </a>
                </li>
            </ul>

            <div class="nav-toggle" id="navToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- SLIDER -->
    <div class="slider-container">
        <div class="slider-wrapper" id="sliderWrapper">
            <!-- Slide 1 -->
            <div class="slide" style="background: linear-gradient(135deg, #2563eb, #1e40af);">
                <div class="slide-content">
                    <div class="slide-info">
                        <span class="slide-badge">OFERTA ESPECIAL</span>
                        <h1 class="slide-title">Laptop Gamer Pro X1</h1>
                        <p class="slide-description">Potencia extrema para gaming y trabajo profesional</p>
                        <div class="slide-price">$1,299 <span>$1,799</span></div>
                        <button class="slide-btn">Comprar Ahora</button>
                    </div>
                    <div class="slide-image">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 200'%3E%3Crect fill='%23374151' x='20' y='20' width='260' height='140' rx='8'/%3E%3Crect fill='%231f2937' x='30' y='30' width='240' height='110'/%3E%3Crect fill='%23f59e0b' x='130' y='145' width='40' height='5'/%3E%3Crect fill='%236b7280' x='50' y='150' width='200' height='30' rx='3'/%3E%3C/svg%3E" alt="Laptop">
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="slide" style="background: linear-gradient(135deg, #7c3aed, #5b21b6);">
                <div class="slide-content">
                    <div class="slide-info">
                        <span class="slide-badge">NUEVO LANZAMIENTO</span>
                        <h1 class="slide-title">Smartphone Ultra 5G</h1>
                        <p class="slide-description">Tecnología de punta en la palma de tu mano</p>
                        <div class="slide-price">$899 <span>$1,199</span></div>
                        <button class="slide-btn">Ver Detalles</button>
                    </div>
                    <div class="slide-image">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 150 300'%3E%3Crect fill='%231f2937' x='10' y='10' width='130' height='280' rx='20'/%3E%3Crect fill='%230ea5e9' x='20' y='30' width='110' height='240'/%3E%3Ccircle fill='%23374151' cx='75' cy='25' r='3'/%3E%3Crect fill='%23374151' x='65' y='275' width='20' height='4' rx='2'/%3E%3C/svg%3E" alt="Smartphone">
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="slide" style="background: linear-gradient(135deg, #059669, #047857);">
                <div class="slide-content">
                    <div class="slide-info">
                        <span class="slide-badge">BEST SELLER</span>
                        <h1 class="slide-title">Auriculares Pro Noise</h1>
                        <p class="slide-description">Sonido premium con cancelación de ruido activa</p>
                        <div class="slide-price">$299 <span>$399</span></div>
                        <button class="slide-btn">Agregar al Carrito</button>
                    </div>
                    <div class="slide-image">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 250'%3E%3Cpath fill='%231f2937' d='M80 100Q80 50 150 50T220 100v50Q220 180 150 180T80 150Z'/%3E%3Ccircle fill='%23374151' cx='110' cy='125' r='35'/%3E%3Ccircle fill='%23374151' cx='190' cy='125' r='35'/%3E%3Cpath fill='none' stroke='%231f2937' stroke-width='8' d='M110 80Q150 40 190 80'/%3E%3Ccircle fill='%23f59e0b' cx='110' cy='125' r='10'/%3E%3Ccircle fill='%23f59e0b' cx='190' cy='125' r='10'/%3E%3C/svg%3E" alt="Auriculares">
                    </div>
                </div>
            </div>
        </div>

        <!-- Controles -->
        <button class="slider-arrow prev" id="prevBtn">‹</button>
        <button class="slider-arrow next" id="nextBtn">›</button>
        
        <div class="slider-controls" id="sliderDots"></div>
    </div>

    <script>
        // Configuración del negocio (simulando datos del backend)
        const negocioData = {
            nombre: 'Mi Tienda Pro',
            direccion: 'Av. Principal 123, Lima',
            logo: 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\'%3E%3Crect fill=\'%232563eb\' width=\'100\' height=\'100\' rx=\'15\'/%3E%3Cpath fill=\'%23fff\' d=\'M30 25h40v15H30zM25 45h50v30H25z\'/%3E%3Ccircle fill=\'%23f59e0b\' cx=\'50\' cy=\'60\' r=\'8\'/%3E%3C/svg%3E'
        };

        // Actualizar datos del negocio
        function initNegocio() {
            document.getElementById('businessName').textContent = negocioData.nombre;
            document.getElementById('businessLogo').src = negocioData.logo;
        }

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const navToggle = document.getElementById('navToggle');
        const navMenu = document.getElementById('navMenu');

        navToggle.addEventListener('click', () => {
            navToggle.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        // Active link navigation
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                navLinks.forEach(l => l.classList.remove('active'));
                e.target.classList.add('active');
                
                // Close mobile menu
                navToggle.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });

        // SLIDER
        const sliderWrapper = document.getElementById('sliderWrapper');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const dotsContainer = document.getElementById('sliderDots');
        const slides = document.querySelectorAll('.slide');
        
        let currentSlide = 0;
        const totalSlides = slides.length;
        let autoSlideInterval;

        // Crear dots
        function createDots() {
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('div');
                dot.classList.add('slider-dot');
                if (i === 0) dot.classList.add('active');
                dot.addEventListener('click', () => goToSlide(i));
                dotsContainer.appendChild(dot);
            }
        }

        // Ir a slide específico
        function goToSlide(n) {
            currentSlide = n;
            if (currentSlide < 0) currentSlide = totalSlides - 1;
            if (currentSlide >= totalSlides) currentSlide = 0;
            
            sliderWrapper.style.transform = `translateX(-${currentSlide * 100}%)`;
            updateDots();
        }

        // Actualizar dots
        function updateDots() {
            const dots = document.querySelectorAll('.slider-dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });
        }

        // Navegación
        function nextSlide() {
            goToSlide(currentSlide + 1);
        }

        function prevSlide() {
            goToSlide(currentSlide - 1);
        }

        // Auto slide
        function startAutoSlide() {
            autoSlideInterval = setInterval(nextSlide, 5000);
        }

        function stopAutoSlide() {
            clearInterval(autoSlideInterval);
        }

        // Event listeners
        nextBtn.addEventListener('click', () => {
            nextSlide();
            stopAutoSlide();
            startAutoSlide();
        });

        prevBtn.addEventListener('click', () => {
            prevSlide();
            stopAutoSlide();
            startAutoSlide();
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                prevSlide();
                stopAutoSlide();
                startAutoSlide();
            } else if (e.key === 'ArrowRight') {
                nextSlide();
                stopAutoSlide();
                startAutoSlide();
            }
        });

        // Touch swipe
        let touchStartX = 0;
        let touchEndX = 0;

        sliderWrapper.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });

        sliderWrapper.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            if (touchEndX < touchStartX - 50) {
                nextSlide();
                stopAutoSlide();
                startAutoSlide();
            }
            if (touchEndX > touchStartX + 50) {
                prevSlide();
                stopAutoSlide();
                startAutoSlide();
            }
        }

        // Pause on hover
        sliderWrapper.addEventListener('mouseenter', stopAutoSlide);
        sliderWrapper.addEventListener('mouseleave', startAutoSlide);

        // Initialize
        initNegocio();
        createDots();
        startAutoSlide();
    </script>
</body>
</html>