<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Comprar Créditos - VoidRealms</title>
  <style>
    body {
      background: url('images/bgblur.png') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 40px;
      color: white;
      text-align: center;
      background-color: black;
    }

    h1 {
      font-size: 2.5em;
      color: #d4f0ff;
      margin-bottom: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
    }

    h1 img {
      width: 40px;
      height: 40px;
      animation: girar 6s linear infinite;
    }

    @keyframes girar {
      0% {
        transform: rotateY(0deg);
      }
      100% {
        transform: rotateY(360deg);
      }
    }

    .form-box {
      background: rgba(30, 30, 47, 0.9);
      padding: 30px;
      border-radius: 15px;
      display: inline-block;
      box-shadow: 0 0 15px #000;
      margin-top: 40px;
    }

    label {
      font-size: 1.1em;
      color: #b0cfff;
    }

    select {
      margin: 10px 0;
      padding: 10px;
      border-radius: 8px;
      border: none;
      width: 80%;
      font-size: 1em;
      background: #141428;
      color: #fff;
      box-shadow: 0 0 8px rgba(138, 43, 226, 0.3);
    }

    button {
      margin-top: 20px;
      padding: 10px 25px;
      border: none;
      border-radius: 8px;
      background: linear-gradient(90deg, #1e90ff, #8a2be2);
      color: white;
      cursor: pointer;
      font-size: 1.1em;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    button:hover {
      transform: scale(1.05);
      box-shadow: 0 0 12px #8a2be2;
    }

    .voltar {
      position: fixed;
      top: 20px;
      left: 20px;
      font-size: 2em;
      color: white;
      text-decoration: none;
      background: transparent;
      border: none;
      cursor: pointer;
      z-index: 1000;
      transition: transform 0.2s;
    }

    .voltar:hover {
      transform: scale(1.2);
    }

    footer {
      background-color: #0a0a0f;
      color: #aaa;
      text-align: center;
      padding: 15px 0;
      width: 98%;
      font-size: 0.9rem;
      border-top: 1px solid rgba(138, 43, 226, 0.2);
      position: absolute;
      bottom: 0;
    }
  </style>
</head>

<body>
  <a href="index.php" class="voltar">&#8592;</a>

  <h1>
    <img src="images/dimamante.png" alt="Diamante"> Comprar Créditos
  </h1>

  <div class="form-box">
    <form action="actioncomprarcreditos.php" method="post">
      <label for="valor">Selecione o valor:</label><br>
      <select id="valor" name="valor" required>
        <option value="">Escolha um valor</option>
        <option value="10">10 Créditos - R$5,00</option>
        <option value="25">25 Créditos - R$10,00</option>
        <option value="50">50 Créditos - R$18,00</option>
        <option value="100">100 Créditos - R$30,00</option>
      </select><br>
      <button type="submit">Confirmar Compra</button>
    </form>
  </div>

  <footer>
    <p>&copy; <?= date("Y") ?> Equipe NightFall </p>
  </footer>
</body>
</html>
