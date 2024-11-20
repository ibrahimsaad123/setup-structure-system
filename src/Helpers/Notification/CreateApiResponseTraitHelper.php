<?php

namespace Saad\SetupStructureSystem\Helpers\Notification;
use Illuminate\Support\Facades\File;

class CreateApiResponseTraitHelper
{
    public static function createApiResponseTrait()
    {
        $traitPath = app_path('Traits/HasApiResponse.php');

        if (!File::exists($traitPath)) {
            File::ensureDirectoryExists(app_path('Traits'));

            File::put($traitPath, self::getApiResponseTraitTemplate());
        }
    }

    private static function getApiResponseTraitTemplate(): string
    {
        return <<<'TRAIT'
<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HasApiResponse
{
    public function success($data, string $message = 'ok', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public function successMessage(string $message = 'ok', int $status = 200): JsonResponse
    {
        return $this->success(null, $message, $status);
    }

    public function failed($message, int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
        ], $status);
    }

    public function noContent(): JsonResponse
    {
        return response()->json(null, 204);
    }   
}
TRAIT;
    }
}