<?php  ?>

<div class="container" style="padding:40px 20px;">
    <h1><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 1-6.23-.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/></svg> Demonstração dos Conceitos PHP</h1>
    <p class="text-muted">Esta página demonstra todos os conceitos de PHP utilizados no projeto.</p>

    <div class="demo-section">
        <h2>1. Variáveis</h2>
        <?php
        $nome    = "EletroTech";
        $versao  = 1.0;
        $ativo   = true;
        $nulo    = null;
        ?>
        <pre><code><?php
        echo "\$nome   = \"$nome\";\n";
        echo "\$versao = $versao;\n";
        echo "\$ativo  = " . ($ativo ? 'true' : 'false') . ";\n";
        echo "\$nulo   = " . var_export($nulo, true) . ";\n";
        ?></code></pre>
    </div>

    <div class="demo-section">
        <h2>2. Arrays</h2>
        <?php
        $produtos = ['Notebook', 'Smartphone', 'Tablet', 'Fone de Ouvido'];

        $produto = [
            'nome'   => 'Notebook Gamer',
            'preco'  => 2999.99,
            'marca'  => 'TechBrand',
            'estoque' => 15,
        ];

        $catalogo = [
            ['nome' => 'iPhone 15',    'preco' => 5999.00],
            ['nome' => 'Galaxy S24',   'preco' => 4499.00],
            ['nome' => 'Pixel 8',      'preco' => 3799.00],
        ];
        ?>
        <pre><code>Array indexado: <?= implode(', ', $produtos) ?>

<?php foreach ($produto as $chave => $valor): ?>  <?= $chave ?>: <?= var_export($valor, true) ?>

<?php endforeach; ?>
Array multidimensional (<?= count($catalogo) ?> itens)</code></pre>
    </div>

    <div class="demo-section">
        <h2>3. var_dump</h2>
        <pre><code><?php ob_start(); var_dump($produto); $dump = ob_get_clean(); echo htmlspecialchars($dump); ?></code></pre>
    </div>

    <div class="demo-section">
        <h2>4. if / else</h2>
        <?php
        $estoque = 5;
        if ($estoque === 0) {
            $status = "Sem estoque";
        } elseif ($estoque <= 5) {
            $status = "Estoque baixo";
        } else {
            $status = "Em estoque";
        }
        echo "<p>Estoque: <strong>$estoque</strong> → Status: <strong>$status</strong></p>";
        ?>
    </div>

    <div class="demo-section">
        <h2>5. switch</h2>
        <?php
        $role = 'admin';
        switch ($role) {
            case 'admin':
                $label = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><circle cx="12" cy="12" r="5"/></svg> Administrador';
                break;
            case 'cliente':
                $label = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><circle cx="12" cy="12" r="5"/></svg> Cliente';
                break;
            default:
                $label = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><circle cx="12" cy="12" r="5"/></svg> Desconhecido';
        }
        echo "<p>Role: <strong>$role</strong> → <strong>$label</strong></p>";
        ?>
    </div>

    <div class="demo-section">
        <h2>6. for</h2>
        <p>Tabuada do 3:</p>
        <ul>
        <?php
        for ($i = 1; $i <= 10; $i++) {
            echo "<li>3 × $i = " . (3 * $i) . "</li>";
        }
        ?>
        </ul>
    </div>

    <div class="demo-section">
        <h2>7. foreach</h2>
        <ul>
        <?php
        foreach ($catalogo as $index => $item) {
            echo "<li>#{$index}: {$item['nome']} — R$ " . number_format($item['preco'], 2, ',', '.') . "</li>";
        }
        ?>
        </ul>
    </div>

    <div class="demo-section">
        <h2>8. while</h2>
        <?php
        $contador = 1;
        $numeros  = [];
        while ($contador <= 5) {
            $numeros[] = $contador * $contador;
            $contador++;
        }
        echo "<p>Quadrados de 1 a 5: " . implode(', ', $numeros) . "</p>";
        ?>
    </div>

    <div class="demo-section">
        <h2>9. Funções com Parâmetros, Tipadas e com Retorno</h2>
        <?php
        function calcularDesconto(float $preco, float $percentual): float
        {
            return $preco - ($preco * $percentual / 100);
        }

        function formatarMoeda(float $valor, string $simbolo = 'R$'): string
        {
            return $simbolo . ' ' . number_format($valor, 2, ',', '.');
        }

        function validarCpfFormato(string $cpf): bool
        {
            $cpf = preg_replace('/\D/', '', $cpf);
            return strlen($cpf) === 11;
        }

        $precoOriginal   = 1299.90;
        $precoDesconto   = calcularDesconto($precoOriginal, 15);
        $cpfValido       = validarCpfFormato('123.456.789-09');
        ?>
        <ul>
            <li>calcularDesconto(<?= $precoOriginal ?>, 15%) = <strong><?= formatarMoeda($precoDesconto) ?></strong></li>
            <li>formatarMoeda(<?= $precoOriginal ?>) = <strong><?= formatarMoeda($precoOriginal) ?></strong></li>
            <li>validarCpfFormato('123.456.789-09') = <strong><?= $cpfValido ? 'true' : 'false' ?></strong></li>
        </ul>
    </div>

    <div class="demo-section">
        <h2>10. include / require</h2>
        <pre><code>require ROOT_PATH . '/config/config.php';    
