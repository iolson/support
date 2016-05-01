<?php

namespace IanOlson\Support\Tests;

use Mockery as m;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        m::close();
        parent::tearDown();
    }

    /**
     * @test
     */
    public function placeholder()
    {
        $this->assertTrue(true);
    }
}