//Alerts nel login
document.addEventListener("DOMContentLoaded", () => {
  fetch("/../EsamePWeb/common/alertsManager.php")
      .then(response => response.json())
      .then(alerts => {
          if (alerts.length > 0) {
              alerts.forEach(alert => {
                  Swal.fire({
                      icon: alert.icon,
                      title: alert.title,
                      text: alert.text,
                      confirmButtonText: 'OK'
                  });
              });
          }
      })
      .catch(error => console.error("Errore nel recupero degli alert:", error));
});

document.getElementById('logoutButton').addEventListener('click', function () {
  Swal.fire({
    title: 'Sei sicuro?',
    text: "Vuoi davvero effettuare il logout?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sì, esci',
    cancelButtonText: 'Annulla'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('logoutForm').submit();
    }
  });
});

//Modal
function openModal(modalId) {
  const modal = new bootstrap.Modal(document.getElementById(modalId));
  modal.show();
}


function togglePasswordVisibility(fieldId) {
  const passwordField = document.getElementById(fieldId);
  const toggleIcon = document.getElementById('toggleIcon-' + fieldId);

  if (passwordField.type === "password") {
    passwordField.type = "text";
    toggleIcon.classList.remove('bi-eye-slash');
    toggleIcon.classList.add('bi-eye');
  } else {
    passwordField.type = "password";
    toggleIcon.classList.remove('bi-eye');
    toggleIcon.classList.add('bi-eye-slash');
  }
}