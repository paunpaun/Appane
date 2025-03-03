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
  // Crea il selezionatore della quantità e i pulsanti "Conferma" e "Annulla"
  const quantitySelector = document.createElement("div");
  quantitySelector.classList.add("quantity-selector");
  quantitySelector.innerHTML = `
        <input type="number" min="1" value="1" class="quantity-input">
        <button class="confirm-button">Conferma</button>
        <button class="cancel-button">Annulla</button>
    `;

  // Aggiungi il selezionatore della quantità dopo il pulsante "Aggiungi al carrello"
  button.parentNode.appendChild(quantitySelector);

  // Nascondi il pulsante "Aggiungi al carrello"
  button.style.display = "none";

  // Gestisci il clic sul pulsante "Conferma"
  quantitySelector
    .querySelector(".confirm-button")
    .addEventListener("click", function () {
      const quantity = quantitySelector.querySelector(".quantity-input").value;
      aggiungiAlCarrello(productId, quantity);
      quantitySelector.remove();
      button.style.display = "inline-block";
    });

  // Gestisci il clic sul pulsante "Annulla"
  quantitySelector
    .querySelector(".cancel-button")
    .addEventListener("click", function () {
      quantitySelector.remove();
      button.style.display = "inline-block";
    });
}

function aggiungiAlCarrello(productId, quantity) {
  fetch("../database/ajax_handler.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `idProdotto=${encodeURIComponent(
      productId
    )}&quantita=${encodeURIComponent(quantity)}`,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        alert(data.message || "Prodotto aggiunto al carrello con successo!");
      } else {
        alert(data.message || "Errore nell'aggiunta al carrello");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Errore nella comunicazione con il server");
    });
}

function aggiornaQuantita(idListaProdotto, delta) {
  fetch("../database/ajax_handler.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `action=update&idListaProdotto=${idListaProdotto}&delta=${delta}`,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        location.reload();
      } else {
        alert(data.message || "Errore nell'aggiornamento della quantità");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Errore nella comunicazione con il server");
    });
}

function rimuoviProdotto(idListaProdotto) {
  if (!confirm("Sei sicuro di voler rimuovere questo prodotto dal carrello?"))
    return;

  fetch("../database/ajax_handler.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `action=remove&idListaProdotto=${idListaProdotto}`,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        location.reload();
      } else {
        alert(data.message || "Errore nella rimozione del prodotto");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Errore nella comunicazione con il server");
    });
}
