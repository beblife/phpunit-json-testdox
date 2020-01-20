<?php

namespace Beblife;

class JsonTestDox
{
    protected $config;

    protected $prettifier;

    protected $tests = [];

    protected $cases = [];

    protected $groups = [];

    public function __construct($config = 'phpunit.xml')
    {
        $this->config = \PHPUnit\Util\Configuration::getInstance($config);
        $this->prettifier = new \PHPUnit\Util\TestDox\NamePrettifier();
    }

    public function results()
    {
        $this->run();

        return [
            "tests" => $this->tests,
            "cases" => $this->cases,
            "groups" => $this->groups,
            "meta" => [
                "tests_total" => count($this->tests),
                "cases_total" => count($this->cases),
                "groups_total" => count($this->groups),
            ],
        ];
    }

    public function print()
    {
        return json_encode($this->results(), JSON_PRETTY_PRINT);
    }

    public function config()
    {
        return $this->config->getFilename();
    }

    protected function run()
    {
        if (is_null($this->config)) {
            return [];
        }

        foreach ($this->config->getTestSuiteConfiguration()->tests() as $suite) {
            $this->addSuiteTests($suite);
        }

        return $this->tests;
    }

    private function addSuiteTests($suite)
    {
        if (is_a($suite, \PHPUnit\Framework\TestSuite::class)
        && !is_a($suite, \PHPUnit\Framework\DataProviderTestSuite::class)) {
            $this->addGroups($suite);
            $this->addCase($suite);
        }

        foreach ($suite->tests() as $testOrSuite) {
            $this->addGroups($testOrSuite);

            if (is_a($testOrSuite, \PHPUnit\Framework\TestSuite::class)) {
                $this->addSuiteTests($testOrSuite);
            }

            if (is_a($testOrSuite, \PHPUnit\Framework\TestCase::class)) {
                $this->addTest($testOrSuite);
            }
        }
    }

    private function addGroups($testOrSuite)
    {
        $groups = array_unique(array_merge($this->groups, $testOrSuite->getGroups()));
        sort($groups);

        $this->groups = $groups;
    }

    private function addCase($case)
    {
        array_push($this->cases, [
            "name" => $this->prettifier->prettifyTestClass($case->getName()),
            "class" => $case->getName(),
            "groups" =>  $case->getGroups(),
        ]);
    }

    private function addTest($test)
    {
        array_push($this->tests, [
            "name" => $this->prettifier->prettifyTestCase($test),
            "class" => get_class($test),
            "method" => $test->toString(),
            "groups" => $test->getGroups(),
        ]);
    }
}
