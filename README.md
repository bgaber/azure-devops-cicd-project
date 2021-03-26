# Azure DevOps CICD Project
![Alt text](readme_images/February-Cloud-Guru-Challenge-diagram.webp?raw=true "Azure DevOps CICD")

Goal
----
The objective of this project wasto create a web application that’s scalable and robust, as well as a stable deployment pipeline for the application.

The objective was achieved by designing and building a DevOps CICD Pipeline using Azure DevOps Pipeline, ARM Templates, App Service, Front Door, Blob Storage, Cosmos DB, and Virtual Network services from Azure.

Outcome
-------
In completing this project I was able to gain real-world skills in Azure Pipelines, App Services, Azure Front Door, Cosmos DB, ARM templates, and YAML configuration.

Main Steps
----------
This project was completed in five steps:

1. Using an ARM template, create a new Azure App Service with the following properties.
  * Integrate with an Azure Virtual Network named “ACGVnet”
  * Integrate Azure Front Door
  * Add a deployment slot named “staging”
  * Custom auto-scaling with 1–3 instances, defaulting to 1.
  * A scale rule which triggers the scale action at 70% CPU usage.
2. Using an ARM Template, create a Cosmos DB instance with following properties:
  * Enable Geo-Redundancy
  * API type should be Core (SQL)
3. Using an ARM Template, create a Storage Account with Blob Storage.
4. Create a simple web application and use GitHub as source control.
5. Use YAML to create a pipeline in Azure DevOps with the following components:
  * It should build the web application
  * If built successfully, run the tests.
  * If tests pass, deploy the application to the “staging” deployment slot for the Azure App Service created in step 1.


Solution
--------


Example Output
--------------
![Alt text](images/example-output.png?raw=true "Example Output of Azure DevOps CICD Project")