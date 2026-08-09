<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withHeader('X-Api-Key', config('services.shera_viva.api_key', 'sv_secret_key_123456'));
    }
}
