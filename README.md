# mermshaus/CRC

This is work in progress. I am not an expert on the topic by any means. Therefore, I have trouble finding and verifying information about common CRC algorithms. I am especially looking for reliable test vectors.

## Implemented algorithms

- CRC1
- CRC16, CRC16-CCITT, CRC16-DNP, CRC16-Modbus, CRC16-QT, CRC16-USB, CRC16-XModem, CRC16-ZModem

## Usage example

```PHP
<?php

// Autoloading via Composer
require __DIR__ . '/vendor/autoload.php';

$crc16ccitt = new mermshaus\CRC\CRC16CCITT();

$crc16ccitt->update('Hello');
$crc16ccitt->update(' World!');

$checksum = $crc16ccitt->finish();

var_dump(bin2hex($checksum)); // string(4) "882a"
```

## Testing

``` bash
$ phpunit
```

## Credits

- This library is mostly a port of [Digest CRC](https://github.com/postmodern/digest-crc) for Ruby by Hal Brodigan.

## Links

- [Digest CRC](https://github.com/postmodern/digest-crc). The Ruby library on which this library is based.
- [pycrc](https://github.com/tpircher/pycrc). A tool for generating C code and corresponding lookup tables for diverse CRC algorithms. Used by Digest CRC.
- [CRC calculation](http://www.zorc.breitbandkatze.de/crc.html). An online calculator to generate checksums for arbitrary polynomials and input. Recommended by pycrc.
- [On-line CRC calculation and free library](http://www.lammertbies.nl/comm/info/crc-calculation.html). Another online calculator for some CRC algorithms.
- [Catalogue of parametrised CRC algorithms](http://reveng.sourceforge.net/crc-catalogue/). Information about many different CRC algorithms.

