// Get the button
let mybutton = document.getElementById("scrollToTopBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.classList.add("show");
  } else {
    mybutton.classList.remove("show");
  }
}

// When the user clicks on the button, scroll to the top of the document
mybutton.onclick = function() {
  window.scrollTo({top: 0, behavior: 'smooth'});
}


// Función para leer cookies
function getCookie(name) {
  let cookieArr = document.cookie.split(";");
  for (let i = 0; i < cookieArr.length; i++) {
      let cookiePair = cookieArr[i].split("=");
      if (name == cookiePair[0].trim()) {
          return decodeURIComponent(cookiePair[1]);
      }
  }
  return null;
}

// Función para eliminar cookies (usada para cerrar sesión)
function deleteCookie(name) {
  document.cookie = name + '=; Max-Age=-99999999;';
}

// Verificar si la cookie de sesión existe
let sessionCookie = getCookie("PHPSESSID");

document.addEventListener("DOMContentLoaded", function() {
  let userElement = document.getElementById("user");
  if (sessionCookie) {
      // Cambiar "Inicio de sesión" por "Cerrar sesión"
      userElement.innerHTML = '<a href="#" id="logoutLink">Cerrar sesión</a>';
      
      // Agregar evento de clic al enlace de "Cerrar sesión"
      document.getElementById("logoutLink").addEventListener("click", function(e) {
          e.preventDefault();
          // Llamar a un script PHP para destruir la sesión
          fetch("../gestor_reservas/auth/logout.php")
              .then(response => {
                  if (response.ok) {
                      deleteCookie("PHPSESSID");
                      window.location.href = "../index.html"; // Redirigir a la página de inicio
                  } else {
                      alert("Error al cerrar sesión.");
                  }
              });
      });
  } else {
      // Redirigir al usuario a la página de inicio de sesión si no hay sesión
      userElement.innerHTML = '<a href="../gestor_reservas/auth/login.php">Inicio de sesión</a>';
  }
});
