// toggleDescription.js
document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.getElementById("toggleButton");
    const description = document.getElementById("description");
  
    toggleButton.addEventListener("click", function () {
      description.classList.toggle("show");
      if (description.classList.contains("show")) {
        toggleButton.textContent = "Ocultar descripción";
      } else {
        toggleButton.textContent = "Mostrar descripción";
      }
    });
  });
  