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
The final solution is composed of these Azure Services:

| Azure Services Used | Purpose |
| :-----------------: | :-----: |
| Resource Group | Container for all Azure Services |
| App Service Plan | Defines a set of compute resources for the App Service to run |
| App Service | PAAS HTTP-based service for hosting web applications, REST APIs, and mobile back end |
| App Service (Slot) | PAAS Production and other environments |
| Front Door | Cloud CDN with intelligent threat protection | 
| Virtual network | Project requirement |
| Storage Account | BLOB Storage Container to store JSON, image and audo objects |
| Application Insights | Monitor Function that writes documents to Cosmos DB |
| CosmosDB | NoSQL Database that contains the JSON User Objects |
| Function App | Functions to write JSON documents to Cosmos DB and retrieve JSON documents from Cosmos DB |
| DevOps | CICD of the PHP Web Application |


Example Output
--------------
![Alt text](images/example-output.png?raw=true "Example Output of Azure DevOps CICD Project")