<?php

namespace Application\Helpers;

class Calculate
{
    /**
     * Calculate the percentage of a part relative to a total.
     *
     * @param int|float $part The part value.
     * @param int|float $total The total value.
     * @return float The percentage value rounded to two decimal places.
     */
    public static function percentage(float $part, float $total): float
    {
        if ($total == 0) {
            return 0.0;
        }
        return round(($part / $total) * 100, 2);
    }

    /**
     * Formats a percentage value as a string, with two decimal places.
     *
     * If the percentage value is zero, returns '0%'. Otherwise, returns a
     * string with the percentage value rounded to two decimal places, with
     * a comma as the decimal separator and a percent sign suffix.
     *
     * @param float $percentage The percentage value to format.
     * @return string The formatted percentage value.
     */
    public function percentageFormat(float $percentage): string 
    {
        if ($percentage == 0.0) {
            return '0%';
        }
        return number_format($percentage, 2, ',', '.') . '%';
    }
}