<?php

namespace App\Services;

use RuntimeException;

/**
 * Raised when an IMT/U assessment cannot be produced. The message is safe to
 * show to the user as-is.
 */
class NutritionAssessmentException extends RuntimeException {}
