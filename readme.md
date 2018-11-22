EXECUTAR ANTES DA APLICAÇÃO CLIENTE

Aplicação simples de CRUD de usuários utilizando técnicas que podem ser utilizadas com CI/CD
para gerencimento de ambientes com o uso de:

    - DOCKER  com docker compose
    - NGINX
    - PHP
    - MYSQL
    - REDIS
    - SQLITE ( para Suite de testes / in memory )
    - LARAVEL FRAMEWORK

    A aplicação é separada pelos seguintes conteineres
    - mysql
    - redis
    - php / fpm
    - web / nginx

1- Baixar repositório 
    - git clone https://github.com/brunocaramelo/employee-test-case.git

2 - VERIFICAR  SE AS PORTAS 4001 E 3306 ESTÃO OCUPADAS,


3 - ENTRAR NO DIRETORIO BASE DA APLICACAO RODAR OS COMANDOS 
    
    1 - sudo docker-compose up -d;

    2 - sudo docker exec -t php-queue /var/www/html/artisan migrate;

    3 - sudo docker exec -t php-queue /var/www/html/artisan db:seed;

    4 - sudo docker exec -t php-queue phpunit;

    1 -  para que as imagens sejam armazenandas e executadas e subir as instancias
    
    2 -  para que o framework gere e aplique o mapeamento para a base de dados (SQL) podendo ser Mysql, PostGres , Oracle , SQL Serve ou SQLITE por exemplo
    
    3 -  para que o framework  aplique mudanças nos dados da base, no caso inserção de um primeiro usuário.
    
    4 - para que o framework execute a suite de testes.
        - testes de API  
        - testes de unidade
     
O mesmo pode ser rodado em uma unica vez com o comando:

        sudo docker-compose up -d; sudo docker exec -t php-queue /var/www/html/artisan migrate; sudo docker exec -t php-queue /var/www/html/artisan db:seed; sudo docker exec -t php-queue phpunit;

APOS RODAR A aplicação estara disponivel em 

http://localhost:4001/api/v1/employees/


Rotas: 
GET - api/v1/reports/employees/ (Listar Relatorio de Funcionarios) 

GET - api/v1/employees/ (Listar Funcionarios) 

GET - api/v1/employee/{id} (Detalhar Funcionario) 

PUT - api/v1/employee/{id} (Editar Funcionario) 

POST - api/v1/employee/ (Criar Funcionario ) 

DELETE - api/v1/employee/{id} (Excluir Funcionario)

