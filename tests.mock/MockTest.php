<?php

namespace MockTests;

/**
 * @testdox This is the testdox text for the mock test
 * @group default
 * @group case group
 */
class MockTest extends MockTestCase
{
    public function dataProvider()
    {
        return [
            [1, 1],
            [2, 2],
        ];
    }

    /** @test */
    public function this_is_a_passing_test()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function this_is_a_failing_test()
    {
        $this->assertTrue(false);
    }

    /** @test */
    public function this_is_a_risky_test()
    {
        // No assertions
    }

    /** @test */
    public function this_is_a_skipped_test()
    {
        $this->markTestSkipped("The reason why the test is skipped");
    }

    /** @test */
    public function this_is_an_incomplete_test()
    {
        $this->markTestIncomplete("The reason why the test is incomplete");
    }

    /**
     * @test
     * @dataProvider dataProvider
     * @group method group
     */
    public function this_is_a_test_using_a_data_provider($x, $y)
    {
        $this->assertTrue($x === $y, "Failed aserting that {$x} is {$y}");
    }
}
