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
