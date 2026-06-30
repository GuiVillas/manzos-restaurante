# Manzo's — Sistema de Gerenciamento para Restaurante

Sistema web completo para um restaurante de alta gastronomia chamado **Manzo's**. O projeto tem duas partes: um **site público** (onde qualquer pessoa pode ver o cardápio, conhecer o restaurante e fazer uma reserva) e um **painel administrativo** (onde a equipe do restaurante controla mesas, comandas, pagamentos, cardápio, clientes e relatórios).

Foi desenvolvido em **PHP**, **MySQL** e **JavaScript**, seguindo o padrão de arquitetura **MVC** (vamos explicar o que isso significa logo abaixo, sem complicação).

---

## Índice

1. [O que esse sistema faz](#-o-que-esse-sistema-faz)
2. [Tecnologias usadas](#-tecnologias-usadas)
3. [O que é o padrão MVC](#-o-que-é-o-padrão-mvc-e-por-que-usamos)
4. [Como o projeto está organizado](#-como-o-projeto-está-organizado)
5. [Como rodar o projeto na sua máquina](#-como-rodar-o-projeto-na-sua-máquina)
6. [Como o banco de dados funciona](#-como-o-banco-de-dados-funciona)
7. [Como funciona o login](#-como-funciona-o-login)
8. [Como funciona a pesquisa em tempo real (AJAX)](#-como-funciona-a-pesquisa-em-tempo-real-ajax)
9. [Principais funcionalidades do painel administrativo](#-principais-funcionalidades-do-painel-administrativo)
10. [Conceitos de segurança usados](#-conceitos-de-segurança-usados)
11. [Autores](#-autores)

---

## O que esse sistema faz

Um restaurante de verdade precisa controlar várias coisas ao mesmo tempo: quais mesas estão ocupadas, o que cada mesa pediu, quanto cada cliente vai pagar, quais pratos estão vendendo bem, quem são os fornecedores, etc. Fazer isso tudo no papel ou de cabeça é complicado e gera erro. Esse sistema resolve isso digitalizando toda a operação do restaurante.

**No site público (para os clientes):**
- Ver a história e os diferenciais do restaurante
- Ver o cardápio completo com preços e descrições
- Fazer uma reserva de mesa preenchendo um formulário
- Ver informações de contato e localização

**No painel administrativo (para a equipe):**
- Fazer login com usuário e senha
- Cadastrar e gerenciar clientes, mesas, usuários (funcionários) e fornecedores
- Abrir e fechar comandas (pedidos) das mesas
- Lançar os itens que cada mesa consumiu
- Registrar pagamentos
- Aplicar descontos em pratos
- Ver relatórios de faturamento, pratos mais vendidos, pratos menos vendidos e desempenho de cada garçom

---

## Tecnologias usadas

| Tecnologia | Para que serve aqui |
|---|---|
| **PHP** | Linguagem principal do back-end (regras de negócio, conexão com banco, geração das páginas) |
| **MySQL** | Banco de dados relacional onde tudo fica salvo (clientes, mesas, pedidos, etc.) |
| **PDO (PHP Data Objects)** | Biblioteca do PHP usada para conversar com o banco de dados de forma segura |
| **HTML5** | Estrutura das páginas |
| **JavaScript (puro, sem frameworks)** | Interatividade no navegador, como pesquisa em tempo real e atualização de tabelas sem recarregar a página |
| **Tailwind CSS** | Framework de estilização usado via CDN, para deixar o visual elegante sem escrever CSS do zero |
| **AJAX (com `fetch`)** | Técnica que permite o JavaScript conversar com o PHP sem recarregar a página inteira |

---

## O que é o padrão MVC e por que usamos

MVC significa **Model – View – Controller** (Modelo – Visão – Controlador). É uma forma de organizar o código separando responsabilidades, para que cada parte do sistema cuide de uma coisa só. Isso facilita muito encontrar e corrigir problemas, e também facilita trabalhar em grupo, porque cada pessoa pode mexer em uma camada sem bagunçar o resto.

```
   Usuário interage
         │
         ▼
  ┌─────────────┐      pede dados       ┌─────────────┐
  │    VIEW     │ ───────────────────▶ ­­­­­­­­│ CONTROLLER  │
  │ (o que você │                       │ (recebe o   │
  │   vê na     │ ◀──────────────────  │  pedido e   │
  │   tela)     │     responde JSON     │  decide o   │
  └─────────────┘                       │  que fazer) │
                                        └──────┬──────┘
                                               │ chama
                                               ▼
                                        ┌─────────────┐
                                        │    MODEL    │
                                        │ (conversa   │
                                        │  direto com │
                                        │  o banco de │
                                        │  dados)     │
                                        └─────────────┘
```

- **Model** (pasta `models/`): são classes PHP que sabem **conversar com o banco de dados**. Cada Model representa uma "coisa" do sistema, por exemplo, `Cliente.php` sabe como buscar, cadastrar, atualizar e excluir clientes no banco. O Model nunca lida com HTML, ele só lida com dados.

- **View** (pasta `views/`): são os arquivos que o usuário **realmente vê na tela**, o HTML misturado com um pouco de PHP e o JavaScript que faz a página se comportar de forma interativa.

- **Controller** (pasta `controllers/`): fica **no meio** do Model e da View. Ele recebe os pedidos que vêm do JavaScript (do tipo "cadastra esse cliente" ou "me devolve a lista de mesas"), chama o Model certo para resolver isso, e devolve a resposta em formato **JSON** para o JavaScript usar.

---

## Como o projeto está organizado

```
manzos/
├── index.php              → Página inicial do site público
├── menu.php                → Página do cardápio (site público)
├── sobre.php                → Página "Sobre o restaurante" (site público)
├── contato.php              → Página de contato (site público)
├── reserva.php              → Formulário de reserva de mesa (site público)
├── header.php / footer.php  → Cabeçalho e rodapé reaproveitados em todas as páginas públicas
│
├── config/
│   └── database.php         → Configuração e conexão com o banco MySQL (usa PDO)
│
├── database/
│   └── restaurante.sql      → Script SQL completo: cria todas as tabelas e popula com dados de exemplo
│
├── models/                  → Uma classe PHP para cada "entidade" do sistema
│   ├── Cliente.php
│   ├── Mesa.php
│   ├── Usuario.php
│   ├── prato.php
│   ├── Pedido.php
│   ├── Pagamento.php
│   ├── Reserva.php
│   ├── Fornecedor.php
│   └── Relatorio.php
│
├── controllers/              → Um controller para cada Model, fazendo a ponte com o JavaScript
│   ├── AuthController.php    → Login, logout e proteção de páginas
│   ├── ClienteController.php
│   ├── MesaController.php
│   ├── UsuarioController.php
│   ├── PratoController.php
│   ├── PedidoController.php
│   ├── PagamentoController.php
│   ├── ReservaController.php
│   ├── FornecedorController.php
│   └── RelatorioController.php
│
└── views/admin/               → Todas as telas do painel administrativo
    ├── login.php
    ├── dashboard.php
    ├── clientes.php
    ├── mesas.php
    ├── usuarios.php
    ├── cardapio.php
    ├── comandas.php
    ├── pagamentos.php
    ├── reservas.php
    ├── fornecedores.php
    ├── relatorios.php
    ├── admin_header.php       → Sidebar e topo, reaproveitados em todas as telas do admin
    └── admin_footer.php
```

---

## Como rodar o projeto na sua máquina

Este projeto foi desenvolvido utilizando **XAMPP**, que já inclui **Apache**, **PHP** e **MySQL** em um único pacote.

1. Baixe e instale o **XAMPP**, caso ainda não o tenha instalado.
2. Abra o **XAMPP Control Panel** e inicie os serviços **Apache** e **MySQL** (os indicadores devem ficar verdes).
3. Copie a pasta deste projeto para a pasta **`htdocs`** do XAMPP (geralmente localizada em `C:\xampp\htdocs`).
4. Abra o navegador e acesse `http://localhost/phpmyadmin`.
5. No phpMyAdmin, crie um novo banco de dados chamado **`manzos_restaurante`**.
6. Clique na aba **Importar**, selecione o arquivo `database/restaurante.sql` deste projeto e confirme a importação. Isso criará todas as tabelas e adicionará dados de exemplo (clientes, mesas, pratos, pedidos, etc.).
7. Acesse o projeto pelo navegador em `http://localhost/manzos-restaurante`.
8. Para acessar o painel administrativo, vá para `http://localhost/manzos-restaurante/views/admin/login.php` e entre com um dos usuários cadastrados no banco (exemplo: **[ricardo@manzos.com.br](mailto:ricardo@manzos.com.br)** / senha **123456**).

Caso ocorra algum erro de conexão com o banco de dados, o próprio sistema exibirá uma tela com orientações sobre o que verificar, como se o serviço **MySQL** está em execução, se o banco foi criado com o nome correto e se as configurações do arquivo `config/database.php` estão corretas.

---

## Como o banco de dados funciona

O banco tem **10 tabelas**, todas conectadas entre si através de **chaves estrangeiras** (foreign keys). Isso garante que, por exemplo, não seja possível criar um pedido para uma mesa que não existe, ou um pagamento para um pedido que não existe.

| Tabela | O que guarda |
|---|---|
| `cliente` | Pessoas que fazem reservas ou consomem no restaurante |
| `mesa` | Cada mesa do salão, com número, capacidade e status (Disponível, Ocupada, Reservada) |
| `usuario` | Funcionários do restaurante (gerente, chef, garçons, caixa) que fazem login no sistema |
| `categoria_prato` | As categorias do cardápio (Entradas, Carnes, Sobremesas, etc.) |
| `prato` | Cada item do cardápio, com nome, descrição, preço e um campo de desconto |
| `reserva` | Reservas de mesa feitas pelos clientes |
| `pedido` | Uma comanda aberta (ou já fechada) numa mesa |
| `prato_pedido` | Os itens que foram pedidos dentro de cada comanda (tabela "de ligação" entre `pedido` e `prato`) |
| `pagamento` | O pagamento referente a um pedido fechado |
| `fornecedor` | Empresas que fornecem ingredientes e insumos para o restaurante |

### Sobre o desconto nos pratos

Cada prato tem um campo chamado `desconto_multiplicador`. O valor padrão é `1.00` (sem desconto). Se um prato precisa de 20% de desconto, esse campo vira `0.80`. O **preço final** que o cliente paga é sempre calculado assim:

```
preço_final = preço_original × desconto_multiplicador
```

A vantagem dessa lógica é que o **preço original do prato nunca é apagado ou sobrescrito**, ele continua intacto na coluna `preco`. Isso faz com que voltar um prato ao preço normal seja simplesmente "resetar" o multiplicador de volta para `1.00`, sem perder nenhuma informação.

---

## Como funciona o login

O login usa **sessões PHP** (`$_SESSION`). Quando o usuário entra com e-mail e senha corretos, o sistema guarda o ID dele numa variável de sessão. A partir daí, toda página do painel administrativo chama uma função chamada `protegerPagina()`, que verifica se existe um usuário logado na sessão. Se não existir, a página redireciona automaticamente para a tela de login, assim ninguém entra no painel administrativo sem antes fazer login.

---

## Como funciona a pesquisa em tempo real (AJAX)

Em telas como Clientes, Mesas e Cardápio, dá para digitar numa caixa de busca e os resultados aparecem **na hora**, sem apertar nenhum botão e sem a página recarregar. Isso é feito com **AJAX**, usando a função `fetch()` do JavaScript.

O fluxo funciona assim:

1. O campo de texto tem o evento `oninput`, que dispara uma função JavaScript a **cada letra digitada**.
2. Essa função usa `fetch()` para mandar o termo digitado para um Controller PHP (por exemplo, `ClienteController.php?acao=pesquisar&termo=Maria`).
3. O Controller chama o Model, que faz uma consulta no banco usando `LIKE '%termo%'` (que busca qualquer registro que **contenha** aquele texto).
4. O Controller devolve os resultados em formato **JSON**.
5. O JavaScript recebe esse JSON e reescreve apenas a tabela na tela, sem recarregar a página inteira.

---

## Principais funcionalidades do painel administrativo

- **Dashboard**: visão geral rápida do restaurante.
- **Clientes**: cadastro completo com CPF, nome, e-mail e telefone, com busca em tempo real.
- **Mesas**: controle do status de cada mesa (Disponível, Ocupada, Reservada).
- **Usuários**: gerenciamento da equipe e seus cargos (inclui os garçons, que aqui são tratados como usuários do sistema, não uma tabela separada).
- **Cardápio**: cadastro, edição e exclusão de pratos, com categorias e controle de desconto.
- **Comandas**: abrir uma comanda para uma mesa (vinculando garçom e, opcionalmente, um cliente), lançar itens consumidos e fechar a conta, que automaticamente libera a mesa e direciona para o pagamento.
- **Pagamentos**: registro da forma de pagamento (PIX, Crédito, Débito, etc.) com preenchimento automático do valor total da comanda.
- **Reservas**: gerenciamento de reservas feitas pelo site, incluindo um botão para "receber" o cliente quando ele chega, que já direciona para abrir a comanda dele.
- **Fornecedores**: cadastro de empresas parceiras do restaurante.
- **Relatórios**: faturamento por período, pratos mais vendidos, pratos menos vendidos (com opção de aplicar desconto direto ali) e desempenho de vendas por garçom.

---

## Conceitos de segurança usados

- **Prepared Statements (consultas preparadas)**: todas as consultas SQL usam `?` no lugar dos valores e passam os dados separadamente através do PDO. Isso impede um ataque chamado **SQL Injection**, onde alguém tentaria digitar comandos SQL maliciosos dentro de um campo de formulário para manipular o banco de dados.
- **Sessões protegidas**: nenhuma página do painel administrativo pode ser acessada sem login.
- **Padrão PRG (Post-Redirect-Get)**: depois que um formulário público (como o de reserva) é enviado com sucesso, o sistema redireciona o navegador para uma nova página em vez de simplesmente mostrar a confirmação. Isso evita que, se o cliente recarregar a página (F5), o formulário seja enviado de novo e crie registros duplicados no banco.
- **Validação e filtro de dados**: o PHP usa funções como `filter_input()` e `htmlspecialchars()` para limpar e validar o que o usuário digita antes de salvar ou exibir.

---

## Autores

Projeto desenvolvido em grupo para a disciplina de Desenvolvimento Web.

| Nome | Parte do sistema |
|---|---|
| Andriy Gabriel  | Controllers |
| Cauã Rosa | Views - private |
| Guilherme Brandão | Database |
| Guilherme Braz | Models |
| Thiago Aguiar | Views - public |

---

Manzo's — Restaurante de Alta Gastronomia</p>

Vídeo no Drive: https://drive.google.com/file/d/1fB3OakJanbbzT3SS_ftDBt8SaKnMpIlS/view?usp=drivesdk
Vídeo no Youtube: https://www.youtube.com/watch?v=SiX34wvnhD8

