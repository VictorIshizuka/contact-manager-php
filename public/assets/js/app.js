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

  // Envio AJAX
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
      console.log(result);

      if (result.success) {
        window.location.reload();
      } else {
        // Exibe erros do PHP no modal
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