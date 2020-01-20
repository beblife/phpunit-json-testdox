<?php

namespace Tests;

use Beblife\JsonTestDox;

class JsonTestDoxTest extends TestCase
{
    protected function getPrinter()
    {
        return new JsonTestDox("phpunit.mock.xml");
    }

    /** @test */
    public function it_can_return_the_phpunit_config_it_is_using()
    {
        $printer = $this->getPrinter();

        $this->assertStringContainsString("phpunit.mock.xml", $printer->config());
    }

    /** @test */
    public function it_returns_all_relevant_test_results()
    {
        $printer = $this->getPrinter();

        $result = $printer->results();

        $this->assertCount(7, $result["tests"]);
        $this->assertCount(1, $result["cases"]);
        $this->assertEquals([
            "case group",
            "default",
            "method group",
        ], $result['groups']);
        $this->assertEquals([
            "tests_total" => 7,
            "cases_total" => 1,
            "groups_total" => 3,
        ], $printer->results()["meta"]);
    }
}
