<?php

declare(strict_types=1);

namespace Project\Mvc\Traits;

trait FlashMessageTrait
{
    private function addErrorMessage(string $errorMessage): void
    {
        $_SESSION['error_message'] = $errorMessage; 
    }

    private function addSuccessMessage(string $successMessage): void
    {
        $_SESSION['success_message'] = $successMessage;
    }
}