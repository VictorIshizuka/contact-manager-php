document.addEventListener('DOMContentLoaded', () => {
  const contactForm = document.getElementById('contact-form');
  if (!contactForm) return;

  const btn = document.getElementById('save-contact-btn');
  const avatarInput = document.getElementById('avatar-input');
  const avatarPreview = document.getElementById('avatar-preview');
  const avatarPlaceholder = document.getElementById('avatar-placeholder');

  const ui = {
    setError: (input, message) => {
      input.classList.remove('input-bordered', 'border-white/10');
      input.classList.add('input-error');

      let container = input.parentNode.querySelector('.error-label');
      if (!container) {
        container = document.createElement('div');
        container.className = 'label error-label py-0 mt-1';
        container.innerHTML = `<span class="label-text-alt text-error font-bold text-[10px]"></span>`;
        input.insertAdjacentElement('afterend', container);
      }
      container.querySelector('span').innerText = message;
    },
    clearError: (input) => {
      input.classList.remove('input-error');
      input.classList.add('input-bordered', 'border-white/10');
      const container = input.parentNode.querySelector('.error-label');
      if (container) container.remove();
    }
  };

  // --- FUNÇÕES GLOBAIS---

  // 1. EDITAR: Preenche o modal com dados existentes
  window.editContact = (contact) => {
    contactForm.reset();
    document.getElementById('modal-title').innerText = "Editar contato";

    // Define a rota de Update
    contactForm.action = "/contacts/update";
    document.getElementById('form-method').value = "PUT";
    document.getElementById('contact-id').value = contact.id;

    document.getElementById('contact-id').value = contact.id;
    document.getElementById('current-avatar').value = contact.avatar; // Campo hidden para manter imagem atual

    contactForm.querySelector('[name="name"]').value = contact.name;
    contactForm.querySelector('[name="phone"]').value = contact.phone;
    contactForm.querySelector('[name="email"]').value = contact.email;

    if (contact.avatar) {
      avatarPreview.src = contact.avatar;
      avatarPreview.classList.remove('hidden');
      avatarPlaceholder.classList.add('hidden');
    }

    modal_contact.showModal();
  };

  // 2. DELETAR: Confirmação e post
  window.deleteContact = async (id, name) => {
    if (confirm(`Tem certeza que deseja excluir o contato "${name}"?`)) {
      const formData = new FormData();
      formData.append('id', id);
      formData.append('__method', 'DELETE');

      try {
        const response = await fetch('/contacts/delete', {
          method: 'POST',
          body: formData,
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const result = await response.json();
        if (result.success) window.location.reload();
      } catch (error) {
        alert("Erro ao excluir contato.");
      }
    }
  };

  // --- EVENTOS ---

  // Botão "Novo": Reseta o modal para criação
  const btnNovo = document.querySelector('[onclick="modal_contact.showModal()"]');
  if (btnNovo) {
    btnNovo.addEventListener('click', (e) => {
      contactForm.reset();
      contactForm.action = "/contacts"; // Rota de Create
      document.getElementById('contact-id').value = "";
      document.getElementById('modal-title').innerText = "Adicionar contato";
      avatarPreview.classList.add('hidden');
      avatarPlaceholder.classList.remove('hidden');
    });
  }

  // Preview da Foto
  avatarInput.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        avatarPreview.src = e.target.result;
        avatarPreview.classList.remove('hidden');
        avatarPlaceholder.classList.add('hidden');
      };
      reader.readAsDataURL(file);
    }
  });

  // Limpa erro ao digitar
  contactForm.addEventListener('input', (e) => {
    if (e.target.name) ui.clearError(e.target);
  });

  // Envio AJAX (Store e Update)
  contactForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const originalText = btn.innerText;
    btn.innerText = "Salvando...";
    btn.disabled = true;

    try {
      const response = await fetch(contactForm.action, {
        method: 'POST',
        body: new FormData(contactForm),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });

      const result = await response.json();

      if (result.success) {
        window.location.reload();
      } else {
        Object.keys(result.errors).forEach(field => {
          const input = contactForm.querySelector(`[name="${field}"]`);
          const msg = Array.isArray(result.errors[field]) ? result.errors[field][0] : result.errors[field];
          if (input) ui.setError(input, msg);
        });
        btn.innerText = originalText;
        btn.disabled = false;
      }
    } catch (error) {
      btn.innerText = "Erro na conexão";
      btn.disabled = false;
    }
  });
});