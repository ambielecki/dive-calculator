<?php

namespace Ambielecki\DiveCalculator\Tests;

use Tests\TestCase;
use Ambielecki\DiveCalculator\DiveCalculator;

class DiveCalculatorTest extends TestCase {

    public function testGetPressureGroup() {
        $diveCalculator = new DiveCalculator();

        $simple_dive_pg = $diveCalculator->getPressureGroup(40, 15);
        $depth_under_column = $diveCalculator->getPressureGroup(39, 15);
        $exact_time_dive = $diveCalculator->getPressureGroup(40, 22);
        $depth_over_column = $diveCalculator->getPressureGroup(41, 22);
        $over_ndl = $diveCalculator->getPressureGroup(40, 150);
        $over_depth = $diveCalculator->getPressureGroup(141, 5);
        $accept_strings = $diveCalculator->getPressureGroup('40', '10', '5');
        $not_numeric_1 = $diveCalculator->getPressureGroup(40, 15, 'fred');
        $not_numeric_2 = $diveCalculator->getPressureGroup(40, 'fred', 5);

        $this->assertTrue('B' === $simple_dive_pg);
        $this->assertTrue('B' === $depth_under_column);
        $this->assertTrue('C' === $exact_time_dive);
        $this->assertTrue('F' === $depth_over_column);
        $this->assertTrue(DiveCalculator::OVER_NDL === $over_ndl);
        $this->assertTrue(DiveCalculator::OVER_DEPTH === $over_depth);
        $this->assertTrue('B' === $accept_strings);
        $this->assertTrue(DiveCalculator::NOT_NUMERIC === $not_numeric_1);
        $this->assertTrue(DiveCalculator::NOT_NUMERIC === $not_numeric_2);
    }
}