require ROOT_PATH . '/config/database.php';
include ROOT_PATH . '/views/layouts/header.php';
</code></pre>
        <p>Este projeto utiliza <code>require</code> para arquivos essenciais (config, database) e <code>include</code> para views.</p>
    </div>

    <div class="demo-section">
        <h2>11. Sessões</h2>
        <?php
        $_SESSION['demo_visitou'] = true;
        $_SESSION['demo_contador'] = ($_SESSION['demo_contador'] ?? 0) + 1;
        ?>
        <p>session_name(): <strong><?= session_name() ?></strong></p>
        <p>session_id(): <strong><?= session_id() ?></strong></p>
        <p>Você visitou esta demo <strong><?= $_SESSION['demo_contador'] ?></strong> vez(es) nesta sessão.</p>
        <p>Usuário logado: <strong><?= !empty($_SESSION['usuario_id']) ? 'Sim (#' . $_SESSION['usuario_id'] . ')' : 'Não' ?></strong></p>
    </div>

    <div class="demo-section">
        <h2>12. Cookies</h2>
        <?php
        if (!isset($_COOKIE['demo_cookie'])) {
            setcookie('demo_cookie', 'eletrotech_' . date('YmdHis'), time() + 300, '/');
            $cookieMsg = 'Cookie acabou de ser criado (recarregue para ver o valor).';
        } else {
            $cookieMsg = 'Valor: ' . htmlspecialchars($_COOKIE['demo_cookie']);
        }
        ?>
        <p>Cookie "demo_cookie": <strong><?= $cookieMsg ?></strong></p>
        <p>Cookie remember-me: <strong><?= isset($_COOKIE[COOKIE_NAME]) ? 'Definido' : 'Não definido' ?></strong></p>
    </div>

    <div class="demo-section">
        <h2>13. Classes, Herança e Encapsulamento</h2>
        <pre><code>
class Model {
    protected PDO $db;       
    private static $instance; 
    public function findAll() {...} 
}

class Product extends Model {
    protected string $table = 'produtos'; 
    public function findFeatured() {...} 
}

/
// BaseController  ← AuthController, HomeController, ProductController...
// Model           ← User, Product, Category, Order, Cart
        </code></pre>
    </div>

    
    <div class="demo-section">
        <h2>14. PDO e Proteção contra SQL Injection</h2>
        <pre><code>
// <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg> ERRADO (vulnerável a SQL Injection):
// $sql = "SELECT * FROM produtos WHERE id = " . $_GET['id'];

// <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg> CORRETO com PDO (proteção automática):
$sql  = "SELECT * FROM produtos WHERE id = :id";
$stmt = $this->db->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT); 
$stmt->execute();
$produto = $stmt->fetch();
        </code></pre>
    </div>

</div>

<style>
.demo-section { background: var(--card-bg); border: 1px solid var(--border); border-radius: 8px; padding: 20px; margin-bottom: 20px; }
.demo-section h2 { color: var(--primary); margin-bottom: 12px; font-size: 1.1rem; }
pre code { background: #1e1e1e; color: #d4d4d4; display: block; padding: 16px; border-radius: 6px; overflow-x: auto; font-size: 0.85rem; line-height: 1.5; }
</style>
