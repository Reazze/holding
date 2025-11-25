<footer class="footer">
  <div class="d-sm-flex justify-content-center justify-content-sm-between">
    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">
      Copyright © <?= date('Y') ?> <a href="<?= BASE_URL ?>"><?= $appName ?? 'Mi Sistema' ?></a>. Todos los derechos reservados.
    </span>
    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
      Versión <?= $appVersion ?? '1.0.0' ?>
    </span>
  </div>
</footer>