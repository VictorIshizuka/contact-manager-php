<dialog id="modal_contact" class="modal modal-bottom sm:modal-middle rounded-xl backdrop-blur-sm">
  <div class="modal-box bg-[#1a1a1a] border border-white/10 max-w-md">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>

    <h3 id="modal-title" class="font-bold text-lg mb-6">Adicionar contato</h3>

    <form id="contact-form" action="/contacts" method="POST" enctype="multipart/form-data" class="space-y-4">
      <input type="hidden" name="id" id="contact-id">
      <input type="hidden" name="__method" id="form-method" value="POST">
      <input type="hidden" name="current_avatar" id="current-avatar">
      <div class="flex flex-col items-center gap-2 mb-4">
        <div class="avatar">
          <div class="w-20 h-20 rounded-2xl border-2 border-dashed border-white/20 flex items-center justify-center bg-black/20 group hover:border-lime-400 transition-all cursor-pointer relative overflow-hidden">
            <input type="file" name="avatar" id="avatar-input" class="absolute inset-0 opacity-0 cursor-pointer z-10">
            <img id="avatar-preview" src="" class="hidden object-cover w-full h-full">
            <div id="avatar-placeholder" class="text-center">
              <i class="ph ph-user-circle text-3xl opacity-30"></i>
              <span class="text-[10px] block opacity-30 uppercase font-bold">Foto</span>
            </div>
          </div>
        </div>
      </div>

      <div class="form-control">
        <label class="label"><span class="label-text opacity-60">Nome</span></label>
        <input type="text" name="name" placeholder="Nome completo" class="input input-bordered pl-2 w-full bg-black/20 border-white/10 focus:border-lime-400"  />
      </div>

      <div class="form-control">
        <label class="label"><span class="label-text opacity-60">Telefone</span></label>
        <input type="text" name="phone" placeholder="(99) 99999-9999" class="input input-bordered pl-2 w-full bg-black/20 border-white/10 focus:border-lime-400"  />
      </div>

      <div class="form-control">
        <label class="label"><span class="label-text opacity-60">E-mail</span></label>
        <input type="email" name="email" placeholder="email@exemplo.com" class="input input-bordered pl-2 w-full bg-black/20 border-white/10 focus:border-lime-400"  />
      </div>

      <div class="modal-action flex gap-2">
        <button type="button" onclick="modal_contact.close()" class="btn btn-ghost flex-1 rounded-xl">Cancelar</button>
        <button type="submit" id="save-contact-btn" class="btn bg-lime-400 text-black hover:bg-lime-300 border-none flex-1 rounded-xl">Salvar</button>
      </div>
    </form>
  </div>
</dialog>