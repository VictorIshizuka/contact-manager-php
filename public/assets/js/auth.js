document.addEventListener('DOMContentLoaded', () => {
  // 1. SELEÇÃO DE ELEMENTOS
  const form = document.querySelector('form');
  if (!form) return;

  const btn = document.getElementById('auth-btn');
  const inputs = form.querySelectorAll('input');
  const confirmInput = form.querySelector('input[name="password_confirmed"]');

  // 2. GERENCIAMENTO DE INTERFACE (UI)
  // Centraliza como o erro aparece visualmente
  const ui = {
    setError: (input, message) => {
      input.classList.remove('input-bordered', 'input-success', 'border-gray-700');
      input.classList.add('input-error');

      let container = input.parentNode.querySelector('.error-label');
      if (!container) {
        container = document.createElement('div');
        container.className = 'label error-label py-0 mt-1';
        container.innerHTML = `<span class="label-text-alt text-error font-bold text-xs"></span>`;
        input.insertAdjacentElement('afterend', container);
      }
      container.querySelector('span').innerText = message;
    },

    clearError: (input) => {
      input.classList.remove('input-error');
      input.classList.add('input-bordered');
      const container = input.parentNode.querySelector('.error-label');
      if (container) container.remove();
    },

    toggleButton: (isValid) => {
      btn.disabled = !isValid;
      const classes = ['btn-disabled', 'opacity-50', 'cursor-not-allowed'];
      isValid ? btn.classList.remove(...classes) : btn.classList.add(...classes);
    }
  };

  // 3. REGRAS DE VALIDAÇÃO LOCAL
  const validate = () => {
    let formIsValid = true;

    inputs.forEach(input => {
      // Valida campo vazio
      if (!input.value.trim()) formIsValid = false;

      // Valida senha (Somente se houver confirmação de senha na tela)
      if (input.name === 'password' && confirmInput) {
        const isLong = input.value.length >= 8;
        const hasSpecial = /[\d!@#$%^&*]/.test(input.value);
        const matches = input.value === confirmInput.value;

        // Feedback visual de sucesso enquanto digita
        if (isLong && hasSpecial) {
          input.classList.add('input-success');
          input.classList.remove('input-bordered', 'input-error');
        } else {
          input.classList.remove('input-success');
        }

        if (!isLong || !hasSpecial || !matches) formIsValid = false;
      }
    });

    ui.toggleButton(formIsValid);
    return formIsValid;
  };

  // 4. EVENTOS DE ESCUTA
  form.addEventListener('input', (e) => {
    ui.clearError(e.target);
    validate();
  });

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    if (!validate()) return;

    const originalText = btn.innerText;
    btn.innerText = "Verificando...";

    try {
      const response = await fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });

      const result = await response.json();

      if (result.success) {
        window.location.href = result.redirect;
      } else {
        // Trata erros do PHP
        Object.keys(result.errors).forEach(field => {
          const input = form.querySelector(`[name="${field}"]`);
          const msg = Array.isArray(result.errors[field]) ? result.errors[field][0] : result.errors[field];
          if (input) ui.setError(input, msg);
        });
        btn.innerText = originalText;
      }
    } catch (error) {
      console.error("Erro na requisição:", error);
      btn.innerText = "Erro na conexão";
    }
  });

  // Inicialização automática
  validate();
});