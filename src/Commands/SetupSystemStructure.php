<?php

namespace Saad\SetupStructureSystem\Commands;

use Illuminate\Console\Command;
use Saad\SetupStructureSystem\Helpers\Notification\EnsureEventServiceProviderHelper;
use Saad\SetupStructureSystem\Helpers\Notification\CreateDirectoriesHelper;
use Saad\SetupStructureSystem\Helpers\Notification\CreateEventHelper;
use Saad\SetupStructureSystem\Helpers\Notification\CreateHelperHelper;
use Saad\SetupStructureSystem\Helpers\Notification\CreateListenerHelper;
use Saad\SetupStructureSystem\Helpers\Notification\CreateNotificationControllerHelper;
use Saad\SetupStructureSystem\Helpers\Notification\CreateNotificationEventInterfaceHelper;
use Saad\SetupStructureSystem\Helpers\Notification\CreateNotificationJobHelper;
use Saad\SetupStructureSystem\Helpers\Notification\CreateNotificationModelHelper;
use Saad\SetupStructureSystem\Helpers\Notification\CreateNotificationPolicyHelper;
use Saad\SetupStructureSystem\Helpers\Notification\CreateNotificationResourceHelper;
use Saad\SetupStructureSystem\Helpers\Notification\CreateNotificationServiceHelper;
use Saad\SetupStructureSystem\Helpers\Notification\CreateApiResponseTraitHelper;
use Saad\SetupStructureSystem\Helpers\Structure\CreateFeatureDirectoriesHelper;
use Saad\SetupStructureSystem\Helpers\Structure\CreateRepositoryHelper;
use Saad\SetupStructureSystem\Helpers\Structure\CreateServiceHelper;
use Saad\SetupStructureSystem\Helpers\Structure\GenerateFeatureFilesHelper;

class SetupSystemStructure extends Command
{
    protected $signature = 'setup:structure {featureName} {--with-notifications}';
    protected $description = 'Setup a structured system with optional notification setup for a feature';

    public function handle()
    {
        $featureName = $this->argument('featureName');
        $withNotifications = $this->option('with-notifications');

        $this->setupBasicStructure($featureName);

        if ($withNotifications) {
            $this->setupNotificationSystem($featureName);
        }

        $this->info('System structure setup successfully!');
    }

    protected function setupBasicStructure(string $featureName)
    {
        CreateFeatureDirectoriesHelper::createFeatureDirectories($featureName);

        GenerateFeatureFilesHelper::generateFiles($featureName);
        CreateRepositoryHelper::createRepository($featureName);
        CreateServiceHelper::createService($featureName);
    }

    protected function setupNotificationSystem(string $featureName)
    {
        CreateApiResponseTraitHelper::createApiResponseTrait();
        CreateDirectoriesHelper::createDirectories($featureName);
        CreateEventHelper::createEvent($featureName);
        CreateListenerHelper::createListener($featureName);

        CreateNotificationServiceHelper::createNotificationService();
        CreateHelperHelper::createHelper();
        CreateNotificationControllerHelper::createNotificationController();
        CreateNotificationResourceHelper::createNotificationResource();
        CreateNotificationModelHelper::createNotificationModelAndMigration();

        CreateNotificationEventInterfaceHelper::createNotificationEventInterface();
        CreateNotificationPolicyHelper::createNotificationPolicy();
        CreateNotificationJobHelper::createNotificationJob();

        EnsureEventServiceProviderHelper::updateEventServiceProvider($featureName);
    }
}