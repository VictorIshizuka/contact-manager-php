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
      <form action="/register" method="post" class="max-w-sm w-full space-y-6">

        <!-- Name -->
        <div>
          <label class="block text-sm mb-2 text-gray-300">
            Nome
          </label>
          <input type="text"
            name="name" value="<?= old('name') ?? '' ?>"
            placeholder="Como você se chama?"
            class="w-full px-4 py-3 rounded-lg bg-transparent text-white border border-gray-700 focus:border-lime-400 <?php if (isset($validations['name'])) { ?> focus: border-red-400 <?php } ?> focus:ring-1 focus:ring-lime-400 outline-none transition">
          <?php if (isset($validations['name'])) { ?>
            <div class="mt-1 text-xs text-error"><?= $validations['name'] ?></div>
          <?php } ?>
        </div>

        <!-- Email -->
        <div>
          <label class="block text-sm mb-2 text-gray-300">
            E-mail
          </label>
          <input type="email"
            name="email" value="<?= old('email') ?? '' ?>"
            placeholder="Se e-mail aqui"
            class="w-full px-4 py-3 rounded-lg bg-transparent text-white border border-gray-700 focus:border-lime-400 <?php if (isset($validations['email'])) { ?> focus: border-red-400 <?php } ?> focus:ring-1 focus:ring-lime-400 outline-none transition">
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
            placeholder="Escolha uma senha segura"
            class="w-full px-4 py-3 rounded-lg bg-transparent text-white border border-gray-700 focus:border-lime-400 <?php if (isset($validations['password'])) { ?> focus: border-red-400 <?php } ?> focus:ring-1 focus:ring-lime-400 outline-none transition">
          <?php if (isset($validations['password'])) { ?>
            <div class="mt-1 text-xs text-error"><?= $validations['password'] ?></div>
          <?php } ?>
        </div>

        <div>
          <label class="block text-sm mb-2 text-gray-300">
            Confirmar senha
          </label>
          <input type="password"
            name="password_confirmed"
            placeholder="Repita sua senha para confirmar"
            class="w-full px-4 py-3 rounded-lg bg-transparent text-white border border-gray-700 focus:border-lime-400 <?php if (isset($validations['password'])) { ?> focus: border-red-400 <?php } ?> focus:ring-1 focus:ring-lime-400 outline-none transition">
          <?php if (isset($validations['password_confirmed'])) { ?>
            <div class="mt-1 text-xs text-error"><?= $validations['password_confirmed'] ?></div>
          <?php } ?>
        </div>

        <!-- Botão -->
        <div class="pt-4 text-center lg:text-end">
          <button
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