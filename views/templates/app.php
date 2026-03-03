<body class="bg-[#111111] h-screen w-screen flex flex-col lg:flex-row overflow-hidden p-4 lg:p-6 xl:p-8 max-w-[1920px] mx-auto">

  <?php require base_path("views/{$view}.view.php") ?>

  <script src="/assets/js/app.js"></script>

  <?php if (isset($pageScript)): ?>
    <script src="/assets/js/pages/<?= $pageScript ?>"></script>
  <?php endif; ?>
</body>