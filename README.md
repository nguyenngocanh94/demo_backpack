# Backpack

A sample demo backpack

## Installation
Configuration options are stored in the Environment Variables.

##### Requirements:
- Docker installed

# Start the containers
docker-compose up -d

# Recommendations
-----
After merging a branch or switching it, always run the command bellow FROM INSIDE THE CONTAINER to grant that the libraries are up-to-date.

```bash
composer install
```
Best Practices
-----

This project is guarded by some coding standards and best practices.
The commands listed below run on the pipeline to deliver the service, so if the code is not in compliance of the standards, it won't be deployed.


```bash
composer run-script php-fixer
```

# Any suggest tool:
- [https://www.npmjs.com/package/react-qr-code]  For QR generator