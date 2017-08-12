<?php

namespace Ambielecki\DiveCalculator\Tests;

use PHPUnit\Framework\TestCase;
use Ambielecki\DiveCalculator\DiveCalculator;

class DiveCalculatorTest extends TestCase {

    private $diveCalculator;

    public function __construct($name = null, array $data = [], $dataName = '') {
        parent::__construct($name, $data, $dataName);
        $this->diveCalculator = new DiveCalculator();
    }

    public function testGetPressureGroup() {
        $simple_dive_pg = $this->diveCalculator->getPressureGroup(40, 15);
        $depth_under_column = $this->diveCalculator->getPressureGroup(39, 15);
        $exact_time_dive = $this->diveCalculator->getPressureGroup(40, 22);
        $depth_over_column = $this->diveCalculator->getPressureGroup(41, 22);
        $over_ndl = $this->diveCalculator->getPressureGroup(40, 150);
        $over_depth = $this->diveCalculator->getPressureGroup(141, 5);
        $accept_strings = $this->diveCalculator->getPressureGroup('40', '10', '5');
        $not_numeric_1 = $this->diveCalculator->getPressureGroup(40, 15, 'fred');
        $not_numeric_2 = $this->diveCalculator->getPressureGroup(40, 'fred', 5);

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

    public function testGetNewPressureGroup() {
        $simple_new_pg = $this->diveCalculator->getNewPressureGroup('H', 56);
        $no_residual_nitrogen = $this->diveCalculator->getNewPressureGroup('D', 300);
        $exact_end_time = $this->diveCalculator->getNewPressureGroup('L', 27);
        $exact_start_time = $this->diveCalculator->getNewPressureGroup('T', 54);
        $non_numeric_time = $this->diveCalculator->getNewPressureGroup('H', 'fred');
        $non_string_pg = $this->diveCalculator->getNewPressureGroup(1, 40);
        $too_long_pg = $this->diveCalculator->getNewPressureGroup('AB', 40);
        $accepts_lowercase = $this->diveCalculator->getNewPressureGroup('h', 56);
        $accepts_strings = $this->diveCalculator->getNewPressureGroup('H', '56');

        $this->assertTrue('C' === $simple_new_pg);
        $this->assertTrue(DiveCalculator::NO_RESIDUAL_NITROGEN === $no_residual_nitrogen);
        $this->assertTrue('H' === $exact_end_time);
        $this->assertTrue('H' === $exact_start_time);
        $this->assertTrue(DiveCalculator::NOT_NUMERIC === $non_numeric_time);
        $this->assertTrue(DiveCalculator::INVALID_PG === $non_string_pg);
        $this->assertTrue(DiveCalculator::INVALID_PG === $too_long_pg);
        $this->assertTrue('C' === $accepts_lowercase);
        $this->assertTrue('C' === $accepts_strings);
    }

    public function testGetResidualNitrogenTime() {
        $simple_rnt = $this->diveCalculator->getResidualNitrogenTime('M', 49);
        $exact_depth = $this->diveCalculator->getResidualNitrogenTime('K', 50);
        $depth_over_one = $this->diveCalculator->getResidualNitrogenTime('K', 51);
        $over_max_depth = $this->diveCalculator->getResidualNitrogenTime('D', 131);
        $non_numeric_time = $this->diveCalculator->getResidualNitrogenTime('H', 'fred');
        $non_string_pg = $this->diveCalculator->getResidualNitrogenTime(1, 40);
        $too_long_pg = $this->diveCalculator->getResidualNitrogenTime('AB', 40);
        $accepts_lowercase = $this->diveCalculator->getResidualNitrogenTime('h', 56);
        $accepts_strings = $this->diveCalculator->getResidualNitrogenTime('H', '56');

        $this->assertTrue(41 === $simple_rnt);
        $this->assertTrue(36 === $exact_depth);
        $this->assertTrue(29 === $depth_over_one);
        $this->assertTrue(DiveCalculator::OFF_REPETITIVE_CHART === $over_max_depth);
        $this->assertTrue(DiveCalculator::NOT_NUMERIC === $non_numeric_time);
        $this->assertTrue(DiveCalculator::INVALID_PG === $non_string_pg);
        $this->assertTrue(DiveCalculator::INVALID_PG === $too_long_pg);
        $this->assertTrue(23 === $accepts_lowercase);
        $this->assertTrue(23 === $accepts_strings);
    }

    public function testGetMaxBottomTime() {
        $simple_bottom_time = $this->diveCalculator->getMaxBottomTime(55);
        $exact_depth = $this->diveCalculator->getMaxBottomTime(60);
        $with_rnt = $this->diveCalculator->getMaxBottomTime(60, 15);
        $over_depth = $this->diveCalculator->getMaxBottomTime(141);
        $non_numeric_depth = $this->diveCalculator->getMaxBottomTime('fred');
        $non_numeric_rnt = $this->diveCalculator->getMaxBottomTime(60, 'fred');
        $accepts_strings = $this->diveCalculator->getMaxBottomTime('60', '15');

        $this->assertTrue(55 === $simple_bottom_time);
        $this->assertTrue(55 === $exact_depth);
        $this->assertTrue(40 === $with_rnt);
        $this->assertTrue(DiveCalculator::OVER_DEPTH === $over_depth);
        $this->assertTrue(DiveCalculator::NOT_NUMERIC === $non_numeric_depth);
        $this->assertTrue(DiveCalculator::NOT_NUMERIC === $non_numeric_rnt);
        $this->assertTrue(40 === $accepts_strings);
    }
}