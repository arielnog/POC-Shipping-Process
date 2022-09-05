# POC - Shipping Process

A aplicação desenvolvida com intuito de processar e armazenar dados relacionados a frete recebidos através de upload
de arquivos `.csv`. Como em uma requisição HTTP típica, esse processo facilmente estouraria o tempo limite para a
execução, foi pensando em utilizar o conceito de Filas, para que os demais arquivos sejam processados e armazenados em
segundo plano.

## Recursos

Essa aplicação é uma API, que contém os seguintes recursos:

- Laravel 8
- MySQL

**Obs.** Aplicação desenvolvida e testada em plataformas Windows.

## Ambiente

- PHP 8.1.1
- Nginx latest (atualmente 1.18) / PHP-FPM
- MySQL 8.0.20
- Composer 2
- XDebug 3

### Pré-Requisitos

- Ter o docker habilitado localmente.

### Instalação

- Copiar o arquivo `./src/.env.example` que corresponde as variáveis de ambiente da aplicação e o salve
  como `./src/.env` .

- Executar o seguinte comando.

```bash
docker-compose up -d --build
```

- Entrar no container da aplicação(`app_php`), gere a key do projeto

```bash
php artisan key:generate
```

- Ainda no container citado acima, execute a migrations.

```bash
php artisan migrate
```

- Se quiser, existe uma seeder de Clientes, para usa-lá. (Executar no container)

```bash
php artisan db:seed
```

## Execução da aplicação

- Após seguir todas as etapas de instalação. É sugerido seguir as seguintes etapas descritas abaixo.
- Para executar os endpoints, é indicado seguir a documentação no link: [Documentação da API](https://documenter.getpostman.com/view/13762067/VUxYp3RR)
### Etapas

1. Passo:
   - Executar o seguinte comando dentro do container da aplicação(`app_php`):
```shell
 php artisan queue:work --timeout=0
```

2. Passo 
   - Criar Cliente utilizando o método `POST` e o endpoint `api/v1/client/save`.
   

3. Passo
   - Realizar upload utilizando o método `POST` e o endpoint `api/v1/file/save`
   
   
4. Passo
   - Após o processamento da fila, checar o banco de dados na tabela `shipping`.


## Adicionais


### Testes
- Para rodar os testes, executar o seguinte comando dentro do container da aplicação(`app_php`).

```shell
composer test
```

### Coverage
- Para gerar o coverage , executar o seguinte comando dentro do container da aplicação(`app_php`).

```shell
composer test-coverage-html
```
