<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada | WankaShop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            width: 100%;
            overflow-x: hidden;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #2d5016 0%, #4a7c2e 50%, #d97706 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
        }

        /* Animación de fondo */
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(74, 124, 46, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(217, 119, 6, 0.3) 0%, transparent 50%);
            animation: rotate 20s linear infinite;
            z-index: 0;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .error-container {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.98);
            max-width: 600px;
            width: 100%;
            max-height: 95vh;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            text-align: center;
            backdrop-filter: blur(10px);
            animation: fadeIn 0.6s ease-out;
            overflow-y: auto;
        }

        /* Scrollbar personalizado */
        .error-container::-webkit-scrollbar {
            width: 8px;
        }

        .error-container::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .error-container::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #4a7c2e, #d97706);
            border-radius: 10px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-icon {
            font-size: 80px;
            background: linear-gradient(135deg, #4a7c2e, #d97706);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        h1 {
            font-size: clamp(60px, 15vw, 100px);
            font-weight: bold;
            background: linear-gradient(135deg, #4a7c2e, #d97706);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            line-height: 1;
        }

        h2 {
            color: #5a3e2b;
            font-size: clamp(20px, 5vw, 28px);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .error-message {
            color: #6b5447;
            font-size: clamp(14px, 3vw, 16px);
            line-height: 1.5;
            margin-bottom: 15px;
            padding: 12px;
            background: rgba(217, 119, 6, 0.1);
            border-radius: 10px;
            border-left: 4px solid #d97706;
        }

        .error-details {
            color: #8b7d6b;
            font-size: clamp(12px, 2.5vw, 14px);
            margin-bottom: 20px;
            font-style: italic;
        }

        .suggestions {
            text-align: left;
            margin: 20px 0;
            padding: 15px;
            background: rgba(74, 124, 46, 0.05);
            border-radius: 10px;
            border-left: 4px solid #4a7c2e;
        }

        .suggestions h3 {
            color: #4a7c2e;
            margin-bottom: 12px;
            font-size: clamp(14px, 3vw, 16px);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .suggestions ul {
            list-style: none;
            padding: 0;
        }

        .suggestions li {
            color: #6b5447;
            margin: 8px 0;
            padding-left: 20px;
            position: relative;
            font-size: clamp(12px, 2.5vw, 14px);
            line-height: 1.4;
        }

        .suggestions li::before {
            content: '→';
            position: absolute;
            left: 0;
            color: #d97706;
            font-weight: bold;
        }

        .buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: clamp(13px, 2.5vw, 15px);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
            min-width: 140px;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn span {
            position: relative;
            z-index: 1;
        }

        .btn i {
            position: relative;
            z-index: 1;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4a7c2e, #5d9938);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #3d6625, #4a7c2e);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 124, 46, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            color: white;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #c2670a, #d97706);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(217, 119, 6, 0.4);
        }

        .footer-text {
            margin-top: 20px;
            color: #8b7d6b;
            font-size: clamp(11px, 2vw, 13px);
            padding-bottom: 10px;
        }

        .decorative-elements {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
        }

        .circle-1 {
            width: 80px;
            height: 80px;
            background: #4a7c2e;
            top: 15%;
            left: 8%;
            animation: float 6s ease-in-out infinite;
        }

        .circle-2 {
            width: 120px;
            height: 120px;
            background: #d97706;
            bottom: 15%;
            right: 10%;
            animation: float 8s ease-in-out infinite reverse;
        }

        .circle-3 {
            width: 60px;
            height: 60px;
            background: #5a3e2b;
            top: 55%;
            left: 75%;
            animation: float 7s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
            }
            50% {
                transform: translateY(-20px) translateX(15px);
            }
        }

        /* Responsive ajustes */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .error-container {
                padding: 30px 20px;
                max-height: 90vh;
            }

            .error-icon {
                font-size: 60px;
            }

            .suggestions {
                padding: 12px;
            }

            .buttons {
                flex-direction: column;
                gap: 10px;
            }

            .btn {
                width: 100%;
                min-width: unset;
            }

            .circle-1, .circle-2, .circle-3 {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .error-container {
                padding: 25px 15px;
            }

            .suggestions li {
                padding-left: 18px;
            }
        }

        @media (max-height: 700px) {
            .error-icon {
                font-size: 50px;
                margin-bottom: 10px;
            }

            h1 {
                margin-bottom: 8px;
            }

            h2 {
                margin-bottom: 10px;
            }

            .error-message, .suggestions, .buttons {
                margin-bottom: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="decorative-elements">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>
    </div>

    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        
        <h1>404</h1>
        <h2>¡Oops! Página no encontrada</h2>
        
        <div class="error-message">
            <?php 
            $message = $message ?? 'La página que buscas no existe o ha sido movida.';
            echo htmlspecialchars($message); 
            ?>
        </div>
        
        <div class="error-details">
            Parece que te has perdido en nuestro sistema...
        </div>

        <div class="suggestions">
            <h3>
                <i class="fas fa-lightbulb"></i>
                <span>Sugerencias:</span>
            </h3>
            <ul>
                <li>Verifica que la URL esté escrita correctamente</li>
                <li>Regresa a la página principal y navega desde allí</li>
                <li>Usa el menú de navegación para encontrar lo que buscas</li>
                <li>Contacta con soporte si el problema persiste</li>
            </ul>
        </div>

        <div class="buttons">
            <a href="<?= BASE_URL ?>" class="btn btn-primary">
                <i class="fas fa-home"></i>
                <span>Ir al Inicio</span>
            </a>
            <a href="javascript:history.back()" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                <span>Página Anterior</span>
            </a>
        </div>

        <div class="footer-text">
            <i class="fas fa-shield-alt"></i>
            WankaShop - Sistema de Gestión E-commerce
        </div>
    </div>
</body>
</html>
