<?php
declare (strict_types=1);

namespace App\Domain;

interface TaskIdentityProvider
{

    public function nextId();
}
