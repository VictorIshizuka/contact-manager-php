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
            class="input input-bordered pl-2  w-full bg-transparent text-white outline-none transition">
        </div>

        <!-- Senha -->
        <div>
          <label class="block text-sm mb-2 text-gray-300">
            Senha
          </label>
          <input type="password"
            name="password"
            placeholder="Insira sua senha"
            class="input input-bordered pl-2  w-full bg-transparent text-white outline-none transition">
        </div>

        <!-- Botão -->
        <div class="pt-4 text-center lg:text-end">
          <button id="auth-btn"
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