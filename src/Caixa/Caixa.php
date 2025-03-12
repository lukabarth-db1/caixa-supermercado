<?php

declare(strict_types=1);

namespace App\Caixa;

use App\Caixa\TipoEValorPagamento;
use App\CarrinhoDeCompras\CarrinhoDeCompras;

class Caixa {
    private const LIMITE_ITENS = 20;
    private int $numeroCaixa;
    private CarrinhoDeCompras $carrinho;
    private TipoEValorPagamento $tipoEValorPagamento;
    private float $totalCompra;

    public function __construct(int $numeroCaixa, CarrinhoDeCompras $carrinho, TipoEValorPagamento $tipoEValorPagamento) {
        $this->numeroCaixa = $numeroCaixa;
        $this->carrinho = $carrinho;
        $this->tipoEValorPagamento = $tipoEValorPagamento;
    }

    public function getTotalCompra(): float {
        return $this->carrinho->calcularTotal();
    }

    public function setTotalCompra($totalCompra): void {
        $this->totalCompra = $totalCompra;
    }

    public function getTipoPagamento(): TipoEValorPagamento {
        return $this->tipoEValorPagamento;
    }

    public function getCarrinho(): CarrinhoDeCompras {
        return $this->carrinho;
    }

    public function caixaRapido() {
        if (count($this->carrinho->getProdutos()) > self::LIMITE_ITENS) {
            echo "❌ O Caixa Rápido aceita no máximo " . self::LIMITE_ITENS . " itens!" . PHP_EOL;
            return;
        }
    }

    public function verificaSeCarrinhoEstaVazio(): void {
        if ($this->carrinho->estaVazio()) {
            echo "⚠️ Nenhum item no carrinho para gerar o cupom fiscal." . PHP_EOL;
            return;
        }
    }

    public function separaBlocoTexto(int $quantidade) {
        echo str_repeat("-", $quantidade) . PHP_EOL;
    }

    public function calculaTotalCompra(): void {
        $totalCompra = 0;
        foreach ($this->carrinho->getProdutos() as $produto) {
            $subtotal = $produto->getPrecoUnitario();
            echo "{$produto->getNome()} - R$ " . number_format($subtotal, 2, ",", ".") . PHP_EOL;
            $totalCompra += $subtotal;
            $this->setTotalCompra($totalCompra);
        }
    }

    public function mensagemParaPagamentoPix(): void {
        if ($this->tipoEValorPagamento->getTipoPagamento() === "Pix") {
            $desconto = 0.95;
            $totalComDesconto = number_format($this->getTotalCompra() * $desconto, 2, ",", ".");

            echo "💰 Subtotal R$: " . number_format($this->getTotalCompra(), 2, ",", ".") . PHP_EOL;
            echo "💰 Total com desconto R$: " . $totalComDesconto . PHP_EOL;
        } else echo "💰 Total R$: " . number_format($this->getTotalCompra(), 2, ",", ".") . PHP_EOL;
    }

    public function gerarCupomFiscal(): void {
        echo PHP_EOL . "🧾 CUPOM FISCAL - Caixa $this->numeroCaixa" . PHP_EOL;
        $this->separaBlocoTexto(30);
        $this->calculaTotalCompra();
        $this->separaBlocoTexto(30);

        $this->mensagemParaPagamentoPix();

        echo "💳 Pagamento: {$this->tipoEValorPagamento->getTipoPagamento()}" . PHP_EOL;

        echo "✅ Compra finalizada. Obrigado pela preferência e volte sempre!" . PHP_EOL;
    }
}