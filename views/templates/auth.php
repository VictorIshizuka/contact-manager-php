<body class="min-h-screen bg-[#111111] flex flex-col lg:flex-row">

  <!-- ======== MOBILE + TABLET HEADER (BANNER) ======== -->
  <div class="relative lg:hidden w-full h-52 md:h-64 overflow-hidden">

    <!-- Background -->
    <div class="absolute inset-0 bg-cover bg-center blur-2xl scale-110"
      style="background-image: url('images/bg.png')"></div>

    <!-- Overlay escuro -->
    <div class="absolute inset-0 bg-black/60"></div>

    <!-- Logo centralizada -->
    <div class="relative z-10 flex flex-col items-center justify-center h-full">
      <img src="images/logo.svg" class="w-10 h-10 mb-3" />
      <span class="text-white text-xl font-semibold tracking-wide">
        GUARD
      </span>
    </div>

  </div>

  <!-- ======== LADO ESQUERDO DESKTOP ======== -->
  <div class="relative hidden lg:flex lg:w-2/3 bg-black overflow-hidden">

    <div class="absolute inset-0 bg-cover bg-center blur-2xl scale-110"
      style="background-image: url('images/bg.png')"></div>

    <div class="absolute top-8 left-10 flex items-center gap-3 z-10">
      <img src="images/logo.svg" class="w-6 h-6" />
      <span class="text-white text-lg font-semibold tracking-wide">
        GUARD
      </span>
    </div>

  </div>

  <!-- ======== LADO DIREITO / FORM ======== -->
  <?php require base_path("views/{$view}.view.php"); ?>

</body>