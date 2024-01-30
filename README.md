<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

> Olá, O projeto a seguir faz parte de um desafio da Adoorei, onde programei utilizando a framework laravel juntamente com  o sail e fazendo a integração com o Docker, utitlizando para implementação do banco MySql. Para fazer os testes, utilizei o Postman para verificar as requisições e os retornos. A documentação, tomei a liberdade de adicionar o swagger como uma ferramenta poderosa para documentação.

### Ajustes e melhorias

O projeto ainda está em desenvolvimento e as próximas atualizações serão voltadas nas seguintes tarefas:

- [x] Tarefa 1
- [x] Tarefa 2
- [x] Tarefa 3
- [X] Tarefa 4
- [X] Tarefa 5

## 💻 Pré-requisitos

Antes de começar, verifique se você atendeu aos seguintes requisitos:

- Se você tem instalado o  ```php 8.1^``` e o ```laravel 4.5.1```.
- Você tem uma máquina ``<Windows / Linux>``.
- Você leu `<Readme_Projeto.md>`.

## 🚀 Instalando <Portifolio-docker-laravel-mysql>

Para instalar o <Portifolio-docker-laravel-mysql>, siga estas etapas:

Linux:

Instale o laravel sail:
```
php artisan sail:install
```

Já dentro da aplicação, Instale o composer:
```
composer install --no-autoloader
```

Instale o laravel sail pelo composer:
```
composer require laravel/sail --dev
```
```
php artisan sail:install
```
```
php artisan sail up
```
Após fazer esses passos e sem erros, rode a aplicação:
```
docker run -p 8080:80 -p 5173:73 -e LARAVEL_SAIL=1 -v $(pwd):/var/www/html --name docker-example sail-8.1/app
```
```
./vendor/bin/sail up
```
Após isso, a aplicação já estará rodando normalmente e será possivel ver via promt mesmo.

Windows:

```
A diferença entre o linux e o windows é que a necessidade de instalar o WSL para que o laravel sail funcione
tanto que eu programei na SO Windows atraves do WSL, recomendo <https://learn.microsoft.com/en-us/windows/wsl/install>
e após a intalação seguir os passos desde o inicio do Linux.
```
## ⚠️ Utilizar o .env
É necessario configurar o .env para a utilização da Api e das migrations e Seeds:

.env para as Migrations/Seeds/Testes Unitarios:
```
#Seed/Migrations/Testes Unitarios
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=docker_example
DB_USERNAME=sail
DB_PASSWORD=password
```

.env para a utilização da Api:
```
#API
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=docker_example
DB_USERNAME=sail
DB_PASSWORD=password
```

## ☕ Usando <Portifolio-docker-laravel-mysql>

Para usar <Portifolio-docker-laravel-mysql>, siga estas etapas:

```
git clone https://github.com/Jesyka57/Portifolio-docker-laravel-mysql.git
```

Depois seguir os passos da instalação. Qualquer duvida, ler `<Readme_Projeto.md>` e tambem estou a disposição para qualquer duvida 😄.


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
