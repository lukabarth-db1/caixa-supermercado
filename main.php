<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Produtos\Categoria;
use App\Produtos\Alimento;
use App\Produtos\Bebidas;
use App\Produtos\Higiene;
use App\CarrinhoDeCompras\CarrinhoDeCompras;
use App\Pagamentos\Pix;
use App\Pagamentos\Cartao;
use App\Pagamentos\Dinheiro;
use App\Pagamentos\PagamentoInternacional;
use App\Caixa\Caixa;
use App\Caixa\CaixaRapido;

// Criando categorias
$categoriaAlimento = new Categoria("Alimento");
$categoriaBebida = new Categoria("Bebida");
$categoriaHigiene = new Categoria("Higiene");

// Criando produtos
$leite = new Alimento(1, "Carne bovina", 52.89, "Kg", $categoriaAlimento, "25/09/2025");
$leite->exibirDetalhes();

$suco = new Bebidas(2, "Suco Prats", 10.99, "Litro", $categoriaBebida, "31/03/2025", "Plástico", "Laranja", 1);
$suco->exibirDetalhes();

$saboneteDove = new Higiene(3, "Sabonete Dove", 3.99, "Grama", $categoriaHigiene, "Lavanda", 90);
$saboneteDove->exibirDetalhes();

// Criando o carrinho de compras
$carrinho = new CarrinhoDeCompras();
$carrinho->adicionarProduto($leite);
$carrinho->adicionarProduto($suco);
$carrinho->adicionarProduto($saboneteDove);

$carrinho->exibirCarrinho();

// Removendo um produto e validando o carrinho
$carrinho->removerProduto(3);
$carrinho->exibirCarrinho();
$carrinho->validarCarrinho();

// Calculando o total do carrinho
$total = $carrinho->calcularTotal();

echo str_repeat("-", 30) . PHP_EOL;

// Instanciando os pagamentos com o valor do total
$pagamentoDinheiro = new Dinheiro($total, "Dinheiro", 100.00);
$pagamentoPix = new Pix($total, "Pix");
$pagamentoCartaoCredito = new Cartao($total, "Crédito", 1000, 250);
$pagamentoCartaoDebito = new Cartao($total, "Débito", 500, 0);

// Processando os pagamentos
$pagamentoDinheiro->processarPagamento();
$pagamentoDinheiro->exibirDetalhes();

$pagamentoPix->processarPagamento();
$pagamentoPix->exibirDetalhes();

$pagamentoCartaoCredito->processarPagamento();
$pagamentoCartaoCredito->exibirDetalhes();

$pagamentoInternacional = new PagamentoInternacional($total, "Internacional");
$pagamentoInternacional->processarPagamento();
$pagamentoInternacional->exibirDetalhes();

// Instanciando os caixas
$caixaNormal1 = new Caixa(1, $carrinho);
$caixaNormal2 = new Caixa(2, $carrinho);
$caixaNormal3 = new Caixa(3, $carrinho);
$caixaRapido = new CaixaRapido(4, $carrinho);

// Abrindo os caixas
$caixaNormal1->abrirCaixa();
$caixaRapido->abrirCaixa();

// Processando as compras nos caixas
$caixaNormal1->processarCompra($pagamentoDinheiro);
$caixaRapido->processarCompra($pagamentoPix);

// Exibindo relatórios dos caixas
$caixaNormal1->exibirRelatorio();
$caixaRapido->fecharCaixa();
