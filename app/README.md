EXECUTAR ANTES DA APLICAÇÃO CLIENTE

1- Criação do Database (Mysql) executar DUMP de storage/database/create-database.sql

2 - Alterar parametros no .env para o Banco DB_CONNECTION=mysql DB_HOST=127.0.0.1 DB_PORT=3306 DB_DATABASE=stock_api DB_USERNAME=root DB_PASSWORD=testes

3 - RODAR migrations e seeds - executar na raiz - php artisan migrate - php artisan db:seed caso queira utilizar a API 

4 - Bateria de testes usando sqlite com o comando phpunit na raiz do projeto
    - Testes de API 
    - Testes Unitários

Rotas: 
    GET - v1/products/ (Listar Produtos)
    GET - v1/products/{id} (Detalhar Produtos)
    PUT - v1/products/{id} (Editar Produtos)
    POST - v1/upload/ (Importar Produtos, Enviar planilha no campo [file] ) 
    DELETE - v1/products/{id} (Excluir Produtos)
   
    GET - v1/upload/check-proccess (Listar Processos)
    GET - v1/products/check-proccess/{id} (Detalhar Processo)
    

DRIVER JOB utilizado: database

executar

php artisan migrate ;
php artisan db:seed ;
php artisan queue:listen