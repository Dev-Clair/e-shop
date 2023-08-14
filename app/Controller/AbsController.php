<?php

declare(strict_types=1);

namespace app\Controller;

abstract class AbsController implements IntController
{

    protected function sanitizeInput()
    {
    }

    protected function validateInput()
    {
    }

    protected function validateAuthorization()
    {
    }

    protected function setSessionMessage()
    {
    }
}
