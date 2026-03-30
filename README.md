# Inventory Management System

## Introduction

Welcome to the inventory Management System. This project was on behalf of our Introduction to Software Engineering module where we expanded our knowledge on common practices within the field of Software Engineering with a key one being how to manage a team in a version control environment such as GitHub. We learnt how to create issues, change their status and create pull requests. Additionally we learnt how to manage collaborators of a project and adapt to a management methodology called Scrum. 

## How to run

### DATABASE 
To use this website you will need a database named InventoryManagement with 5 tables: users, orders, orderitems, products and sales.
- users: userID, name, email, password, role. 
- orders: orderID, userID. 
- orderItems: orderitemID, orderID, productID, quantity, price. 
- products: productID, productName, price, quantity, low_stock_threshold. 
- sales: saleID, userID, productID, quantity, price, sale_date.

### WEBSITE
To use the website you will need a server running that works with PHP, we will use xampp and localhost.

