<dialog id="modal_settings" class="modal modal-bottom sm:modal-middle rounded-xl backdrop-blur-sm">
  <div class="modal-box bg-base-100 border border-white/5 p-0 overflow-hidden max-w-md">

    <div class="p-6 border-b border-white/5 flex justify-between items-center">
      <h3 class="font-bold text-lg flex items-center gap-2">
        <i class="ph ph-gear text-lime-400"></i> Configurações
      </h3>
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost">✕</button>
      </form>
    </div>

    <div class="p-6 space-y-6">
      <section>
        <h4 class="text-[10px] uppercase tracking-[0.2em] font-bold opacity-40 mb-4">Seu Perfil</h4>
        <div class="flex items-center gap-4 p-4 bg-white/[0.02] rounded-2xl border border-white/5">
          <div class="avatar placeholder">
            <div class="bg-lime-400  text-black rounded-full flex text-center items-center p-4">
              <span class="text-xl font-bold"><?= strtoupper(substr(auth()->email, 0, 1)) ?></span>
            </div>
          </div>
          <div class="truncate">
            <p class="text-sm font-bold truncate"><?= auth()->email ?></p>
            <p class="text-[10px] opacity-50 uppercase font-medium">Usuário Padrão</p>
          </div>
        </div>
      </section>

      <section class="pt-4 border-t border-white/5">
        <h4 class="text-[10px] uppercase tracking-[0.2em] font-bold text-red-400/60 mb-4">Zona de Perigo</h4>
        <p class="text-xs opacity-50 mb-4">Ao deletar sua conta, todos os seus contatos e dados criptografados serão removidos permanentemente.</p>

        <button onclick="confirmDeleteAccount()" class="btn btn-outline btn-error btn-block rounded-xl gap-2 border-red-500/30 hover:bg-red-500/10">
          <i class="ph ph-warning-octagon text-lg"></i>
          Excluir minha conta
        </button>
      </section>
    </div>
  </div>
  <form method="dialog" class="modal-backdrop bg-black/40 backdrop-blur-sm">
    <button>close</button>
  </form>
</dialog>