<!DOCTYPE html>
<html lang="es">

<?php include 'partials/head.php'; ?>

<body>
  <div class="container-scroller">
    
    <!-- Navbar -->
    <?php include 'partials/navbar.php'; ?>

    <!-- Sidebar -->
      <?php include 'partials/sidebar.php'; ?>
    
    <div class="container-fluid page-body-wrapper">
      
      <!-- Main Panel -->
      <div class="main-panel">
        <div class="content-wrapper">
          
          <!-- Contenido dinámico de la vista -->
          <?php 
            if(isset($view) && file_exists($view)) {
              include $view;
            } else {
              echo '<div class="alert alert-danger">Vista no encontrada</div>';
            }
          ?>
          
        </div>
        
        <!-- Footer -->
        <?php include 'partials/footer.php'; ?>
        
      </div>
      
    </div>
    
  </div>
  
  <!-- Scripts -->
  <?php include 'partials/scripts.php'; ?>
  
</body>
</html>
