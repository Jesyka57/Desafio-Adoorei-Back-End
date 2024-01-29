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
- [ ] Tarefa 4
- [ ] Tarefa 5

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

Depois faça suba a aplicação no docker:
```
docker-compose down
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
Windows:

```
<comando_de_instalação>
```

## ☕ Usando <nome_do_projeto>

Para usar <nome_do_projeto>, siga estas etapas:

```
<exemplo_de_uso>
```

Adicione comandos de execução e exemplos que você acha que os usuários acharão úteis. Fornece uma referência de opções para pontos de bônus!

## 📫 Contribuindo para <nome_do_projeto>

Para contribuir com <nome_do_projeto>, siga estas etapas:

1. Bifurque este repositório.
2. Crie um branch: `git checkout -b <nome_branch>`.
3. Faça suas alterações e confirme-as: `git commit -m '<mensagem_commit>'`
4. Envie para o branch original: `git push origin <nome_do_projeto> / <local>`
5. Crie a solicitação de pull.

Como alternativa, consulte a documentação do GitHub em [como criar uma solicitação pull](https://help.github.com/en/github/collaborating-with-issues-and-pull-requests/creating-a-pull-request).


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
