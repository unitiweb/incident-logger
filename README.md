# Incident Logger

A Laravel + MongoDB API for magical incident reporting, featuring department-based authentication, queue-driven processing, and a gateway pattern for flexible incident handling.

---

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Setup Instructions](#setup-instructions)
- [Environment Variables](#environment-variables)
- [Database Seeding](#database-seeding)
- [Running the Application](#running-the-application)
- [Queue Workers & Priorities](#queue-workers--priorities)
- [Artisan Commands](#artisan-commands)
- [API Authentication](#api-authentication)
- [Testing with Postman](#testing-with-postman)
- [Development Scripts](#development-scripts)
- [Troubleshooting](#troubleshooting)

---

## Features

- **MongoDB** for all data storage (departments, incidents, reports, logs)
- **Department-based authentication** using `magic_token`
- **Queue-driven incident processing** with priority queues
- **Gateway pattern** for department-specific incident handling
- **Custom Artisan commands** for database reset and reprocessing failed incidents jobs
- **Postman collection** for easy API testing

---

## Requirements

- Docker & Docker Compose

---

## Setup Instructions

1. **Clone the repository:**
    ```sh
    git clone <repo-url>
    cd incident-logger
    ```

2. **Copy and configure environment variables:**
    ```sh
    cp .env.example .env
    ```

3. **Start the containers:**
    ```sh
    ./vendor/bin/sail up -d
    ```

4. **Install dependencies:**
    ```sh
    ./vendor/bin/sail composer install
    ```

5. **Initialize the project (runs migrations, seeds, etc.):**
    ```sh
    npm run init
    ```
    *(This runs `scripts/run-init.sh`)*

---

## Database Seeding

- The seeder creates all departments with **hardcoded `magic_token` values** for easy testing.
- You can find these tokens in `database/seeders/DepartmentSeeder.php`.

---

## Running the Application

- **API server:** http://127.0.0.1:8040 (or your configured `APP_PORT`)
- **MongoDB:** 127.0.0.1:8041 (default, or your configured `MONGO_PORT`)

---

## Queue Workers & Priorities

- **Priority queues** are used to process Departments by priority_level as configured in the db.
- The worker is configured in `docker-compose.yml`:
    ```yaml
    entrypoint: ["php", "artisan", "queue:work", "--queue=high,medium,low"]
    ```
- When dispatching jobs, the queue is set based on department or `priority_level`.

---

## Artisan Commands

### **Reset & Seed Database**
```sh
./vendor/bin/sail artisan db:clear
```
- Drops all collections and reseeds departments.

### **Reprocess Incomplete Incidents**
```sh
./vendor/bin/sail artisan spell:residue-analyze
```
- Finds all incidents with `status` of `pending` or `failed` and re-dispatches them for processing.

---

## API Authentication

- **All endpoints require a department `magic_token` in the `X-MAGIC-TOKEN` header.**
- Each department’s token is hardcoded in the seeder for easier testing.

| Department                          | Magic Token                                   |
|-------------------------------------|-----------------------------------------------|
| Auror Office                        | auror-office-token-123                        |
| Department of Mysteries             | department-of-mysteries-token-123             |
| Improper Use of Magic Office        | improper-use-of-magic-token-123               |
| Magical Law Enforcement Patrol      | magical-law-enforcement-patrol-token-123      |
| Magical Accidents and Catastrophes  | magical--accidents-and-catastrophes-token-123 |

---

## Testing with Postman

- A ready-to-use Postman collection is included:
  **`postman_collection.json`** (in the project root)
- Import this collection into Postman to test all endpoints.
- The hardcoded magic tokens are pre set in the `X-MAGIC-TOKEN` header for each incident post endpoint.

---

## Some NPM Commands for Convenience

- **Project initialization:**
  `npm run init`
  *(Runs `scripts/run-init.sh` for setup tasks)*

- **Spin up environment:**
  `npm run up`

- **View worker logs:**
  `npm run worker:logs`

- **Open a shell in the Laravel container:**
  `npm run shell:laravel`

- **Reset the database:**
  `npm run db:reset`

- **Reprocess incomplete incidents:**
  `npm run queue:rerun`

---

**May The Force Be With You**
