<dialog id="modal_confirm" class="modal modal-bottom sm:modal-middle backdrop-blur-sm">
  <div class="modal-box bg-[#1a1a1a] border border-white/10">
    <h3 class="font-bold text-lg mb-4 text-lime-400">Verificação de Segurança</h3>
    <p class="text-sm opacity-60 mb-6">Digite sua senha para visualizar os dados protegidos.</p>

    <form id="form-confirm-password" action="/contacts/show" method="POST" class="space-y-4">
      <input type="hidden" name="reveal_id" id="reveal-id" value="">

      <div class="form-control">
        <input type="password" name="password" id="confirm-password-input" placeholder="Sua senha mestre"

          class="input input-bordered pl-4 w-full bg-black/20 border-white/10 focus:border-lime-400" />
      </div>

      <div class="modal-action gap-2">
        <button type="button" onclick="modal_confirm.close()" class="btn btn-ghost rounded-xl px-4">Cancelar</button>
        <button type="submit" id="btn-confirm-auth" class="btn bg-lime-400 text-black font-semibold border-none rounded-xl px-6">Confirmar</button>
      </div>
    </form>
  </div>
</dialog>