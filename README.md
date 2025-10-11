# Personal Finance API

## About This Project

This is a **server-side project developed with Laravel**, designed as a **fully functional REST API** to manage **personal finance**, allowing users to track income and expenses in a collaborative environment.  

The project focuses on simplicity, security, and modularity, providing a solid backend for personal finance management, with the possibility of integrating it with web or mobile clients.

### Key Features

- **User and Room Management**  
  Users can create “rooms” (salas) to group financial data and invite other users. Access control is managed through roles, ensuring that only authorized users can see or modify data in each room.

- **Income and Expense Tracking**  
  Users can record incomes and expenses (tiquets) with detailed information such as category, description, amount, and type (income or expense). Both one-time and recurring transactions are supported.

- **Recurring Transactions**  
  Monthly recurring incomes or expenses can be configured with a specific **day of activation**, so the API automatically generates entries when the time comes. Users no longer need to manually repeat regular transactions like salaries or rent.

- **Monthly Balances and Reporting**  
  The API calculates balances for the current month and allows querying previous months, providing an accurate overview of the financial status of each room.

- **Secure Communication**  
  All API requests are served over HTTPS using **Let’s Encrypt**, ensuring encrypted communication between clients and the server.

- **Validation and Authorization**  
  Every request is validated to ensure data integrity. Authorization rules guarantee that users can only interact with rooms they belong to, preventing unauthorized access.

- **Queue and Scheduler Integration**  
  Background jobs handle recurring transactions automatically using Laravel’s **queue workers** and scheduler. This ensures that recurring incomes and expenses are created on time without user intervention.

- **Flexible Data Structure**  
  The database is designed to store all financial records safely, even if a user or category is deleted, maintaining historical data integrity.

- **API-First Approach**  
  Designed as a REST API, making it easy to integrate with web apps, mobile apps, or other services.

### Tech Stack

- **Laravel** (PHP Framework)  
- **PostgreSQL** (Database)  
- **Laravel Scheduler & Queue** (for recurring jobs)  
- **HTTPS with Let’s Encrypt** (secure communication)

### Future Improvements

- Reports and analytics dashboards for users  
- Export data to CSV or PDF  
- Advanced role and permission management  
- Push notifications for recurring transaction activation  

### Getting Started

1. **Clone the repository**  

```bash
git clone https://github.com/ferter3006/MoneyLink_IOC

