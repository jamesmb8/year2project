document.addEventListener("DOMContentLoaded", () => {
  const header = document.getElementById("header");
  const sidenav = document.getElementById("sidenav");
  const productTableBody = document.querySelector("#producttable tbody");

  // Load the header
  fetch("php/header.php")
    .then((response) => response.text())
    .then((data) => {
      header.innerHTML = data;
    })
    .catch((error) => {
      console.error("Error loading header:", error);
    });

  // Fetch user role and load the appropriate sidenav
  fetch("php/getRole.php")
    .then((response) => response.json())
    .then((data) => {
      const role = data.role;
      if (role === "admin" || role === "manager") {
        // Load admin sidenav for admins and managers
        fetch("php/adminsidenav.php")
          .then((response) => response.text())
          .then((data) => {
            sidenav.innerHTML = data;
          })
          .catch((error) => {
            console.error("Error loading admin sidenav:", error);
          });
      } else if (role === "customer") {
        // Load regular sidenav for customers
        fetch("php/sidenav.php")
          .then((response) => response.text())
          .then((data) => {
            sidenav.innerHTML = data;
          })
          .catch((error) => {
            console.error("Error loading sidenav:", error);
          });
      } else {
        console.warn("Unknown role:", role);
      }
    })
    .catch((error) => {
      console.error("Error fetching user role:", error);
    });

  // Load product data into the table
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
      } else {
        console.error("Failed to load products:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching products:", error);
    });
});
