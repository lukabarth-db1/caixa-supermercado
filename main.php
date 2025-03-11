<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Produtos\Categoria;
use App\CarrinhoDeCompras\CarrinhoDeCompras;
use App\Caixa\Caixa;
use App\Caixa\ProcessaPagamento;
use App\Caixa\TipoEValorPagamento;
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

// Para passar a forma de pagamento na linha de comando
if ($argc < 2) {
    echo "Uso correto: php main.php <forma_de_pagamento>" . PHP_EOL;
    exit(1);
}

$tipoPagamento = $argv[1];

// Instanciando o tipo e valor do carrinho
$tipoEValorCarrinho = new TipoEValorPagamento($tipoPagamento, $totalCarrinho);

// Instanciando os pagamentos com o valor do total
$caixa = new Caixa(1, $carrinho, $tipoEValorCarrinho);

// Verifica se o carrinho está vazio
$caixa->verificaSeCarrinhoEstaVazio();

// Processando os pagamentos
$processaPagamento = new ProcessaPagamento($caixa);
$processaPagamento->processarPagamentos();

// Exibindo cupom fiscal
$caixa->gerarCupomFiscal($processaPagamento);