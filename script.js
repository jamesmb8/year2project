document.addEventListener("DOMContentLoaded", () => {
  const header = document.getElementById("header");
  const sidenav = document.getElementById("sidenav");
  const productTableBody = document.querySelector("#producttable tbody");
  const viewBasketBtn = document.getElementById("viewBasketBtn");

  if (viewBasketBtn) {
    viewBasketBtn.addEventListener("click", () => {
      window.location.href = "basket.php";
    });
  }

  // Get header
  fetch("php/header.php")
    .then((response) => response.text())
    .then((data) => {
      header.innerHTML = data;
    })
    .catch((error) => {
      console.error("Error loading header:", error);
    });

  // Get user role
  fetch("php/getRole.php")
    .then((response) => response.json())
    .then((data) => {
      const role = data.role;

    
      const isAdminDash = window.location.pathname.includes("admindash.php");

      const sidenavFile =
        role === "admin" && isAdminDash
          ? "php/adminsidenav.php"
          : "php/sidenav.php";

      fetch(sidenavFile)
        .then((response) => response.text())
        .then((data) => {
          sidenav.innerHTML = data;
        })
        .catch((error) => {
          console.error("Error loading sidenav:", error);
        });
    })
    .catch((error) => {
      console.error("Error fetching user role:", error);
    });

 
  if (productTableBody) {
    fetch("php/getProducts.php")
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          const products = data.products;
          products.forEach((product) => {
            const row = document.createElement("tr");
            row.setAttribute("data-product-id", product.productID);

            row.innerHTML = `
              <td>${product.productName}</td>
              <td>£${parseFloat(product.price).toFixed(2)}</td>
              <td>${product.quantity}</td>
              <td>
                <div class="quantity-control">
                  <button class="quantity-btn" data-action="decrease">-</button>
                  <input type="text" class="quantity-input" value="0" readonly>
                  <button class="quantity-btn" data-action="increase">+</button>
                  <button class="add-to-basket-btn">Add to basket</button>
                </div>
              </td>
            `;
            productTableBody.appendChild(row);
          });

      
          attachButtonListeners();
        } else {
          console.error("Failed to load products:", data.message);
        }
      })
      .catch((error) => {
        console.error("Error fetching products:", error);
      });
  }

  

  
  const basketTableBody = document.querySelector("#basketTable tbody");

  if (basketTableBody) {
    fetch("php/fetchBasket.php")
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          const basketItems = data.items;
          basketItems.forEach((item) => {
            const row = document.createElement("tr");
            row.setAttribute("data-product-id", item.productID);

            row.innerHTML = `
              <td>${item.productName}</td>
              <td>£${parseFloat(item.price).toFixed(2)}</td>
              <td>
                <div class="quantity-control">
                  <button class="quantity-btn" data-action="decrease">-</button>
                  <input type="text" class="quantity-input" value="${
                    item.quantity
                  }" readonly>
                  <button class="quantity-btn" data-action="increase">+</button>
                </div>
              </td>
              <td>£${(item.price * item.quantity).toFixed(2)}</td>
              <td><button class="remove-item-btn">Remove</button></td>
            `;
            basketTableBody.appendChild(row);
          });

          attachBasketListeners();
        } else {
          console.error("Failed to load basket:", data.message);
        }
      })
      .catch((error) => console.error("Error fetching basket:", error));
  }


  function attachButtonListeners() {
    productTableBody.addEventListener("click", (event) => {
      if (event.target.classList.contains("quantity-btn")) {
        const button = event.target;
        const action = button.getAttribute("data-action");
        const input = button.parentElement.querySelector(".quantity-input");
        let value = parseInt(input.value);

        if (action === "increase") {
          value++;
        } else if (action === "decrease" && value > 0) {
          value--;
        }

        input.value = value;
      }

      if (event.target.classList.contains("add-to-basket-btn")) {
        const row = event.target.closest("tr");
        const productId = row.getAttribute("data-product-id");
        const quantityInput = row.querySelector(".quantity-input");
        const quantity = parseInt(quantityInput.value);

        if (quantity > 0) {
          fetch("php/addToBasket.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ productId, quantity }),
          })
            .then((response) => response.json())
            .then((data) => {
              if (data.success) {
                alert("Product added to basket!");
              } else {
                alert("Failed to add product to basket: " + data.message);
              }
            })
            .catch((error) =>
              console.error("Error adding product to basket:", error)
            );
        } else {
          alert("Please select a quantity greater than 0.");
        }
      }
    });
  }
  fetch("php/fetchBasket.php")
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      console.log("Basket data:", data);
     
    })
    .catch((error) => {
      console.error("Error fetching basket:", error);
    });


  function removeItemFromBasket(productId, row) {
    fetch("php/removeFrombasket.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ productId }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          row.remove();
          alert("Item removed from basket!");
        } else {
          alert("Failed to remove item: " + data.message);
        }
      })
      .catch((error) => console.error("Error removing item:", error));
  }


  function updateBasket(productId, quantity, row) {
    fetch("php/updateBasket.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ productId, quantity }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          const totalCell = row.querySelector("td:nth-child(4)");
          totalCell.textContent = `£${data.newTotal.toFixed(2)}`;
        } else {
          alert("Failed to update basket: " + data.message);
        }
      })
      .catch((error) => console.error("Error updating basket:", error));
  }

  // Function to handle basket actions
  function attachBasketListeners() {
    basketTableBody.addEventListener("click", (event) => {
      const button = event.target;

      if (button.classList.contains("quantity-btn")) {
        const action = button.getAttribute("data-action");
        const row = button.closest("tr");
        const productId = row.getAttribute("data-product-id");
        const quantityInput = row.querySelector(".quantity-input");
        let quantity = parseInt(quantityInput.value);

        if (action === "increase") {
          quantity++;
        } else if (action === "decrease" && quantity > 0) {
          quantity--;
        }

        if (quantity === 0 && action === "decrease") {
          removeItemFromBasket(productId, row);
          return;
        }

        quantityInput.value = quantity;
        updateBasket(productId, quantity, row);
      }

      if (button.classList.contains("remove-item-btn")) {
        const row = button.closest("tr");
        const productId = row.getAttribute("data-product-id");

        removeItemFromBasket(productId, row);
      }
    });
  }
});
