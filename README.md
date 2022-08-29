
# Pacote Larabase
O pacote [Larabase](https://github.com/bcampti/larabase) fornece comandos para criação dos arquivos necessários para a implementação de recursos no sistema. Segue um padrão pré estabelecido para padronização do desenvomento.

## Instalação

Adicionar no composer.json o repositorio do pacote.
```bash
"repositories": [
    {
        "type": "vcs",
        "url":  "git@github.com:bcampti/larabase.git"
    }
]
```
Instala o pacote via composer:

```bash
composer require bcampti/larabase
```

Publica os migrations:

```bash
php artisan vendor:publish --tag="larabase-migrations"
php artisan migrate
```

Publica o arquivo de config:

```bash
php artisan vendor:publish --tag="larabase-config"
```

Este é o conteúdo do arquivo de configuração:

```php
return [
];
```

Publica os arquivos modelos 'stubs':

```bash
php artisan vendor:publish --tag="larabase-stubs"
```

Publica os arquivos de errors:

```bash
php artisan vendor:publish --tag="laravel-errors"
```

Opcionalmente, você pode publicar as views:

```bash
php artisan vendor:publish --tag="larabase-views"
```

## Instalação de dependencias e configurações adicionais

Executar o comando para instalar as dependencias do pacote.
```bash
php artisan larabase:install 
```
Serão instalados o pacote a seguir, após a instalação verifique as configuração e se necessários realize ajustes.
### 1. [Laravel Auditing](https://github.com/owen-it/laravel-auditing)

Verificar na [documentação](https://github.com/owen-it/laravel-auditing-doc/blob/main/documentation.md) em caso de duvidas.
### 2. [Laravel-multitenancy](https://github.com/spatie/laravel-multitenancy)
Incluir configuracao de connections no arquivo `config/database.php`, tenant para a base principal e landlord para a base de clientes.

Verificar na [documentação](https://spatie.be/docs/laravel-multitenancy/v2/introduction) em caso de duvidas.

```bash
'connections' => [
    'tenant' => [
        'driver' => 'mysql',
        ...
    ],

    'landlord' => [
        'driver' => 'mysql',
        ...
    ],
```


# Comandos artisan Larabase
```bash
php artisan larabase:make Locale/Pais
```
 > Imprime no console todos os commandos artisan para o model informado:
 ```bash
php artisan larabase:model Locale/Pais
php artisan make:factory Locale/PaisFactory  --model=Locale/Pais
php artisan make:migration create_pais_table --create=pais
php artisan larabase:filtro Locale/PaisFiltro --model=Locale/Pais
php artisan larabase:repository Locale/PaisManager --model=Locale/Pais
php artisan larabase:route Locale/Pais --model=Locale/Pais
php artisan larabase:controller Locale/PaisController --model=Locale/Pais
php artisan larabase:view listar --model=Locale/Pais
php artisan larabase:view formulario --model=Locale/Pais
php artisan larabase:request Locale/PaisRequest --model=Locale/Pais
php artisan larabase:test Locale/PaisControllerTest --model=Locale/Pais
php artisan larabase:test Locale/PaisTest --model=Locale/Pais --unit
```

```bash
php artisan larabase:all Locale/Pais
```
 > Este comando executará todos os comando do [Larabase](https://github.com/bcampti/larabase) para o model informado. [ Model, Factory, Migration, Filtro, Manager, Routes, Controller, FormRequest, Blades(listar, formulario) e Testes.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Leandro Viera Marcolin](https://github.com/bcampti)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
