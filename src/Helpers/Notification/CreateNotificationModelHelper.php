<?php
namespace Saad\SetupStructureSystem\Helpers\Notification;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CreateNotificationModelHelper
{
    public static function createNotificationModelAndMigration()
    {
        if (!self::modelExists()) {
            self::createNotificationModel();
        }

        if (!self::migrationFileExists('create_notifications_table') && !self::tableExists('notifications')) {
            self::createNotificationsMigrationFile();
        }

        if (!self::migrationFileExists('create_notification_user_table') && !self::tableExists('notification_user')) {
            self::createNotificationUserMigrationFile();
        }
    }

    private static function modelExists(): bool
    {
        return File::exists(app_path('Models/Notification.php'));
    }

    private static function tableExists(string $tableName): bool
    {
        return DB::getSchemaBuilder()->hasTable($tableName);
    }

    private static function migrationFileExists(string $migrationName): bool
    {
        $migrations = File::files(database_path('migrations'));
        foreach ($migrations as $migration) {
            if (str_contains($migration->getFilename(), $migrationName)) {
                return true;
            }
        }
        return false;
    }

    private static function createNotificationModel()
    {
        $modelTemplate = self::getNotificationModelTemplate();
        File::put(app_path('Models/Notification.php'), $modelTemplate);
    }

    private static function createNotificationsMigrationFile()
    {
        $migrationTemplate = self::getNotificationsMigrationTemplate();
        $migrationPath = database_path('migrations/' . date('Y_m_d_His') . '_create_notifications_table.php');
        File::put($migrationPath, $migrationTemplate);
    }

    private static function createNotificationUserMigrationFile()
    {
        $migrationTemplate = self::getNotificationUserMigrationTemplate();
        $migrationPath = database_path('migrations/' . date('Y_m_d_His', strtotime('+1 second')) . '_create_notification_user_table.php');
        File::put($migrationPath, $migrationTemplate);
    }

    private static function getNotificationModelTemplate(): string
    {
        return <<<'MODEL'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'reason'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'notification_user')->withTimestamps();
    }
}
MODEL;
    }

    private static function getNotificationsMigrationTemplate(): string
    {
        return <<<'MIGRATION'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->string('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
MIGRATION;
    }

    private static function getNotificationUserMigrationTemplate(): string
    {
        return <<<'MIGRATION'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notification_user', function (Blueprint $table) {
            $table->foreignId('notification_id')->constrained('notifications')->cascadeOnDelete();
            $table->foreignId('receiver_id'); 
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            $table->primary(['notification_id', 'receiver_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_user');
    }
};
MIGRATION;
    }
}