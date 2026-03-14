<?php declare(strict_types=1);

namespace Application\Test\Helpers;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Application\Helpers\Data;

class DataTest extends TestCase
{
    public static function dataProviderFormatPhoneMethod() 
    {
        return [
            ['1234567890', '(12) 3456-7890'],
            ['12345678901', '(12) 34567-8901'],
            ['', null],
            ['abc', null],
        ];
    }

    #[DataProvider('dataProviderFormatPhoneMethod')]
    public function testShouldFormatPhone(string $actual, ?string $expected): void 
    {
        $data = new Data();

        $result = $data->formatPhone($actual);

        $this->assertEquals($expected, $result);
    }

    public static function dataProviderRemoveNonNumericCharacterMethod() 
    {
        return [
            ['1234567890', '1234567890'],
            ['abc123def456asdfg7890', '1234567890'],
            ['!@#$%^&*()_+', ''],
            ['abcdef', ''],
            ['', ''],
        ];
    }

    #[DataProvider('dataProviderRemoveNonNumericCharacterMethod')]
    public function testShouldRemoveNonNumericCharacter(string $actual, string $expected): void 
    {
        $data = new Data();

        $result = $data->removeNonNumericCharacter($actual);

        $this->assertEquals($expected, $result);
    }


    public static function dataProviderIsValidNumberPhoneMethod(): array 
    {
        return [
            ['1234567890', true],
            ['12345678901', true],
            ['12345', false],
            ['', false],
            ['abc', false],
        ];
    }

    #[DataProvider('dataProviderIsValidNumberPhoneMethod')]
    public function testMustValidateNumberPhone(string $actual, bool $expected): void 
    {
        $data = new Data();

        $result = $data->isValidNumberPhone($actual);

        $this->assertEquals($expected, $result);
    }
}