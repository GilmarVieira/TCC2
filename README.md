# CodeSmart – Assistente de IA para Desenvolvedores

Pequena aplicação web (PHP + JavaScript puro) que utiliza a API da OpenAI para **gerar código**, **detectar erros** e **recomendar melhorias** em trechos de programação.

## Pré‑requisitos
* PHP >= 8 (funciona no XAMPP, WampServer ou Apache + PHP nativos)
* Navegador moderno
* Chave da API OpenAI

## Instalação
1. Copie a pasta `codesmart_app/` para a raiz do seu servidor (por ex. `C:\xampp\htdocs\codesmart_app`).
2. Renomeie `config.php` e coloque sua chave:
   ```php
   define('OPENAI_API_KEY','chave_aqui');
   ```
3. Acesse `http://localhost/codesmart_app` no navegador.

Pronto!

## Licença
MIT
