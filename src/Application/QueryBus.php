<?php

namespace App\Application;

interface QueryBus
{

    public function execute($query);
}
