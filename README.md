# Incident Logger

A Laravel + MongoDB API for magical incident reporting, featuring department-based authentication, queue-driven processing, and a gateway pattern for flexible incident handling.

>"I’m going to bed before either of you come up with another clever idea to get us killed — or worse, expelled."
>– Philosopher’s Stone

---

## Requirements

- npm (optional but needed to use init script)
- Docker & Docker Compose

---

## Setup Instructions

**Clone the repository:**
  ```sh
  git clone git@github.com:unitiweb/incident-logger.git
  cd incident-logger
  ```

#### Option #1 (preferred)

I created an init script to handle all the setup details.

1. **Run the Init Script:**

  ```sh
  npm run init
  ```

#### Option #2 (manual)

If the init script fails (_I haven't tested it on windows_) you can setup manually.

1. **Copy and configure environment variables:**

  ```sh
  cp .env.example .env
  ```

No need to modify any .env settings unless you have port conflicts. So, just copy example file.

2. **Start the containers:**

  ```sh
  npm run up -- -d
  ```

3. **Install dependencies:**

  ```sh
  npm run composer:install
  ```

4. **Generate App Key:**

  ```sh
  npm run key:generate
  ```

5. **Seed the Database:**

  ```
  npm run db:reset
  ```

6. **Restart Docker Compose Containers:**

  ```sh
  npm run restart
  ```

---

## Database Seeder

- The seeder creates all departments with **hardcoded `magic_token` values** for easy testing.
- You can find these tokens in `database/seeders/DepartmentSeeder.php`.

---

## Running the Application

- **API server:** http://127.0.0.1:8040 (or your configured `APP_PORT`)
- **MongoDB:** 127.0.0.1:8041 (default, or your configured `MONGO_PORT`)

---

## Queue Workers & Priorities

- **Priority queues** are used to process Departments by priority_level as configured in the db.
- The worker is configured in `docker-compose.yml` and runs in it's own container:
    ```yaml
    entrypoint: ["php", "artisan", "queue:work", "--queue=high,medium,low"]
    ```
- When dispatching jobs, the queue is set based on department `priority_level`.

---

## API

### Authentication

- **All endpoints require a department `magic_token` in the `X-MAGIC-TOKEN` header.**
- Each department’s token is hardcoded in the seeder for easy testing.

| Department                          | Magic Token                                   |
|-------------------------------------|-----------------------------------------------|
| Auror Office                        | auror-office-token-123                        |
| Department of Mysteries             | department-of-mysteries-token-123             |
| Improper Use of Magic Office        | improper-use-of-magic-token-123               |
| Magical Law Enforcement Patrol      | magical-law-enforcement-patrol-token-123      |
| Magical Accidents and Catastrophes  | magical--accidents-and-catastrophes-token-123 |

---

#### API Gateway Endpoints

##### 1. Create Incident

- **URL:** `POST /api/incidents`
- **Headers:**
  - `X-MAGIC-TOKEN: <department_magic_token>`
  - `Content-Type: application/json`
  - `Accept: application/json`
- **Sample Request Payload:**
  ```json
  {
      "suspect_name": "Bellatrix Lestrange",
      "crime_type": "Dark Magic",
      "location": "Hogsmeade",
      "auror_on_scene": "Kingsley Shacklebolt",
      "witnesses": ["Minerva McGonagall", "Seamus Finnigan"]
  }
  ```

##### 2. Anomaly Routing

- **URL:** `POST /api/incidents`
- **Headers:**
  - `X-MAGIC-TOKEN: <department_magic_token>`
  - `Content-Type: application/json`
  - `Accept: application/json`
- **Sample Request Payload:**
  ```json
  {
    "phenomenon": "Time Loop",
    "witnesses": ["Luna Lovegood"],
    "anomaly_level": "high",
    "notes": "Temporal distortion detected in the Department of Mysteries."
  }
  ```

##### 3. Compliance Check

- **URL:** `POST /api/incidents`
- **Headers:**
  - `X-MAGIC-TOKEN: <department_magic_token>`
  - `Content-Type: application/json`
  - `Accept: application/json`
- **Sample Request Payload:**
  ```json
  {
    "wizard_name": "Harry Potter",
    "incident_type": "Underage Magic",
    "location": "Privet Drive",
    "reported_by": "Muggle"
  }
  ```

##### 4. Rule Audit

- **URL:** `POST /api/incidents`
- **Headers:**
  - `X-MAGIC-TOKEN: <department_magic_token>`
  - `Content-Type: application/json`
  - `Accept: application/json`
- **Sample Request Payload:**
  ```json
  {
    "patrol_id": "MLEP-2025-001",
    "officer": "Dawlish",
    "rule_broken": "Statute of Secrecy",
    "evidence": ["photograph", "wand trace"]
  }
  ```

##### 5. Muggle Wipe

- **URL:** `POST /api/incidents`
- **Headers:**
  - `X-MAGIC-TOKEN: <department_magic_token>`
  - `Content-Type: application/json`
  - `Accept: application/json`
- **Sample Request Payload:**
  ```json
  {
    "event": "Memory Charm",
    "affected_muggles": 3,
    "location": "London Underground",
    "lead_wizard": "Arthur Weasley"
  }
  ```

#### API Reports Endpoint

- **URL:** `GET /api/incidents/reports/{department_id}`
- **Headers:**
  - `X-MAGIC-TOKEN: <department_magic_token>`
  - `Content-Type: application/json`
  - `Accept: application/json`

## Artisan Commands

### **Reset & Seed Database**
```sh
./vendor/bin/sail artisan db:reset
```
- Drops all collections and reseeds departments.

### **Reprocess Incomplete Incidents**
```sh
./vendor/bin/sail artisan spell:residue-analyze
```
- Finds all incidents with `status` of `pending` or `failed` and re-dispatches them for processing.

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

>"Happiness can be found even in the darkest of times, if one only remembers to turn on the light."
>– Prisoner of Azkaban