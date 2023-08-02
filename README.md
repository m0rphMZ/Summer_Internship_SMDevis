# SM DEVIS Summer Internship Project

Welcome to the SM DEVIS Summer Internship Project repository. This project aims to create a platform that connects individuals seeking various house renovation and service-related projects with potential partners who offer those services.

## Table of Contents

- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
- [Usage](#usage)
  - [Submitting a Project](#submitting-a-project)
  - [Browsing Projects](#browsing-projects)
  - [Admin Dashboard](#admin-dashboard)
- [Contributing](#contributing)
- [License](#license)

## Getting Started

To get started using the SM DEVIS project, follow the steps below:

### Prerequisites

- [Symfony](https://symfony.com/)
- [MySQL](https://www.mysql.com/)

### Installation

1. Clone this repository: `git clone https://github.com/m0rphMZ/SMDEVIS_SummerInternship.git`
2. Navigate to the project directory: `cd SMDEVIS_SummerInternship`
3. Install dependencies: `composer install`
4. Configure your database settings in `config/packages/doctrine.yaml`.
5. Create the database schema: `php bin/console doctrine:schema:create`

## Usage

This section explains how to use different aspects of the SM DEVIS project.

### Submitting a Project

1. Open your browser and navigate to `http://localhost:8000/newprojet`.
2. Fill out the project details, including the type of service needed and contact information.
3. Submit the form.

### Browsing Projects

1. Service providers can browse available projects by visiting `http://localhost:8000/form`.
2. View the list of projects and their details.
3. Contact the project requester through provided contact information.

### Admin Dashboard

1. Admins can access the admin dashboard at `http://localhost:8000/dashboard`.
2. Approve or deny potential partner subscriptions.
3. Manage the overall platform and ensure its quality.

## Contributing

We welcome contributions to the SM DEVIS project. To contribute:

1. Fork the repository on GitHub.
2. Clone your forked repository to your local machine.
3. Create a new branch: `git checkout -b feature/your-feature-name`.
4. Make your changes and commit them.
5. Push the changes to your fork: `git push origin feature/your-feature-name`.
6. Create a pull request on the main repository.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
