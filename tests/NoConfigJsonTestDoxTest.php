<?php

namespace Tests;

use Beblife\JsonTestDox;

class NoConfigJsonTestDoxTest extends TestCase
{
    protected function getPrinter()
    {
        return new JsonTestDox();
    }

    /** @test */
    public function it_returns_an_empty_list()
    {
        $printer = $this->getPrinter();

        $this->assertEquals([], $printer->results()["tests"]);
    }

    /** @test */
    public function it_returns_the_total_amount_as_zero()
    {
        $printer = $this->getPrinter();

        $this->assertEquals([
            "total" => 0,
        ], $printer->results()["meta"]);
    }

    /** @test */
    public function it_prints_the_results_to_json()
    {
        $printer = $this->getPrinter();

        $this->assertJson('{
            "tests": [],
            "meta": {
                "total": 0
            }
        }', $printer->print());
    }
}
