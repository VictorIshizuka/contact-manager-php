  <div class="w-full lg:w-1/3 flex flex-col justify-center items-center px-6 md:px-12 py-12 relative">

    <!-- Criar conta DESKTOP -->
    <div class="hidden lg:block absolute top-10 right-12 text-sm text-gray-400">
      Não tem uma conta?
      <a href="/register" class="text-lime-400 hover:underline">
        Criar conta
      </a>
    </div>

    <?php if ($message = flash()->get('message')) { ?>
      <div class="toast toast-end toast-middle absolute top-30 right-12">
        <div class="alert alert-success">
          <span><?= $message  ?></span>
        </div>
      </div>
    <?php } ?>


    <!-- FORM -->
    <form action="/login" method="post" class="max-w-sm w-full space-y-6">
      <?php if ($validation = flash()->get("validation_login")) { ?>
        <div class="mx-2">
          <div role="alert" class="alert alert-error mt-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span><?= $validation[0] ?></span>
          </div>
        </div>
      <?php } ?>

      <h2 class="text-2xl font-semibold text-white text-center lg:text-left">
        Acessar conta
      </h2>
      <form class="max-w-sm w-full space-y-6">
        <!-- Email -->
        <div>
          <label class="block text-sm mb-2 text-gray-300">
            E-mail
          </label>
          <input type="email"
            name="email" value="<?= old('email') ?? '' ?>"
            placeholder="Digite seu e-mail"
            class="w-full px-4 py-3 rounded-lg bg-transparent text-white border border-gray-700 focus:border-lime-400 focus:ring-1 focus:ring-lime-400 outline-none transition">
          <?php if (isset($validations['email'])) { ?>
            <div class="mt-1 text-xs text-error"><?= $validations['email'] ?></div>
          <?php } ?>

        </div>

        <!-- Senha -->
        <div>
          <label class="block text-sm mb-2 text-gray-300">
            Senha
          </label>
          <input type="password"
            name="password"
            placeholder="Insira sua senha"
            class="w-full px-4 py-3 rounded-lg bg-transparent text-white border border-gray-700 focus:border-lime-400 focus:ring-1 focus:ring-lime-400 outline-none transition">
          <?php if (isset($validations['password'])) { ?>
            <div class="mt-1 text-xs text-error"><?= $validations['password'] ?></div>
          <?php } ?>
        </div>

        <!-- Botão -->
        <div class="pt-4 text-center lg:text-end">
          <button
            class="bg-lime-400 text-black font-medium px-6 py-3 rounded-xl w-full lg:w-auto transition hover:bg-lime-300">
            Acessar conta
          </button>
        </div>
      </form>
      <!-- Criar conta MOBILE + TABLET -->
      <div class="lg:hidden text-center text-sm text-gray-400 pt-4">
        Não tem uma conta?
        <a href="/register" class="text-lime-400 hover:underline">
          Criar conta
        </a>
      </div>

  </div>

  </div>