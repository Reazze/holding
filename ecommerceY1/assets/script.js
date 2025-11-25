// ========================================
// NAVBAR SCROLL EFFECT
// ========================================
window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// ========================================
// ACTIVE LINK NAVIGATION
// ========================================
const navLinks = document.querySelectorAll('.nav-link');
navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        if (!e.target.closest('.cart-icon') && !e.target.closest('.btn-login')) {
            navLinks.forEach(l => l.classList.remove('active'));
            e.target.classList.add('active');
            
            // Cerrar mobile menu
            const navbarCollapse = document.querySelector('.navbar-collapse');
            if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                const bsCollapse = new bootstrap.Collapse(navbarCollapse);
            }
        }
    });
});

// ========================================
// SLIDER - LÓGICA ORIGINAL
// ========================================
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
prevBtn.addEventListener('click', () => {
    prevSlide();
    stopAutoSlide();
    startAutoSlide();
});

nextBtn.addEventListener('click', () => {
    nextSlide();
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
createDots();
startAutoSlide();
// Función simulada para agregar al carrito
        function addToCart(productName) {
            alert(`¡${productName} agregado al carrito! 🛒`);
            
            // Aquí integrarías tu lógica real de carrito
            // Por ejemplo: localStorage, API calls, etc.
        }

        // Pausar el carrusel cuando el mouse está sobre él
        const carousel = document.getElementById('techCarousel');
        const bsCarousel = new bootstrap.Carousel(carousel, {
            interval: 5000,
            pause: 'hover'
        });

        // Añadir efecto de teclado para navegación
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                bsCarousel.prev();
            } else if (e.key === 'ArrowRight') {
                bsCarousel.next();
            }
        });