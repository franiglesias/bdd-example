<?php
declare (strict_types=1);

namespace App\Application;

interface CommandBus
{

    public function execute($command): void;
}
