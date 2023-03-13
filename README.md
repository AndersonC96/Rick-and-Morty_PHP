
# Rick and Morty Character Finder & Rating System

Este projeto utiliza a API do Rick and Morty para buscar e exibir informações sobre os personagens da série. Além disso, permite que os usuários avaliem os personagens e vejam suas avaliações.

## Tecnologias utilizadas

- PHP
- MySQL
- Ajax
- JavaScript
- jQuery
- HTML
- CSS
- API do [Rick and Morty](https://rickandmortyapi.com)

## Funcionalidades

### Busca de personagens

O usuário pode pesquisar por um personagem pelo nome ou por parte do nome. O sistema irá retornar uma lista de personagens correspondentes à pesquisa.

### Exibição de informações

Ao clicar em um personagem, o usuário poderá ver suas informações detalhadas, incluindo nome, espécie, gênero, status, imagem e lista de episódios em que aparece.

### Avaliação de personagens

O usuário pode avaliar um personagem de 1 a 5 estrelas. A avaliação é salva no banco de dados e a média das avaliações é exibida ao lado do nome do personagem na lista de resultados de pesquisa.

### Listagem de personagens

O sistema também permite a listagem de todos os personagens da série em ordem alfabética ou por ordem de avaliação.

## Como usar

1. Clone este repositório para o seu computador.
2. Crie um banco de dados MySQL e importe o arquivo `rickmortydb.sql`.
3. Abra o arquivo `class.php` e configure as informações de conexão com o banco de dados.
4. Abra o arquivo `index.php` em um navegador da web.
5. Pesquise por um personagem pelo nome ou parte do nome.
6. Clique em um personagem para ver suas informações detalhadas e avaliações.
7. Avalie um personagem clicando nas estrelas ao lado do nome dele.
8. Liste todos os personagens em ordem alfabética ou por ordem de avaliação.
