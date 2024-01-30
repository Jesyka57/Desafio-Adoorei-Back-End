# Desafio Adoorei

![GitHub repo size](https://img.shields.io/github/repo-size/iuricode/README-template?style=for-the-badge)
![GitHub language count](https://img.shields.io/github/languages/count/iuricode/README-template?style=for-the-badge)
![GitHub forks](https://img.shields.io/github/forks/iuricode/README-template?style=for-the-badge)
![Bitbucket open issues](https://img.shields.io/bitbucket/issues/iuricode/README-template?style=for-the-badge)
![Bitbucket open pull requests](https://img.shields.io/bitbucket/pr-raw/iuricode/README-template?style=for-the-badge)

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


### 🚀Swagger
Para rodar o swagger, é preciso seguir os passos a seguir:

1°Baixar as dependencias do swagger
```
composer require darkaonline/l5-swagger
composer require zircote/swagger-php
```

2°Adicionar o Provaider:
```
php artisan vendor:publish --provider “L5Swagger\L5SwaggerServiceProvider”
```

3° Se necessario, adicionar esse campo no .env:
```
L5_SWAGGER_GENERATE_ALWAYS=true
SWAGGER_VERSION=2.0
```

4° Após isso, rodar o ultimo codigo a serguir:
```
php artisan l5-swagger:generate
```

5° Será gerado um docs com a documentação:
```
http://localhost/api/documentation
```
## 💻 Testes Unitarios
Todos os testes unitarios estão com seus respectivos comandos para serem rodados.

## 📝 Licença

Esse projeto está sob licença. Veja o arquivo [LICENÇA](LICENSE.md) para mais detalhes.
