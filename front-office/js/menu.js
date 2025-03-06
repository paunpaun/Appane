document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".add-to-cart");
  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      const productId = this.getAttribute("data-id");
      showQuantitySelector(this, productId);
    });
  });
});

function showQuantitySelector(button, productId) {
  const quantitySelector = document.createElement("div");
  quantitySelector.classList.add("quantity-selector");
  quantitySelector.innerHTML = `
        <input type="number" min="1" value="1" class="quantity-input">
        <button class="confirm-button">Conferma</button>
        <button class="cancel-button">Annulla</button>
    `;
  button.parentNode.appendChild(quantitySelector);
  button.style.display = "none";

  quantitySelector
    .querySelector(".confirm-button")
    .addEventListener("click", function () {
      const quantity = quantitySelector.querySelector(".quantity-input").value;
      aggiungiAlCarrello(productId, quantity);
      quantitySelector.remove();
      button.style.display = "inline-block";
    });

  quantitySelector
    .querySelector(".cancel-button")
    .addEventListener("click", function () {
      quantitySelector.remove();
      button.style.display = "inline-block";
    });
}

document.addEventListener("DOMContentLoaded", function () {
  const currentDay = new Date().getDay();
  const addToCartButtons = document.querySelectorAll(".add-to-cart");

  addToCartButtons.forEach((button) => {
    if (currentDay < 1 || currentDay > 5) {
      button.disabled = true;
      button.style.backgroundColor = "#ccc";
      button.style.cursor = "not-allowed";
    }
  });
});

setTimeout(function () {
  var successMessage = document.querySelector(".success-message");
  var errorMessage = document.querySelector(".error-message");
  if (successMessage) {
    successMessage.style.display = "none";
  }
  if (errorMessage) {
    errorMessage.style.display = "none";
  }
}, 5000);

function filterByCategory() {
  const category = document.getElementById("category-select").value;
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "api/filter_products.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
    if (this.status === 200) {
      document.getElementById("products-container").innerHTML =
        this.responseText;
    }
  };
  xhr.send("categoria_id=" + encodeURIComponent(category));
}
