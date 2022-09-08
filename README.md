# Sistema do Departamento de Cinema e Vídeo da UFF

## Rodando o projeto localmente

1. Instale as dependências:

```sh
composer install && npm install
```

2. Crie um novo arquivo `.env`:

```sh
cp .env.example .env
```

3. Adicione as configurações do banco de dados e do servidor de e-mail.

4. Gere a chave da aplicação:

```sh
php artisan key:generate
```

5. Compile e responda à mudanças aos arquivos configurados no webpack:

```sh
npm run watch
```

6. Processe novos trabalhos adicionados à fila:

```sh
php artisan queue:work
```

7. Execute o servidor de desenvolvimento:

```sh
php artisan serve
```
