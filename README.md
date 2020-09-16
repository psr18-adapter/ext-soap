# psr18-adapter/ext-soap

## Install

Via [Composer](https://getcomposer.org/doc/00-intro.md)

```bash
composer require psr18-adapter/ext-soap
```

## Usage

```php
new \Psr18Adapter\Soap\SoapPsr18Client(
    $psr18Client, 
    $psr7RequestFactory, 
    $psr7StreamFactory, 
    $soapWsdl, 
    $soapOptions
);
```

Adapter relies on injected HTTP client following [PSR-18 specification](https://www.php-fig.org/psr/psr-18/#error-handling) strictly: 
It expects HTTP client _does not throw exception_ when server returns valid HTTP response. Otherwise I cannot guarantee same exception handling behaviour as in core extension.

## Licensing

MIT license. Please see [License File](LICENSE) for more information.
