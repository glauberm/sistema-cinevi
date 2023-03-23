# Sistema do Departamento de Cinema e Vídeo da UFF

## Rodando o projeto localmente

1. Crie um novo arquivo `.env`:

```
cp .env.example .env
```

2. Edite as variáveis de ambiente do banco de dados e do servidor de e-mail.

3. Instale as dependências:

```
composer install && npm install
```

4. Gere a chave da aplicação:

```
php artisan key:generate
```

5. Compile e responda à mudanças aos arquivos configurados no webpack:

```
npm run watch
```

6. Processe novos trabalhos adicionados à fila:

```
php artisan queue:work
```

7. Execute o servidor de desenvolvimento:

```sh
php artisan serve
```
