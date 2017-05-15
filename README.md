# SkyHub PHP SDK

## Autenticando a SDK

``` php
include 'vendor/autoload.php';
use Skyhub\Marketplace;
$skyhub = new Skyhub\Marketplace();
$skyhub->setAuth('<user_skyhub>', '<api_key>');
```

## Produtos

### Adicionando um produto

``` php
$produto = $skyhub->products()->insert([
    'sku'=>'72350973',
    'name'=>'Teste de produto',
    'description'=>'Produto de teste da API'
]);
```

### Consultando a lista de produtos

``` php
$produtos = $skyhub->products()->get(1, 10);
```

[Referência de produtos](https://github.com/bbarreto/skyhub-php-sdk/wiki/Produtos/)