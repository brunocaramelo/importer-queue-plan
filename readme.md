EXECUTAR ANTES DA APLICAÇÃO CLIENTE

Aplicação simples de CRUD de produtos, onde a criação dos itens apenas e feita a partir uploa
de uma planilha, que conta com uma fila de processamento , e uma rota onde e possivel verificar o estado de cada upload e seu historico
utilizando técnicas que podem ser utilizadas com CI/CD
para gerencimento de ambientes com o uso de:

    - DOCKER  com docker compose
    - NGINX
    - PHP
    - MYSQL
    - REDIS ( para queue driver)
    - SQLITE ( para Suite de testes / in memory )
    - LARAVEL FRAMEWORK

    A aplicação é separada pelos seguintes conteineres
    - mysql
    - redis
    - php / fpm
    - web / nginx

1- Baixar repositório 
    - git clone https://gitlab.com/bcaramelo/queue-test-plan.git

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

http://localhost:4001/api/

 Rotas:
 
 GET - v1/products/ (Listar Produtos)
 
 GET - v1/products/{id} (Detalhar Produtos
 
PUT - v1/products/{id} (Editar Produtos

POST - v1/upload/ (Importar Produtos, Enviar planilha no campo [file]  IMPORTANTE: o campo deve ser do tipo file , no PostMan no Header tirar opção Content-Type)

DELETE - v1/products/{id} (Excluir Produtos)

GET - v1/upload/check-proccess (Listar Processos)


Exemplo de Planilha de upload em example/example.xlsx

GET - v1/products/check-proccess/{id} (Detalhar Processo)

