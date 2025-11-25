<?php

require_once 'core/autoload.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Hash</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            border-bottom: 3px solid #4CAF50;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        button {
            background: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #45a049;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background: #e8f5e9;
            border-left: 4px solid #4CAF50;
            border-radius: 4px;
        }
        .hash {
            background: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            word-break: break-all;
            font-family: monospace;
            margin: 10px 0;
        }
        .sql {
            background: #263238;
            color: #aed581;
            padding: 15px;
            border-radius: 4px;
            font-family: monospace;
            margin: 10px 0;
            overflow-x: auto;
        }
        .info {
            background: #fff3e0;
            padding: 10px;
            border-left: 4px solid #ff9800;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🔐 Generador de Hash de Contraseñas</h2>
        
        <form method="POST">
            <div class="form-group">
                <label>Contraseña a hashear:</label>
                <input type="text" name="password" placeholder="Ingresa la contraseña" required autofocus>
            </div>
            
            <div class="form-group">
                <label>Email del usuario (opcional):</label>
                <input type="text" name="email" placeholder="ejemplo@correo.com">
            </div>
            
            <button type="submit">Generar Hash</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $email = $_POST['email'] ?? 'usuario@ejemplo.com';
            
            if (!empty($password)) {
                // Generar hash
                $hash = Security::hashPassword($password);
                
                echo '<div class="result">';
                echo '<h3>✅ Hash Generado</h3>';
                
                echo '<p><strong>Contraseña original:</strong></p>';
                echo '<div class="hash">' . htmlspecialchars($password) . '</div>';
                
                echo '<p><strong>Hash generado:</strong></p>';
                echo '<div class="hash">' . $hash . '</div>';
                
                echo '<p><strong>Longitud:</strong> ' . strlen($hash) . ' caracteres</p>';
                
                echo '<hr>';
                
                echo '<h3>📋 SQL para actualizar usuario existente:</h3>';
                echo '<div class="sql">';
                echo 'UPDATE usuario SET password = \'' . $hash . '\' WHERE email = \'' . $email . '\';';
                echo '</div>';
                
                echo '<h3>📋 SQL para crear nuevo usuario:</h3>';
                echo '<div class="sql">';
                echo "INSERT INTO usuario (nombre, email, password, estado) VALUES <br>";
                echo "('Admin', '" . $email . "', '" . $hash . "', 1);";
                echo '</div>';
                
                echo '<div class="info">';
                echo '<strong>💡 Instrucciones:</strong><br>';
                echo '1. Copia el SQL que necesites<br>';
                echo '2. Pégalo en phpMyAdmin<br>';
                echo '3. Ejecuta la consulta<br>';
                echo '4. Usa la contraseña original para hacer login';
                echo '</div>';
                
                echo '</div>';
            }
        }
        ?>
    </div>
</body>
</html>