// ===== Toggle Login: Admin / User =====
function setRole(role) {
  const btnUser = document.getElementById('btn-role-user');
  const btnAdmin = document.getElementById('btn-role-admin');
  const roleInput = document.getElementById('role-input');
  const formTitle = document.getElementById('form-title');
  const registerHint = document.getElementById('register-hint');

  if (!roleInput) return;
  roleInput.value = role;

  if (role === 'admin') {
    btnAdmin.classList.add('active');
    btnUser.classList.remove('active');
    formTitle.textContent = 'Login Admin';
    if (registerHint) registerHint.style.display = 'none';
  } else {
    btnUser.classList.add('active');
    btnAdmin.classList.remove('active');
    formTitle.textContent = 'Login Calon Mahasiswa';
    if (registerHint) registerHint.style.display = 'block';
  }
}

// ===== Highlight selected answer option in CBT =====
function selectOption(el, soalId) {
  document.querySelectorAll('.option[data-soal="' + soalId + '"]').forEach(function (o) {
    o.classList.remove('selected');
  });
  el.classList.add('selected');
  el.querySelector('input').checked = true;
}

// ===== Toggle reveal of correct answer in admin soal list =====
function toggleAnswer(id) {
  const el = document.getElementById('ans-' + id);
  if (el) el.classList.toggle('revealed');
}

// ===== Confirm before destructive actions =====
function confirmAction(message) {
  return confirm(message || 'Apakah Anda yakin?');
}

// ===== Simple client-side password match check on register =====
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('register-form');
  if (form) {
    form.addEventListener('submit', function (e) {
      const pass = document.getElementById('password');
      const confirmPass = document.getElementById('konfirmasi_password');
      if (pass && confirmPass && pass.value !== confirmPass.value) {
        e.preventDefault();
        alert('Password dan konfirmasi password tidak sama.');
      }
    });
  }
});
