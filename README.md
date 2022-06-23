# MantisBugCatcher
_Integração com a API do Mantis BUG Tracker_

[![Total Downloads](https://poser.pugx.org/devpaulopaixao/mantis-bugcatcher/downloads)](https://packagist.org/packages/devpaulopaixao/mantis-bugcatcher)
[![License](https://poser.pugx.org/devpaulopaixao/mantis-bugcatcher/license)](https://packagist.org/packages/devpaulopaixao/mantis-bugcatcher)

### Sobre o Mantis

MantisBT é um rastreador de problemas de código aberto que fornece um equilíbrio delicado entre simplicidade e poder. Os usuários podem começar em minutos e começar a gerenciar seus projetos enquanto colaboram com seus colegas de equipe e clientes de forma eficaz. Depois de começar a usar, você nunca mais vai voltar!

### Por que o Mantis?

Gratuito e de código aberto, o MantisBT é uma ferramenta de gestão de projetos e rastreamento de erros que dá às equipes de desenvolvimento a flexibilidade de personalizar tíquetes de problemas e processos de fluxo de trabalho.

## Requisitos

*  "guzzlehttp/guzzle": "^7.3"

## Instalação

Instale o [Composer](http://getcomposer.org) caso você não o tenha.
```
composer require devpaulopaixao/mantis-bugcatcher
```
Ou, em seu 'composer.json' adicione:

```json
{
    "require": {
        "devpaulopaixao/laravel-tools": "dev-main"
    }
}
```

Em seguida, execute o comando de instalação do gerenciador de pacotes:

    composer install

Depois, adicione a seguinte linha ao seu 'config/app.php' em 'providers':

    Devpaulopaixao\LaravelTools\LaravelToolsServiceProvider::class,

Com isso, o pacote está pronto para ser utilizado.

----------------------------------------------------------------------------------------------------------------------------

## Variáveis de ambiente

Adicione ao seu arquivo '.env' as variáveis de ambiente que possibilitarão a comunicação com o servidor onde está localizado o sistema de monitoramento do Mantis:

    MANTIS_URL="URL DO SERVIDOR"
    MANTIS_SECRET="CHAVE DE ACESSO AO MANTIS"
    MANTIS_PROJECT_ID="ID DO RESPECTIVO PROJETO"
    MANTIS_PROJECT_NAME="NOME DO RESPECTIVO PROJETO"
    MANTIS_TIMEOUT="LIMITE PARA EXPIRAR CONEXÃO COM O SERVIDOR(OPCIONAL)"

## Endpoints de API

1. [Create an issue minimal](https://documenter.getpostman.com/view/29959/mantis-bug-tracker-rest-api/7Lt6zkP#028dda86-2165-b74a-490b-7e0487eeb853):

   ```php
     MantisBugcatcher::createAnIssueMinimal($exception,[
        'summary'   => '',
        'description' => '',
        'category' => [
            'name' => ''
        ]
     ]);
   ```
    Esta função retorna um objeto com as seguintes propriedades em caso de sucesso ou erro:

    ```php
     return (object)[
                "status"   => 'success',
                "data"     => json_decode($response->getBody()->getContents())
            ];
   ```
    ```php
     return (object)[
                "status"   => 'error',
                "code"     => $response->getStatusCode() != null ? $response->getStatusCode() : 000,
                "message"  => $e->getMessage(),
            ];
   ```
2. [Create an issue](https://documenter.getpostman.com/view/29959/mantis-bug-tracker-rest-api/7Lt6zkP#a3f345e6-c4b6-1361-3b61-839f9205a954):

   ```php
     MantisBugcatcher::createAnIssue($exception,[
        'summary'   => '',
        'description' => '',
        'additional_information' => '',
        'category' => [
            'id' => ''
            'name' => ''
        ],
        'handler' => [
            'name' => ''
        ],
        'view_state' => [
            'id' => ''
            'name' => ''
        ],
        'priority' => [
            'name' => ''
        ],
        'severity' => [
            'name' => ''
        ],
        'reproducibility' => [
            'name' => ''
        ],
        'sticky' => '',
        'custom_fields' => [],
        'tags'=> [],
     ]);
   ```
    Esta função retorna um objeto com os mesmos parâmetros especificados no primeiro exemplo.

## Licença

MIT

<!-- markdownlint-enable -->
<!-- prettier-ignore-end -->
