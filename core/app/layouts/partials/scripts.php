<!-- plugins:js -->
<script src="<?= ASSETS ?>vendors/js/vendor.bundle.base.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


<!-- Plugin js for this page -->
<script src="<?= ASSETS ?>vendors/chart.js/Chart.min.js"></script>
<script src="<?= ASSETS ?>vendors/progressbar.js/progressbar.min.js"></script>
<script src="<?= ASSETS ?>vendors/jvectormap/jquery-jvectormap.min.js"></script>
<script src="<?= ASSETS ?>vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?= ASSETS ?>vendors/owl-carousel-2/owl.carousel.min.js"></script>

<!-- Core js -->
<script src="<?= ASSETS ?>js/off-canvas.js"></script>
<script src="<?= ASSETS ?>js/hoverable-collapse.js"></script>
<script src="<?= ASSETS ?>js/misc.js"></script>
<script src="<?= ASSETS ?>js/settings.js"></script>
<script src="<?= ASSETS ?>js/todolist.js"></script>

<!-- Dashboard js -->
<script src="<?= ASSETS ?>js/dashboard.js"></script>
<!-- Theme Switcher -->
<script src="<?= ASSETS ?>js/theme-switcher.js"></script>



<!-- JavaScript adicional por página -->
<?php if(isset($extraJS)): ?>
    <?= $extraJS ?>
<?php endif; ?>