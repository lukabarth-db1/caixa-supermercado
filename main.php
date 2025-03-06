<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Produtos\Categoria;
use App\CarrinhoDeCompras\CarrinhoDeCompras;
use App\Caixa\Caixa;
use App\Caixa\ProcessaPagamento;
use App\Pagamentos\Pagamento;
use App\Produtos\Produto;

// Criando categorias
$categoriaAlimento = new Categoria("Alimento");
$categoriaBebida = new Categoria("Bebida");
$categoriaHigiene = new Categoria("Higiene");
$categoriaImportado = new Categoria("Importado");

// Criando produtos
$chocolateLindt = new Produto(1, "Chocolate Lindt", $categoriaImportado, 15.89);
$carneBovina = new Produto(2, "Alcatra", $categoriaAlimento, 42.49);
$laranja = new Produto(3, "Laranja", $categoriaAlimento, 10.99);
$bolachaTrakinas = new Produto(4, "Bolacha recheada", $categoriaAlimento, 4.79);
$cafe = new Produto(5, "Café 3 corações", $categoriaBebida, 21.89);
$barraMilka = new Produto(6, "Barra de chocolate Milka", $categoriaImportado, 25.50);

// Criando o carrinho de compras
$carrinho = new CarrinhoDeCompras();
$carrinho->adicionarProduto($chocolateLindt);
$carrinho->adicionarProduto($carneBovina);
$carrinho->adicionarProduto($laranja);
$carrinho->adicionarProduto($bolachaTrakinas);
$carrinho->adicionarProduto($cafe);
$carrinho->adicionarProduto($barraMilka);
$carrinho->validarCarrinho();

// Calculando o total do carrinho
$totalCarrinho = $carrinho->calcularTotal();
echo str_repeat("-", 30) . PHP_EOL;

// Instanciando os pagamentos com o valor do total
$pagamento = new Pagamento($totalCarrinho, "Cartão");

// Processando os pagamentos
$processaPagamento = new ProcessaPagamento($pagamento);

// Instanciando os caixas
$caixa1 = new Caixa(1, $carrinho);

// Abrindo os caixas
$caixa1->abrirCaixa();

// Processando as compras nos caixas
$caixa1->processarCompra($processaPagamento);

// Exibindo cupom fiscal
$caixa1->gerarCupomFiscal($processaPagamento);