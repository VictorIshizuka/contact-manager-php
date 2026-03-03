  <aside class="w-full lg:w-24 flex-none flex lg:flex-col items-center p-2 lg:pt-6 lg:pb-14 order-last lg:order-first relative">
    <div class="hidden lg:block mb-8">
      <img src="images/logo.svg" class="w-10 h-10" alt="Logo" />
    </div>

    <nav class="flex lg:flex-col gap-4 p-2 my-auto items-center justify-center">
      <button class="btn btn-sm lg:btn-lg text-lime-400 border-lime-400/50 btn-square rounded-2xl bg-lime-400/10 hover:bg-lime-400 hover:text-black transition-all">
        <i class="ph ph-users-three text-xl lg:text-2xl"></i>
      </button>
      <button class="btn btn-sm lg:btn-lg btn-ghost btn-square opacity-40 hover:text-lime-400 hover:opacity-100 hover:border-lime-400 hover:shadow-[0_0_15px_rgba(163,230,53,0.3)] rounded-2xl transition-all">
        <i class="ph ph-gear text-xl lg:text-2xl"></i>
      </button>
      <button class="btn btn-sm lg:btn-lg btn-ghost btn-square opacity-40 hover:text-lime-400 hover:border-lime-400 hover:opacity-100 hover:shadow-[0_0_15px_rgba(163,230,53,0.3)] rounded-2xl transition-all">
        <i class="ph ph-sign-out text-xl lg:text-2xl"></i>
      </button>
    </nav>

    <div class="hidden lg:block absolute bottom-4 left-0 w-full text-center px-2">
      <p class="text-[9px] uppercase tracking-widest opacity-30 font-bold leading-tight truncate">
        Logado como:<br>
        <span class="text-white opacity-80 lowercase font-normal italic truncate block"><?= auth()->email ?></span>
      </p>
    </div>
  </aside>

  <main class="flex-1 flex flex-col min-h-0 min-w-0 md:m-10">
    <div class="bg-base-100 rounded-3xl lg:rounded-[2.5rem] shadow-2xl flex-1 flex flex-col overflow-hidden border border-white/5 h-full">

      <div class="w-full p-6 lg:p-8 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 flex-none">
        <h1 class="text-2xl lg:text-3xl font-bold whitespace-nowrap">Lista de contatos</h1>

        <div class="flex flex-col sm:flex-row flex-1 items-center gap-4 w-full xl:max-w-3xl justify-end">
          <div class="relative w-full sm:flex-1">
            <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 opacity-50"></i>
            <input type="text" placeholder="Pesquisar contatos..." class="input input-bordered w-full pl-12 bg-[#161616] border-white/10 focus:border-lime-400 focus:outline-none transition-all" />
          </div>

          <div class="flex items-center gap-2 w-full sm:w-auto">
            <button class="btn btn-md border-none px-6 hover:bg-lime-400 hover:text-[#111111] bg-[#303030] rounded-xl transition-all shadow-lg">
              <i class="ph ph-plus"></i>
              <span class="inline">Novo</span>
            </button>
            <button class="btn btn-md btn-square bg-[#303030] border-none rounded-xl hover:text-lime-400 transition-all">
              <i class="ph ph-lock"></i>
            </button>
          </div>
        </div>
      </div>

      <div class="flex-1 flex flex-col lg:flex-row min-h-0 border-t border-white/5 overflow-hidden">

        <div class="bg-lime-400 text-[#111111] p-4 flex lg:flex-col justify-start items-center lg:my-6 lg:ml-6 lg:mr-2 lg:rounded-[2rem] overflow-y-auto overflow-x-hidden shadow-xl no-scrollbar flex-none lg:gap-1">
          <?php
          $lyrics = range('A', 'Z');
          foreach ($lyrics as $letter):
            $active = ($letter == 'C') ? 'text-lg text-[#111111] font-extrabold bg-black/20 rounded-lg scale-110 shadow-inner' : 'text-[#111111]/40 hover:text-[#111111] hover:bg-black/5 rounded-lg font-semibold';
          ?>
            <button class="min-w-[40px] lg:min-w-full h-6 w-6 flex flex-none items-center justify-center text-xs transition-all <?= $active ?>">
              <?= $letter ?>
            </button>
          <?php endforeach; ?>
        </div>

        <div class="flex-1 p-4 lg:p-6 flex flex-col min-h-0 min-w-0 overflow-hidden">
          <div class="flex items-center gap-3 mb-4 opacity-40 flex-none">
            <div class="h-[1px] flex-1 bg-white/10"></div>
            <span class="text-xs font-bold uppercase tracking-widest">Grupo C</span>
            <div class="h-[1px] flex-1 bg-white/10"></div>
          </div>

          <div class="flex-1 overflow-y-auto overflow-x-auto custom-scrollbar">
            <table class="table table-pin-rows w-full border-separate border-spacing-y-2">
              <thead class="relative z-10">
                <tr class="text-[10px] opacity-40 uppercase tracking-widest border-none">
                  <th class="bg-base-100 py-3">Nome</th>
                  <th class="hidden md:table-cell bg-base-100 py-3 text-center">Telefone</th>
                  <th class="hidden xl:table-cell bg-base-100 py-3">Email</th>
                  <th class="text-right bg-base-100 py-3">Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($contacts as $c): ?>
                  <tr class="hover:bg-white/[0.03] transition-all group border-none">
                    <td class="rounded-l-2xl">
                      <div class="flex items-center gap-3">
                        <div class="avatar">
                          <div class="mask mask-squircle w-10 h-10 shadow-md border border-white/5">
                            <img src="<?= $c->img ?>" />
                          </div>
                        </div>
                        <div class="truncate">
                          <div class="font-bold group-hover:text-lime-400 transition-all truncate text-sm"><?= $c->name ?></div>
                          <div class="text-[9px] opacity-30 font-bold uppercase block sm:hidden italic">Mobile</div>
                        </div>
                      </div>
                    </td>
                    <td class="hidden md:table-cell font-mono text-xs opacity-60 text-center"><?= $c->phone ?></td>
                    <td class="hidden xl:table-cell text-xs opacity-40 truncate max-w-[150px]"><?= $c->email ?></td>
                    <td class="text-right rounded-r-2xl">
                      <div class="flex justify-end gap-1">
                        <button class="btn btn-xs btn-ghost hover:text-lime-400 hover:bg-lime-400/10">
                          <i class="ph ph-pencil-simple-bold text-base"></i>
                        </button>
                        <button class="btn btn-xs btn-ghost hover:text-error hover:bg-error/10">
                          <i class="ph ph-trash-bold text-base"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>

  <style>
    /* Remove a barra de rolagem visualmente mas mantém o scroll funcional */

    /* 1. Para Chrome, Safari, Edge e Brave */
    .no-scrollbar::-webkit-scrollbar {
      width: 0px !important;
      height: 0px !important;
      display: none !important;
      background: transparent !important;
    }

    /* 2. Para Firefox */
    .no-scrollbar {
      scrollbar-width: none !important;
      -ms-overflow-style: none !important;
      /* IE e Edge antigo */
    }

    /* Garante que o container de letras não tente expandir horizontalmente */
    .no-scrollbar {
      overflow-x: hidden !important;
    }

    /* Custom scrollbar apenas para a TABELA (se você quiser uma barra fina lá) */
    .custom-scrollbar::-webkit-scrollbar {
      width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
      background: rgba(163, 230, 53, 0.3);
      border-radius: 10px;
    }
  </style>