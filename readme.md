# TDD com Laravel na prática

### Pré-requisitos

Para rodar a aplicação, você precisa ter instalado na sua máquina o [Docker](https://www.docker.com/), com versão igual ou superior a essas:

-   Docker: version 18.03.1-ce
-   Docker compose: version 1.21.2

Além de que as portas **8980** e **3336** não deverão está em uso no momento que os containeires forem ligados.

## Iniciando o projeto

```
cd example-tests-in-laravel
sh ./docker-run.sh
```

Pronto! O projeto já deve está funcionando no [http://localhost:8980/](http://localhost:8080/).

O usupasswordário padrão:

```
email: admin@fortics.com.br
senha: password
```

## Roteiro

1. Um usuário pode ler todas as tarefa;

2. Um usuário pode ler uma única tarefa;

3. Um usuário autenticado pode criar uma nova tarefa;

4. Um usuário autorizado pode atualizar uma tarefa;

5. Um usuário autorizado pode excluir a tarefa;