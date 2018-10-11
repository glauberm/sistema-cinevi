# Sistema do Departamento de Cinema e Vídeo da Universidade Federal Fluminense

O sistema é uma aplicação Symfony (3.4) monolítica. O front-end usa jQuery (3.3.1) e Bootstrap (3.3.7).

## Instalando

Clone o projeto e então instale as dependências com o seguinte comando:

```[bash]
composer install -vvv && npm install
```

Depois, crie um usuário administrador:

```[bash]
php bin/console fos:user:create --super-admin
```

E então gere as configurações padrão:

```[bash]
php bin/console generate:config
```

## Rodando o servidor de desenvolvimento

Para rodar o servidor de desenvolvimento utilize o seguinte comando na raiz do projeto:

```[bash]
php bin/console server:run
```

E então visite o endereço `http://localhost:8000/app_dev.php` no seu navegador.

## Rodando os testes

Para rodar os testes, execute o comando:

```[bash]
./vendor/bin/simple-phpunit
```