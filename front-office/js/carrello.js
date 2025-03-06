const api_path = "./api/Request_Handler.php";

function caricaCarrello() {
  fetch(api_path, {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "action=show",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      const cartContainer = document.getElementById("cart-container");
      if (!cartContainer) {
        console.error("Elemento cart-container non trovato nel DOM");
        return;
      }

      if (data.success) {
        if (!data.prodotti || data.prodotti.length === 0) {
          cartContainer.innerHTML =
            '<p class="cart-empty">Il carrello è vuoto</p>';
        } else {
          let cartItemsHtml = '<div class="cart-items">';
          data.prodotti.forEach((prodotto) => {
            cartItemsHtml += `
              <div class="cart-item">
                <img src="${prodotto.path || ""}" alt="${prodotto.nome || ""}">
                <div class="cart-item-details">
                  <h3>${prodotto.nome || ""}</h3>
                  <p>${prodotto.descrizione || ""}</p>
                  <p>Prezzo: €${number_format(prodotto.prezzo || 0, 2)}</p>
                  <div class="quantity-controls">
                    <button class="quantity-btn" onclick="aggiornaQuantita(${
                      prodotto.idProdotto
                    }, -1)">-</button>
                    <span class="quantity">${prodotto.quantita}</span>
                    <button class="quantity-btn" onclick="aggiornaQuantita(${
                      prodotto.idProdotto
                    }, 1)">+</button>
                  </div>
                  <p>Subtotale: €${number_format(
                    prodotto.subtotale || 0,
                    2
                  )}</p>
                  <button class="remove-btn" onclick="rimuoviProdotto(${
                    prodotto.idProdotto
                  })">Rimuovi</button>
                </div>
              </div>
            `;
          });
          cartItemsHtml += "</div>";
          cartItemsHtml += `
            <div class="cart-total">
              <h3>Totale: €${number_format(data.totale || 0, 2)}</h3>
              <button class="checkout-btn" onclick="window.location.href='order.php'">Procedi all'acquisto</button>
            </div>
          `;
          cartContainer.innerHTML = cartItemsHtml;
        }
      } else {
        cartContainer.innerHTML = `<p class="error-message">Errore: ${
          data.message || "Errore sconosciuto"
        }</p>`;
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      const cartContainer = document.getElementById("cart-container");
      if (cartContainer) {
        cartContainer.innerHTML =
          '<p class="error-message">Errore nella comunicazione con il server</p>';
      }
    });
}

function aggiungiAlCarrello(productId, quantity) {
  fetch(api_path, {
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
        caricaCarrello();
      } else {
        alert(data.message || "Errore nell'aggiunta al carrello");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Errore nella comunicazione con il server");
    });
}

function aggiornaQuantita(idProdotto, delta) {
  fetch(api_path, {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `action=update&idProdotto=${idProdotto}&delta=${delta}`,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        caricaCarrello();
      } else {
        alert(data.message || "Errore nell'aggiornamento della quantità");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Errore nella comunicazione con il server");
    });
}

function rimuoviProdotto(idProdotto) {
  if (!confirm("Sei sicuro di voler rimuovere questo prodotto dal carrello?"))
    return;

  fetch(api_path, {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `action=remove&idProdotto=${idProdotto}`,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        caricaCarrello();
      } else {
        alert(data.message || "Errore nella rimozione del prodotto");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Errore nella comunicazione con il server");
    });
}

function htmlspecialchars(str) {
  return str
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

function number_format(number, decimals) {
  return number.toFixed(decimals).replace(/\d(?=(\d{3})+\.)/g, "$&,");
}
