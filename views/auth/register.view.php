  <div class="w-full lg:w-1/3 flex flex-col justify-center items-center px-6 md:px-12 py-12 relative">

    <!-- Fazer Login DESKTOP -->
    <div class="hidden lg:block absolute top-10 right-12 text-sm text-gray-400">
      Não tem uma conta?
      <a href="/login" class="text-lime-400 hover:underline">
        Fazer Login
      </a>
    </div>

    <!-- FORM -->
    <div class="max-w-sm w-full space-y-6">

      <h2 class="text-2xl font-semibold text-white text-center lg:text-left">
        Criar conta
      </h2>
      <form id="registerForm" action="/register" method="post" class="max-w-sm w-full space-y-6">

        <!-- Name -->
        <div>
          <label class="block text-sm mb-2 text-gray-300">
            Nome
          </label>
          <input type="text"
            name="name" value="<?= old('name') ?? '' ?>"
            placeholder="Como você se chama?"
            class="input input-bordered pl-2  w-full bg-transparent text-white outline-none transition">
        </div>

        <!-- Email -->
        <div>
          <label class="block text-sm mb-2 text-gray-300">
            E-mail
          </label>
          <input type="email"
            name="email" value="<?= old('email') ?? '' ?>"
            placeholder="Se e-mail aqui"
            class="input input-bordered pl-2 w-full bg-transparent text-white outline-none transition">
        </div>

        <!-- Senha -->
        <div>
          <label class="block text-sm mb-2 text-gray-300">
            Senha
          </label>
          <input type="password"
            name="password"
            placeholder="Escolha uma senha segura"
            class="input input-bordered pl-2  w-full bg-transparent text-white outline-none transition">
        </div>

        <div>
          <label class="block text-sm mb-2 text-gray-300">
            Confirmar senha
          </label>
          <input type="password"
            name="password_confirmed"
            placeholder="Repita sua senha para confirmar"
            class="input input-bordered pl-2  w-full bg-transparent text-white outline-none transition">
        </div>

        <!-- Botão -->
        <div class="pt-4 text-center lg:text-end">
          <button id="auth-btn"
            class="bg-lime-400 text-black font-medium px-6 py-3 rounded-xl w-full lg:w-auto transition hover:bg-lime-300">
            Criar conta
          </button>
        </div>
      </form>
      <!-- Fazer Login MOBILE + TABLET -->
      <div class="lg:hidden text-center text-sm text-gray-400 pt-4">
        Já possuo uma conta!
        <a href="/login" class="text-lime-400 hover:underline">
          Fazer Login
        </a>
      </div>

    </div>

  </div>