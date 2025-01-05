Welcome to the inventory Management System.
DATABASE 
To use this website you will need a database named InventoryManagement with 5 tables: users, orders, orderitems, products and sales.
users: userID, name, email, password, role. 
orders: orderID, userID. 
orderItems: orderitemID, orderID, productID, quantity, price. 
products: productID, productName, price, quantity, low_stock_threshold. 
sales: saleID, userID, productID, quantity, price, sale_date. 
WEBSITE
To use the website you will need a server running that works with PHP, we will use xampp and localhost.

