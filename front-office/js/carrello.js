let api_path = "./api/Request_Handler.php";

document.addEventListener("DOMContentLoaded", function () {
  caricaCarrello();
});

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
        if (data.prodotti.length === 0) {
          cartContainer.innerHTML =
            '<p class="cart-empty">Il carrello è vuoto</p>';
        } else {
          let cartItemsHtml = '<div class="cart-items">';
          data.prodotti.forEach((prodotto) => {
            cartItemsHtml += `
              <div class="cart-item">
                <img src="${htmlspecialchars(
                  prodotto.path
                )}" alt="${htmlspecialchars(prodotto.nome)}">
                <div class="cart-item-details">
                  <h3>${htmlspecialchars(prodotto.nome)}</h3>
                  <p>${htmlspecialchars(prodotto.descrizione)}</p>
                  <p>Prezzo: €${number_format(prodotto.prezzo, 2)}</p>
                  <div class="quantity-controls">
                    <button class="quantity-btn" onclick="aggiornaQuantita(${
                      prodotto.idListaProdotto
                    }, -1)">-</button>
                    <span class="quantity">${prodotto.quantita}</span>
                    <button class="quantity-btn" onclick="aggiornaQuantita(${
                      prodotto.idListaProdotto
                    }, 1)">+</button>
                  </div>
                  <p>Subtotale: €${number_format(prodotto.subtotale, 2)}</p>
                  <button class="remove-btn" onclick="rimuoviProdotto(${
                    prodotto.idListaProdotto
                  })">Rimuovi</button>
                </div>
              </div>
            `;
          });
          cartItemsHtml += "</div>";
          cartItemsHtml += `
            <div class="cart-total">
              <h3>Totale: €${number_format(data.totale, 2)}</h3>
              <button class="checkout-btn" onclick="window.location.href='checkout.php'">Procedi all'acquisto</button>
            </div>
          `;
          cartContainer.innerHTML = cartItemsHtml;
        }
      } else {
        cartContainer.innerHTML = `<p class="error-message">Errore: ${htmlspecialchars(
          data.message
        )}</p>`;
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      document.getElementById("cart-container").innerHTML =
        '<p class="error-message">Errore nella comunicazione con il server</p>';
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

function aggiornaQuantita(idListaProdotto, delta) {
  fetch(api_path, {
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

function rimuoviProdotto(idListaProdotto) {
  if (!confirm("Sei sicuro di voler rimuovere questo prodotto dal carrello?"))
    return;

  fetch(api_path, {
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
