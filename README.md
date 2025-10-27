# 🏨 Information Management System - Hotel Simulation

Hi there! 👋  
This is a simple **Information Management System (IMS)** created as part of my **final project**.  
The project simulates how information is managed within a **hotel environment**, including room management, booking, and transactions.

---

## 💡 Project Overview
This system is designed to demonstrate how an **information management system** can be implemented in a hotel setting.  
It allows multiple types of users with different access levels and capabilities.

---

## 👥 User Roles & Access

### 🛠️ **Admin**
The admin has **full control** over the system:
- View and manage **all data**
- **Edit, add, and delete** users
- **Edit, add, and delete** rooms
- **Edit, add, and delete** bookings
- **Edit, add, and delete** transactions
- View **dashboard and statistics**

### 📊 **Manager**
The manager can:
- View **dashboard information**
- View **room**, **booking**, and **transaction** data  
> 🔒 Note: The manager **cannot edit** or delete data.

### 👤 **User / Pengguna**
The user (guest) can:
- View available **rooms** for booking
- Make **bookings**
- View their **own transactions**

---

## 🧱 Features
- User Authentication (Login / Logout)
- Dashboard with summarized hotel information
- Room Management (CRUD by Admin)
- Booking Management
- Transaction Management
- Multi-level Access Control (Admin / Manager / User)
- Simple and clean UI for demonstration

---

## 🗃️ Database
The system uses **MySQL** as the database.

To import the database:
1. Open **phpMyAdmin**
2. Create a new database
3. Import the file: `hotel.sql`

## Screenshots

Admin view of Dashboard
<img width="1853" height="948" alt="image" src="https://github.com/user-attachments/assets/25e801ba-ff3c-4592-8878-c83c61065faa" />


Admin view Edit
<img width="1854" height="930" alt="image" src="https://github.com/user-attachments/assets/47c2b30e-53d8-4b75-bd58-4e839f55e4ad" />

User view of Bookings
<img width="1850" height="946" alt="image" src="https://github.com/user-attachments/assets/a6fa0943-aab5-4c49-a943-aa57dc572318" />

User view of Transactions
<img width="1864" height="758" alt="image" src="https://github.com/user-attachments/assets/cf6752b8-32a1-4dcf-af69-209be032eba8" />
