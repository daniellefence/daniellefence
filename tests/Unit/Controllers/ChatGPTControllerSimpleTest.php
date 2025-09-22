<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\ChatGPTController;
use Tests\TestCase;

class ChatGPTControllerSimpleTest extends TestCase
{
    private ChatGPTController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new ChatGPTController();
    }

    /** @test */
    public function controller_can_be_instantiated()
    {
        $this->assertInstanceOf(ChatGPTController::class, $this->controller);
    }

    /** @test */
    public function generate_method_exists()
    {
        $this->assertTrue(method_exists($this->controller, 'generate'));
    }

    /** @test */
    public function autofill_method_exists()
    {
        $this->assertTrue(method_exists($this->controller, 'autofill'));
    }
}