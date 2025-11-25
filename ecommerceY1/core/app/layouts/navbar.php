<!-- NAVBAR -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <div>
            <a href="#" class="nav-brand">
                <img src="cpanel/storage/archivo/<?= $negocio->logo_url; ?>" alt="<?= htmlspecialchars($negocio->nombre); ?>" class="nav-logo">
                <div class="nav-brand-info">
                    <span class="nav-brand-name"><?= htmlspecialchars($negocio->nombre); ?></span>
                    <span class="nav-brand-address">📍 <?= htmlspecialchars($negocio->dirección); ?></span>
                </div>
            </a>
            </div>
            <div>
            <ul class="nav-menu" id="navMenu">
                <li><a href="#inicio" class="nav-link active">Inicio</a></li>
                <li><a href="#productos" class="nav-link">Productos</a></li>
                <li><a href="#nosotros" class="nav-link">Nosotros</a></li>
                <li><a href="#contacto" class="nav-link">Contacto</a></li>
                <li class="nav-actions">
                    <a href="#carrito" class="cart-icon">
                        🛒
                        <span class="cart-badge">3</span>
                    </a>
                    <a href="Administrador/index.php" class="btn-login">Ingresar</a>
                </li>
            </ul>
            </div>
            <div class="nav-toggle" id="navToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>