document.addEventListener('DOMContentLoaded', () => {
  // --- 1. SELETORES DE ELEMENTOS ---
  const contactForm = document.getElementById('contact-form');
  const confirmForm = document.getElementById('form-confirm-password');
  if (!contactForm || !confirmForm) return;

  const elements = {
    btnSave: document.getElementById('save-contact-btn'),
    avatarInput: document.getElementById('avatar-input'),
    avatarPreview: document.getElementById('avatar-preview'),
    avatarPlaceholder: document.getElementById('avatar-placeholder'),
    confirmInput: document.getElementById('confirm-password-input'),
    revealIdInput: document.getElementById('reveal-id'),
    tableBody: document.querySelector('tbody'),
    searchInput: document.querySelector('input[name="search"]')
  };

  // --- 2. AUXILIARES DE INTERFACE (UI) ---
  const ui = {
    setError: (input, message) => {
      input.classList.add('input-error');
      let label = input.parentNode.querySelector('.error-label') || document.createElement('div');
      label.className = 'label error-label py-0 mt-1';
      label.innerHTML = `<span class="label-text-alt text-error font-bold text-[10px]">${message}</span>`;
      if (!input.parentNode.querySelector('.error-label')) input.insertAdjacentElement('afterend', label);
    },
    clearError: (input) => {
      input?.classList.remove('input-error');
      input?.parentNode.querySelector('.error-label')?.remove();
    },
    resetForm: (form) => {
      form.reset();
      form.querySelectorAll('input').forEach(i => ui.clearError(i));
    },
    toggleAvatar: (src) => {
      if (src) {
        elements.avatarPreview.src = src;
        elements.avatarPreview.classList.remove('hidden');
        elements.avatarPlaceholder.classList.add('hidden');
      } else {
        elements.avatarPreview.classList.add('hidden');
        elements.avatarPlaceholder.classList.remove('hidden');
      }
    },
    setEditLock: (isLocked) => {
      const fields = [contactForm.querySelector('[name="phone"]'), contactForm.querySelector('[name="email"]')];
      fields.forEach(f => {
        f.readOnly = isLocked;
        isLocked ? f.setAttribute('disabled', 'disabled') : f.removeAttribute('disabled');
        f.classList.toggle('opacity-50', isLocked);
        f.classList.toggle('cursor-not-allowed', isLocked);
      });
    }
  };

  // --- 3. AÇÕES (WINDOW FUNCTIONS) ---

  window.editContact = (contact) => {
    ui.resetForm(contactForm);
    document.getElementById('modal-title').innerText = "Editar contato";
    document.getElementById('form-method').value = "PUT";
    contactForm.action = "/contacts/update";

    document.getElementById('contact-id').value = contact.id;
    document.getElementById('current-avatar').value = contact.avatar || '';
    contactForm.querySelector('[name="name"]').value = contact.name;
    contactForm.querySelector('[name="phone"]').value = contact.phone;
    contactForm.querySelector('[name="email"]').value = contact.email;

    const isRowRevealed = document.querySelector(`button[onclick*="toggleReveal(${contact.id}"]`)?.getAttribute('data-revealed') === 'true';
    ui.setEditLock(!(contact.is_decrypted || isRowRevealed));
    ui.toggleAvatar(contact.avatar);

    modal_contact.showModal();
  };

  window.toggleReveal = (id, btn) => {
    const isRevealed = btn.getAttribute('data-revealed') === 'true';
    if (isRevealed) {
      const row = btn.closest('tr');
      const icon = document.getElementById(`lock-icon-${id}`);
      const btnEdit = row.querySelector('button[onclick*="editContact"]');

      row.querySelector('td:nth-child(2)').innerText = "(••) •••••-••••";
      row.querySelector('td:nth-child(3)').innerText = "••••••••@••••.com";
      icon.className = 'ph ph-lock text-base';
      btn.setAttribute('data-revealed', 'false');

      // Sincroniza dados "falsos" no botão de editar para segurança
      const match = btnEdit.getAttribute('onclick').match(/editContact\((.*)\)/);
      if (match) {
        let data = JSON.parse(match[1]);
        data.phone = "(••) •••••-••••";
        data.email = "••••••••@••••.com";
        data.is_decrypted = false;
        btnEdit.setAttribute('onclick', `editContact(${JSON.stringify(data)})`);
      }
    } else {
      window.revealContact(id);
    }
  };

  window.revealContact = (id) => {
    ui.resetForm(confirmForm);
    elements.revealIdInput.value = id;
    confirmForm.action = "/contacts/reveal";
    modal_confirm.showModal();
  };

  window.openFullUnlock = () => {
    ui.resetForm(confirmForm);
    elements.revealIdInput.value = "";
    confirmForm.action = "/contacts/show";
    modal_confirm.showModal();
  };

  window.deleteContact = async (id, name) => {
    if (!confirm(`Excluir "${name}"?`)) return;
    const fd = new FormData();
    fd.append('id', id);
    fd.append('__method', 'DELETE');

    const res = await fetch('/contacts/delete', { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
    if ((await res.json()).success) window.location.reload();
  };

  // --- 4. EVENTOS ---

  // Submit de Contato (Novo/Editar)
  contactForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    elements.btnSave.disabled = true;

    const res = await fetch(contactForm.action, {
      method: 'POST',
      body: new FormData(contactForm),
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });
    const result = await res.json();

    if (result.success) return window.location.reload();

    Object.keys(result.errors || {}).forEach(f => {
      const input = contactForm.querySelector(`[name="${f}"]`);
      ui.setError(input, Array.isArray(result.errors[f]) ? result.errors[f][0] : result.errors[f]);
    });
    elements.btnSave.disabled = false;
  });

  // Confirmação de Senha
  confirmForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const res = await fetch(confirmForm.action, {
      method: 'POST',
      body: new FormData(confirmForm),
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });
    const result = await res.json();

    if (res.ok) {
      if (elements.revealIdInput.value) {
        const id = elements.revealIdInput.value;
        const btnLock = document.querySelector(`button[onclick*="toggleReveal(${id}"]`);
        const row = btnLock.closest('tr');
        const btnEdit = row.querySelector('button[onclick*="editContact"]');

        row.querySelector('td:nth-child(2)').innerText = result.phone;
        row.querySelector('td:nth-child(3)').innerText = result.email;
        btnLock.querySelector('i').className = 'ph-lock-open-fill text-lime-400';
        btnLock.setAttribute('data-revealed', 'true');

        const data = JSON.parse(btnEdit.getAttribute('onclick').match(/editContact\((.*)\)/)[1]);
        data.phone = result.phone;
        data.email = result.email;
        data.is_decrypted = true;
        btnEdit.setAttribute('onclick', `editContact(${JSON.stringify(data)})`);
        modal_confirm.close();
      } else {
        window.location.reload();
      }
    } else {
      ui.setError(elements.confirmInput, result.message || "Senha incorreta");
    }
  });

  // Pesquisa com Debounce
  let searchTimeout;
  elements.searchInput?.addEventListener('input', (e) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(async () => {
      const letter = new URLSearchParams(window.location.search).get('letter') || '';
      const res = await fetch(`/contacts?letter=${letter}&search=${e.target.value}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
      const doc = new DOMParser().parseFromString(await res.text(), 'text/html');
      elements.tableBody.innerHTML = doc.querySelector('tbody').innerHTML;
    }, 300);
  });

  // Preview Foto
  elements.avatarInput.addEventListener('change', function () {
    if (this.files[0]) {
      const reader = new FileReader();
      reader.onload = (e) => ui.toggleAvatar(e.target.result);
      reader.readAsDataURL(this.files[0]);
    }
  });
});