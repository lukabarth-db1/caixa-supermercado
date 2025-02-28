<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Produtos\Categoria;
use App\Produtos\Alimento;
use App\Produtos\Bebidas;
use App\Produtos\Higiene;
use App\CarrinhoDeCompras\CarrinhoDeCompras;
use App\Pagamentos\Pagamento;
use App\Pagamentos\PagamentoInternacional;
use App\Caixa\Caixa;
use App\Caixa\CaixaRapido;

$categoriaAlimento = new Categoria("Alimento");
$categoriaBebida = new Categoria("Bebida");
$categoriaHigiene = new Categoria("Higiene");

$leite = new Alimento(1, "Carne bovina", 52.89, "Kg", $categoriaAlimento, "25/09/2025");
$leite->exibirDetalhes();

$suco = new Bebidas(2, "Suco Prats", 10.99, "Litro", $categoriaBebida, "31/03/2025", "Plástico", "Laranja", 1);
$suco->exibirDetalhes();

$saboneteDove = new Higiene(3, "Sabonete Dove", 3.99, "Grama", $categoriaHigiene, "Lavanda", 90);
$saboneteDove->exibirDetalhes();

$carrinho = new CarrinhoDeCompras();
$carrinho->adicionarProduto($leite);
$carrinho->adicionarProduto($suco);
$carrinho->adicionarProduto($saboneteDove);

$carrinho->exibirCarrinho();

$carrinho->removerProduto(3);

$carrinho->exibirCarrinho();
$carrinho ->validarCarrinho();

echo str_repeat("-", 30) . PHP_EOL;

$pagamentoDinheiro = new Pagamento($carrinho, "Dinheiro");
$pagamentoPix = new Pagamento($carrinho, "Pix");
$pagamentoCartaoCredito = new Pagamento($carrinho, "Cartão de crédito");

$pagamentoDinheiro->processarPagamento();
$pagamentoDinheiro->exibirDetalhesPagamento();

$pagamentoPix->processarPagamento();
$pagamentoPix->exibirDetalhesPagamento();

$pagamentoCartaoCredito->processarPagamento();
$pagamentoCartaoCredito->exibirDetalhesPagamento();

$pagamentoInternacional = new PagamentoInternacional($carrinho, "Cartão Internacional");
$pagamentoInternacional->processarPagamento();
$pagamentoInternacional->exibirDetalhesPagamento();

$caixaNormal = new Caixa(1);
$caixaNormal = new Caixa(2);
$caixaNormal = new Caixa(3);
$caixaRapido = new CaixaRapido(4);

$caixaNormal->abrirCaixa();
$caixaRapido->abrirCaixa();

$pagamentoNormal = new Pagamento($carrinho, "Cartão de crédito");
$pagamentoRapido = new Pagamento($carrinho, "Pix");

$caixaNormal->processarCompra($pagamentoNormal);
$caixaRapido->processarCompra($pagamentoRapido);

$caixaNormal->exibirRelatorio();
$caixaRapido->fecharCaixa();
