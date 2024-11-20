

# Laravel Structure & Notification System Package

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

## 📖 Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [File Structure Overview](#file-structure-overview)
- [How the Package Works](#how-the-package-works)
- [Contributing](#contributing)
- [License](#license)

---

## 📝 Introduction

This package simplifies the creation of a professional and scalable project structure in Laravel. It provides:
- Tools to generate structured directories and files for features.
- A complete notification system integrated with Firebase, ready to handle notifications efficiently.
- Suitable for beginners who want to learn best practices for structuring Laravel projects.

---

## ✨ Features

- Automatically generate a professional project structure.
- Integrate Firebase notifications with `kreait/firebase-php`.
- Options to include or exclude notifications in features.
- Simplifies development and ensures consistency across projects.

---

## ⚡ Installation

### Requirements
- PHP >= 8.0
- Laravel >= 10.x
- `kreait/laravel-firebase` package installed


---

### Steps for Adding and Using the Package

#### 🛠 Adding the Package from GitHub

1. **Add the repository to your `composer.json`:**  
   Open the `composer.json` file in your project and add the following to the `repositories` section:

   ```json
   "repositories": [
       {
           "type": "vcs",
           "url": "https://github.com/ibrahimsaad123/setup-structure-system"
       }
   ]
   ```

2. **Add the package to `require`:**  
   Under the `require` section, add the package as follows:  
   ```json
   "require": {
       "saad/setup-structure-system": "@dev"
   }
   ```

3. **Run Composer Update:**  
   To install the package in your project, run the following command:  
   ```bash
   composer update
   ```

---

### 🔧 Configure Firebase

Add the following settings to your `.env` file for Firebase integration:

```env
FIREBASE_CREDENTIALS=storage/app/firebase/google-services.json
FIREBASE_DATABASE_URL=https://your-firebase-project-id.firebaseio.com
```

---

### 🧹 Clear and Cache Configuration

Run these commands to clear and cache the Laravel configuration:

```bash
php artisan config:clear
php artisan config:cache
```

---

## 🛠 Usage

### 1. Create a Feature Without Notifications

To generate a professional structure for a new feature, run:

```bash
php artisan setup:structure FeatureName
```

This will create the necessary directories and files for the feature.

---

### 2. Create a Feature With Notifications

To include a notification system in the feature, use:

```bash
php artisan setup:structure FeatureName --with-notifications
```

This will additionally set up events, listeners, models, and resources for the notification system.

---


### 📂 File Structure in the `app/` Directory (Without Notifications)

The generated file structure when creating a feature without notifications:

```plaintext
app/
├── Http/
│   ├── Controllers/
│   │   └── FeatureName/
│   │       └── FeatureNameController.php
│   ├── Requests/
│   │   └── FeatureName/
│   │       └── FeatureNameRequest.php
│   ├── Resources/
│       └── FeatureName/
│           └── FeatureNameResource.php
├── Models/
│   └── FeatureName.php
├── Services/
│   └── FeatureName/
│       └── FeatureNameService.php
├── Repositories/
│   └── FeatureName/
│       └── FeatureNameRepository.php
└── Observers/
    └── FeatureName/
        └── FeatureNameObserver.php
```

#### File Purpose & Integration

1. **FeatureNameController.php**  
   - **Purpose**: Manages HTTP requests for the feature.
   - **Integration**: Relies on `FeatureNameService` for business logic and uses `FeatureNameResource` for formatting API responses.
   - **Interacts With**: Routes and the service layer.
---
2. **FeatureNameRequest.php**  
   - **Purpose**: Handles request validation for incoming data.
   - **Integration**: Ensures data integrity before passing it to `FeatureNameController`.
   - **Interacts With**: Controller.
---
3. **FeatureNameResource.php**  
   - **Purpose**: Formats the response data for the API.
   - **Integration**: Used by `FeatureNameController` to shape the output.
   - **Interacts With**: Controller and Model.
---
4. **FeatureName.php (Model)**  
   - **Purpose**: Represents the database table for the feature.
   - **Integration**: Used by the repository layer to interact with the database.
   - **Interacts With**: Database, Repository.
---
5. **FeatureNameService.php**  
   - **Purpose**: Contains the business logic for the feature.
   - **Integration**: Acts as a mediator between the controller and repository.
   - **Interacts With**: Controller, Repository.
---
6. **FeatureNameRepository.php**  
   - **Purpose**: Handles database queries for the feature.
   - **Integration**: Abstracts database operations for `FeatureNameService`.
   - **Interacts With**: Service, Model.
---
7. **FeatureNameObserver.php**  
   - **Purpose**: Listens to lifecycle events on the `FeatureName` model (e.g., creating, updating).
   - **Integration**: Automatically responds to model changes.
   - **Interacts With**: Model.

---

### 📂 File Structure in the `app/` Directory (With Notifications)

The generated file structure when creating a feature with notifications:

```plaintext
app/
├── Events/
│   └── FeatureName/
│       └── FeatureEvent.php  
├── Helpers/
│   └── SendNotificationHelper.php  
├── Http/
│   ├── Controllers/
│   │   ├── FeatureName/
│   │   │   └── FeatureNameController.php  
│   │   ├── NotificationController.php  
│   ├── Requests/
│   │   └── FeatureName/
│   │       └── FeatureNameRequest.php  
│   ├── Resources/
│       ├── FeatureName/
│       │   └── FeatureNameResource.php  
│       └── Notification/
│           └── NotificationResource.php  
├── Interfaces/
│   └── NotificationEventInterface.php  
├── Jobs/
│   └── SendNotificationJob.php  
├── Listeners/
│   └── FeatureName/
│       └── FeatureListener.php  
├── Models/
│   ├── FeatureName.php  
│   └── Notification.php  
├── Observers/
│   └── FeatureName/
│       └── FeatureObserver.php  
├── Policies/
│   └── NotificationPolicy.php  
├── Providers/
│   ├── AppServiceProvider.php  
│   └── EventServiceProvider.php  
├── Repositories/
│   └── FeatureName/
│       └── FeatureNameRepository.php  
├── Services/
│   ├── FeatureName/
│   │   └── FeatureNameService.php  
│   └── NotificationService.php  
└── Traits/
    └── HasApiResponse.php  
```
#### File Purpose & Integration

Below is the complete list of all files added or used by the package, their purposes, and how they integrate with other components.

---

1. **NotificationController.php**  
   - **Purpose**: Manages HTTP requests related to notifications (e.g., fetching, marking as read).  
   - **Integration**:  
     - Calls `NotificationService` for core logic.  
     - Utilizes `NotificationResource` for API responses.  
   - **Interacts With**:  
     - Routes (API endpoints).  
     - Service layer (`NotificationService`).  

---

2. **NotificationResource.php**  
   - **Purpose**: Formats notification data for API responses (e.g., JSON structure).  
   - **Integration**:  
     - Used by `NotificationController` to send structured responses.  
   - **Interacts With**:  
     - Controller (`NotificationController`).  
     - Model (`Notification`).  

---

3. **Notification.php (Model)**  
   - **Purpose**: Represents the `notifications` table in the database.  
   - **Integration**:  
     - Handles notification data CRUD operations.  
   - **Interacts With**:  
     - Database (via Eloquent ORM).  
     - Repository layer.  

---

4. **NotificationService.php**  
   - **Purpose**: Contains the business logic for managing notifications, such as creating and sending them.  
   - **Integration**:  
     - Works between `NotificationController` and `SendNotificationJob`.  
     - Fetches or modifies data using `NotificationRepository`.  
   - **Interacts With**:  
     - Controller.  
     - Job (for async tasks).  

---

5. **SendNotificationJob.php**  
   - **Purpose**: Asynchronously sends notifications using Firebase to avoid performance delays.  
   - **Integration**:  
     - Offloaded by `NotificationService` to handle sending tasks.  
   - **Interacts With**:  
     - Firebase via `SendNotificationHelper`.  

---

6. **SendNotificationHelper.php**  
   - **Purpose**: Encapsulates Firebase messaging logic for sending notifications.  
   - **Integration**:  
     - Called directly by `SendNotificationJob` or `NotificationService`.  
   - **Interacts With**:  
     - Firebase SDK.  

---

7. **NotificationPolicy.php**  
   - **Purpose**: Manages access control for notifications, ensuring only authorized users can view or act on them.  
   - **Integration**:  
     - Configured in `AuthServiceProvider`.  
   - **Interacts With**:  
     - Controller for permission checks.  

---

8. **NotificationEventInterface.php**  
   - **Purpose**: Ensures a consistent structure for all notification-related events.  
   - **Integration**:  
     - Implemented by specific events like `FeatureNameEvent`.  
   - **Interacts With**:  
     - Events and Listeners.  

---

9. **FeatureNameEvent.php**  
   - **Purpose**: Represents an event in the specific feature, such as an order placement.  
   - **Integration**:  
     - Triggers when specific actions occur in the feature.  
   - **Interacts With**:  
     - Listener.  

---

10. **FeatureNameObserver.php**  
   - **Purpose**: Monitors lifecycle changes in the `FeatureName` model and triggers necessary actions, like creating notifications.  
   - **Integration**:  
     - Detects events (e.g., created, updated) and interacts with the event system.  
   - **Interacts With**:  
     - Model.  
     - Event system.  

---

11. **FeatureNameListener.php**  
   - **Purpose**: Listens to `FeatureNameEvent` and triggers specific actions, such as queuing a notification job.  
   - **Integration**:  
     - Activated when `FeatureNameEvent` is fired.  
   - **Interacts With**:  
     - Event.  
     - Job or Service layer.  

---

12. **HasApiResponse.php (Trait)**  
   - **Purpose**: Provides a standardized format for API responses, such as success or error messages.  
   - **Integration**:  
     - Used in the base `Controller`.  
   - **Interacts With**:  
     - Controllers and resources.  


---

## 🛑 How the Package Works

### 1. **Feature Setup Command**

- **Command**: `php artisan setup:structure FeatureName`
- **Steps**:
  1. Calls `CreateFeatureDirectoriesHelper` to create the feature’s directory structure.
  2. Uses `GenerateFeatureFilesHelper` to generate models, controllers, and other components.

---

### 2. **Notification System Lifecycle**

1. **Incoming API Request**:
   - The `NotificationController` handles incoming API requests.
   
2. **Event Dispatch**:
   - Events trigger listeners to handle the logic for processing notifications.

3. **Job Execution**:
   - Jobs are dispatched to handle the actual sending of notifications via Firebase.

4. **Firebase Messaging**:
   - Notifications are sent to the target devices using Firebase's messaging API.

---

### 3. **Integration**

- Files like `EnsureEventServiceProviderHelper` ensure seamless integration between Laravel's event system and the generated notification system.

---

## 🤝 Contributing

Contributions are welcome! Feel free to fork the repository and submit pull requests for improvements.

