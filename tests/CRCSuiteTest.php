<?php

namespace mermshaus\CRC\Tests;

use mermshaus\CRC\CRC1;
use mermshaus\CRC\CRC16;
use mermshaus\CRC\CRC16CCITT;
use mermshaus\CRC\CRC16DNP;
use mermshaus\CRC\CRC16Modbus;
use mermshaus\CRC\CRC16QT;
use mermshaus\CRC\CRC16USB;
use mermshaus\CRC\CRC16XModem;
use mermshaus\CRC\CRC16ZModem;
use mermshaus\CRC\CRCInterface;
use PHPUnit_Framework_TestCase;

/**
 *
 */
class CRCSuiteTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @param string $string
     * @return string
     */
    protected function strToHex($string)
    {
        $hex = '';
        $len = strlen($string);

        for ($i = 0; $i < $len; $i++) {
            $ord = ord($string[$i]);
            $hex .= (($ord >> 4) ? dechex($ord) : '0' . dechex($ord));
        }

        return $hex;
    }

    /**
     * @dataProvider providerAlgorithmsWork
     */
    public function testAlgorithmsWork(
        CRCInterface $obj,
        $data,
        $expected
    ) {
        $chunkSize = 1;

        foreach (str_split($data, $chunkSize) as $byte) {
            $obj->update($byte);
        }

        $this->assertEquals($expected, $this->strToHex($obj->finish()));

        // Reset and test again

        $obj->reset();

        foreach (str_split($data, $chunkSize) as $byte) {
            $obj->update($byte);
        }

        $this->assertEquals($expected, $this->strToHex($obj->finish()));

        // Reset and test again with different $chunkSize

        $obj->reset();
        $chunkSize = 3;

        foreach (str_split($data, $chunkSize) as $byte) {
            $obj->update($byte);
        }

        $this->assertEquals($expected, $this->strToHex($obj->finish()));
    }

    /**
     *
     * @return array
     */
    public function providerAlgorithmsWork()
    {
        $tests = array();

        $data = '1234567890';

        $tests[] = array(new CRC1(),        $data,   '0d');
        $tests[] = array(new CRC16(),       $data, 'c57a');
        $tests[] = array(new CRC16CCITT(),  $data, '3218');
        $tests[] = array(new CRC16DNP(),    $data, '1bbc');
        $tests[] = array(new CRC16Modbus(), $data, 'c20a');
        $tests[] = array(new CRC16QT(),     $data, '4b13');
        $tests[] = array(new CRC16USB(),    $data, '3df5');
        $tests[] = array(new CRC16XModem(), $data, 'd321');
        $tests[] = array(new CRC16ZModem(), $data, 'd321');

        $data = 'test';

        $tests[] = array(new CRC1(),        $data,   'c0');
        $tests[] = array(new CRC16(),       $data, 'f82e');
        $tests[] = array(new CRC16CCITT(),  $data, '1fc6');
        $tests[] = array(new CRC16DNP(),    $data, '75b4');
        $tests[] = array(new CRC16Modbus(), $data, 'dc2e');
        //$tests[] = array(new CRC16QT(),     $data, '4b13');
        //$tests[] = array(new CRC16USB(),    $data, '3df5');
        $tests[] = array(new CRC16XModem(), $data, '9b06');
        //$tests[] = array(new CRC16ZModem(), $data, 'd321');

        return $tests;
    }
}
