<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>CodeSmart - Assistente de IA</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f2f5;
      margin: 0;
      padding: 2rem;
      display: flex;
      justify-content: center;
    }
    .container {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 800px;
    }
    h1 {
      color: #176cb4;
      font-size: 1.8rem;
      margin-bottom: 1rem;
    }
    p {
      margin-bottom: 1.5rem;
      color: #333;
    }
    textarea {
      width: 100%;
      height: 200px;
      padding: 1rem;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 1rem;
      margin-bottom: 1rem;
      resize: vertical;
    }
    label, select {
      font-size: 1rem;
      margin-top: 1rem;
    }
    select {
      padding: 0.5rem;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button {
      background-color: #ec6a0b;
      color: white;
      border: none;
      padding: 0.8rem 1.5rem;
      font-size: 1rem;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 1rem;
    }
    button:hover {
      background-color: #d25d09;
    }
    #output {
      white-space: pre-wrap;
      margin-top: 2rem;
      background: #f9f9f9;
      padding: 1rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      color: #333;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>CodeSmart – Assistente de IA</h1>
    <p>Escolha a ação desejada, cole ou digite seu código/descrição abaixo e clique em <strong>Enviar</strong>.</p>
    <form id="codeForm">
      <textarea id="codeInput" placeholder="Cole aqui seu código ou descreva o que precisa…"></textarea><br/>
      <label for="action">Ação:</label>
      <select id="action">
        <option value="generate">Gerar código</option>
        <option value="debug">Detectar erros</option>
        <option value="improve">Recomendar melhorias</option>
      </select><br/>
      <button type="submit">Enviar</button>
    </form>
    <pre id="output"></pre>
  </div>
<script>
document.getElementById('codeForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  const code = document.getElementById('codeInput').value;
  const action = document.getElementById('action').value;
  try {
    const response = await fetch('api.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ prompt: code, action: action })
    });
    const result = await response.json();
    const out = document.getElementById('output');
    if (result.response) {
      out.textContent = result.response;
    } else if (result.error) {
      out.textContent = "Erro da API: " + result.error;
      if (result.raw) {
        out.textContent += "\n\nRaw:\n" + JSON.stringify(result.raw, null, 2);
      }
    } else {
      out.textContent = "Nenhuma resposta.";
    }
  } catch (error) {
    document.getElementById('output').textContent = "Erro ao conectar com a API.";
  }
});
</script>
</body>
</html>