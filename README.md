# Summer Internship Project: SMDevis

Welcome to the Summer Internship Project repository for SMDevis. This project is designed to connect individuals in need of house renovation and various service-related projects with potential partners who offer those services.

## Table of Contents

- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
- [Usage](#usage)
  - [Submitting a Project](#submitting-a-project)
  - [Becoming a Potential Partner](#becoming-a-potential-partner)
  - [Admin Dashboard](#admin-dashboard)
- [Contributing](#contributing)
- [License](#license)

## Getting Started

To begin using the SMDevis project, follow the steps below:

### Prerequisites

- [Symfony](https://symfony.com/)
- [MySQL](https://www.mysql.com/)

### Installation

1. Clone this repository: `git clone https://github.com/m0rphMZ/Summer_Internship_SMDevis.git`
2. Navigate to the project directory: `cd Summer_Internship_SMDevis`
3. Install dependencies: `composer install`
4. Configure your database settings in `config/packages/doctrine.yaml`.
5. Create the database schema: `php bin/console doctrine:schema:create`

## Usage

This section outlines the usage of various features within the SMDevis project.

### Submitting a Project

1. Open your browser and navigate to `http://localhost:8000/newprojet`.
2. Provide project details, including the required service and contact information.
3. Submit the form.

### Becoming a Potential Partner

1. Potential partners can apply by visiting `http://localhost:8000/form`.
2. Complete the partner application form.
3. Await admin approval.
4. Once approved, you will receive access to the dashboard.

### Admin Dashboard

1. Admins can access the admin dashboard at `http://localhost:8000/dashboard`.
2. Review partner applications and approve/deny them.
3. Monitor and manage the platform's quality.
4. Partners with approved subscriptions can log in to the dashboard to view project submissions.

## Contributing

We welcome contributions to the SMDevis project. To contribute:

1. Fork the repository on GitHub.
2. Clone your forked repository to your local machine.
3. Create a new branch: `git checkout -b feature/your-feature-name`.
4. Implement your changes and commit them.
5. Push the changes to your fork: `git push origin feature/your-feature-name`.
6. Create a pull request on the main repository.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
