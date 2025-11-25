<?php
session_start();
include 'bd/conexao.php';
$conn = conexao::getInstance();

// ID do usuário logado (ajuste se sua variável for diferente)
$usu_codigo = $_SESSION['usu_codigo'] ?? 1; // só pra exemplo

// 🪙 Consulta saldo de créditos
$sql_creditos = "SELECT saldo FROM creditos WHERE usu_codigo = :usu_codigo";
$stmt_creditos = $conn->prepare($sql_creditos);
$stmt_creditos->bindParam(':usu_codigo', $usu_codigo);
$stmt_creditos->execute();
$creditos = $stmt_creditos->fetch(PDO::FETCH_ASSOC)['saldo'] ?? 0;

// 🎟️ Consulta dos passes
$sql = "SELECT * FROM passes ORDER BY id DESC";
$resultado = $conn->query($sql);

if ($resultado === false) {
  die('Erro na consulta SQL: ' . $conn->errorInfo()[2]);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Loja - VoidRealms</title>
  <style>
    body {
      background: url('images/bgblur.png') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 20px;
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
      0% { transform: rotateY(0deg); }
      100% { transform: rotateY(360deg); }
    }

    .grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .card {
      width: 240px;
      background: #1e1e2f;
      border-radius: 15px;
      padding: 15px;
      color: white;
      box-shadow: 0 0 10px #111;
      overflow: hidden;
      cursor: pointer;
      text-decoration: none;
    }

    .card img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 10px;
    }

    .card h2 {
      font-size: 1.2em;
      margin-bottom: 5px;
      text-align: left;
    }

    .card p {
      font-size: 1em;
      margin: 3px 0;
      text-align: left;
    }

    .card:hover {
      transform: scale(1.07);
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

    /* 💠 Caixa de créditos */
    .creditos {
      position: fixed;
      top: 20px;
      right: 30px;
      background: rgba(30, 30, 47, 0.85);
      padding: 10px 20px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      text-decoration: none;
      color: #d4f0ff;
      box-shadow: 0 0 10px #000;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .creditos:hover {
      transform: scale(1.05);
      box-shadow: 0 0 12px #8a2be2;
    }

    .creditos img {
      width: 28px;
      height: 28px;
      animation: girar 6s linear infinite;
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

  <!-- 💠 Meus Créditos -->
  <a href="comprarcredito.php" class="creditos">
    <img src="images/dimamante.png" alt="Diamante">
    <strong>Meus Créditos:</strong> <?= number_format($creditos, 2, ',', '.') ?>
  </a>

  <h1><img src="images/dimamante.png" alt="Diamante"> Loja - Passes Cósmicos</h1>

  <div class="grid">
    <?php if ($resultado->rowCount() > 0): ?>
      <?php while ($row = $resultado->fetch(PDO::FETCH_ASSOC)): ?>
        <a href="passdetalhe.php?id=<?= $row['id'] ?>" class="card">
          <?php if (!empty($row['imagem'])): ?>
            <img src="<?= htmlspecialchars($row['imagem']) ?>" alt="Imagem do Passe">
          <?php endif; ?>
          <h2><?= htmlspecialchars($row['nome']) ?></h2>
          <p><?= htmlspecialchars($row['descricao']) ?></p>
          <p><strong><?= htmlspecialchars($row['preco']) ?> créditos</strong></p>
        </a>
      <?php endwhile; ?>
    <?php else: ?>
      <p>Nenhum produto encontrado.</p>
    <?php endif; ?>
  </div>

  <footer>
    <p>&copy; <?= date("Y") ?> Equipe NightFall </p>
  </footer>
</body>
</html>
