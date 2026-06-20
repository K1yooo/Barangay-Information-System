# Barangay Information System (BIS)

A digital platform that automates document requests for residency, indigency, clearance, and permits in Barangay Malinao.


## About The Project

The Barangay Information System (BIS) is designed to streamline and improve the management of community data. It replaces manual record-keeping with a digital system that makes document requests faster, more organized, and more accessible for both residents and barangay staff.


## Purpose and Objectives

- **Data Gathering** – Store and retrieve resident data, household statistics, and community information accurately and consistently.
- **Ease in Requesting Forms** – Allow residents to request and track documents online, reducing wait times.
- **Data Security** – Protect resident information against unauthorized access.


## Problem Statement

Barangay Malinao currently faces challenges with manual record-keeping:

- Inaccurate resident data
- Delayed services
- Difficulty monitoring performance
- Time-consuming administrative tasks
- Risk of data loss
- Difficulty adapting to community growth


## Built With

- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP, MariaDB
- **Server:** XAMPP / Apache


## Getting Started

Follow these steps to run the project locally.

### Prerequisites

- XAMPP ([Download here](https://www.apachefriends.org/))
- Visual Studio Code ([Download here](https://code.visualstudio.com/))
- MariaDB (included with XAMPP)


## Installation

1. **Install and run XAMPP**
   - Start **Apache** and **MySQL** in the XAMPP Control Panel.

2. **Create the database**
   - Go to `http://localhost/phpmyadmin`
   - Create a new database named `malinaobis`

3. **Import the SQL file**
   - In phpMyAdmin, select the `malinaobis` database
   - Click the **Import** tab
   - Choose the `malinaobis.sql` file and click **Go**

4. **Move project files**
   - Copy the project folder to `C:\xampp\htdocs\`

5. **Open in VSCode**
   - Open Visual Studio Code
   - Select **File > Open Folder** and choose your project folder


## Usage

### Access the System

| Role | Local URL |
|------|-----------|
| **Admin** | `http://localhost/brgymalinao/Backend/PHP/adminLogin.php` |
| **User** | `http://localhost/brgymalinao/Frontend/PHP/home.php` |

### Features

- **Users** – Request documents, track status, manage profile
- **Admins** – Manage records, process requests, generate reports


## Disclaimer

All resident data in this system are fictional and used for demonstration purposes only. Barangay information displayed is publicly available.


## Contact

For inquiries, contact the College of Computer Studies at Pamantasan ng Lungsod ng Pasig.


## Acknowledgments

- Barangay Malinao – for their support
- Faculty and students of the College of Computer Studies


## Prepared By

**Leader:** Bernardo, Kanzaki Ning O.

**Members:**  
- Aro, Katrina Anne C.  
- Baldecanas, Aira P.  
- Garcia, Reignalyn Jewel C.  
- Santos, Simon Vincent G.
