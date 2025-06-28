<?php

namespace Tests\Feature;

#region USE

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class ExampleTest extends TestCase
{
    use RefreshDatabase;

    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    #endregion
}
