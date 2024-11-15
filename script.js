document.addEventListener("DOMContentLoaded", () =>{
    const productTableBody = document.querySelector("#producttable tbody");
    const header = document.getElementById("header")
    const sidenav = document.getElementById("sidenav");

fetch("php/header.php")
    .then(response =>response.text())
    .then(data => { header.innerHTML = data;
    });

fetch("php/sidenav.php")
    .then((response) => response.text())
    .then((data) => {
        sidenav.innerHTML = data;
  });

fetch("get_products.php")
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const products = data.products;
            products.forEach(product => {
                const row = document.createElement("tr");
                row.setAttribute("data-product-id", product.productID);

                row.innerHTML = `
                    <td>${product.productName}</td>
                    <td>£${parseFloat(product.price).toFixed(2)}</td>
                    <td>${product.quantity}</td>
                    <td>
                        <div class ="quantity-control">
                            <button class="quantity-btn" data-action="decrease">-</button>
                            <input type = "text" class="quantity-input" value="0" readonly>
                            <button class ="quantity-btn" data-action="increase">+</button>
                            <button class="add-to-basket-btn">Add to basket</button>

                            
                        </div>
                    </td>   
                    `;
                    productTableBody.appendChild(row);



            });
        }
      
            
        });
});
        
      
    
