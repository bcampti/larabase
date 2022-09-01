
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
Executar o comando abaixo para instalar as dependencias do pacote.
```bash
php artisan larabase:install 
```

Os pacote abaixo serão instalado e pré configurados.
### 1. [pt-br-validator: Validações brasileiras para Laravel.](https://github.com/LaravelLegends/pt-br-validator)
Esta biblioteca adiciona validações brasileira ao Laravel, para serem utilizadas nos `FormRequest`, `Rules` como CPF, CNPJ, Placa de Carro, CEP, Telefone, Celular e afins.

### 2. [Laravel Auditing](https://github.com/owen-it/laravel-auditing)
Verificar na [documentação](https://github.com/owen-it/laravel-auditing-doc/blob/main/documentation.md) em caso de duvidas.

### 3. [Laravel-multitenancy](https://github.com/spatie/laravel-multitenancy)
As configurações padrão para o funcionamento do pacote serão adicionadas:
* `config/database.php`, connections `landlord` para o schema principal e `tenant` para o schema de clientes.
* `config/multitenancy.php`, `'tenant_database_connection_name' => 'tenant', 'landlord_database_connection_name' => 'landlord',`.

> Verificar a necessidade de criar o `schema` padrão com o nome `default_app`. Este `schema` será o utilizado para autenticação dos usuários e liberação de acesso a base correta de cadas cliente.

Executar migração de banco de dados padrão. Este comando executará a migração para a base padrão do sistema.
```bash
php artisan migrate
```
ou
```bash
php artisan migrate:app
```

### 4. [Laravel-pt-BR-localization](https://github.com/lucascudo/laravel-pt-BR-localization)
Módulo de linguagem pt-BR (português brasileiro) para Laravel, adiciona arquivos de trandução para Portugues do Brasil.
> Este pacote deve ser instalado separadamente devido a possíveis conflitos nas traduções.



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
