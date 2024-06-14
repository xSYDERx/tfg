// Función para obtener el valor de una cookie específica
function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}

// Función para manejar la lógica de mostrar el botón "Go to top"
function handleGoToTopButton() {
  const button = document.getElementById('goTopButton');
  window.onscroll = function() {
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
          button.style.display = "block";
      } else {
          button.style.display = "none";
      }
  };
  button.onclick = function() {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
  };
}

// Asegúrate de que el DOM esté completamente cargado antes de ejecutar las funciones
document.addEventListener('DOMContentLoaded', (event) => {
  handleGoToTopButton();
});
