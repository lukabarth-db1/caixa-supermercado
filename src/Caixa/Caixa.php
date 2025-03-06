<?php

declare(strict_types=1);

namespace App\Caixa;

use App\CarrinhoDeCompras\CarrinhoDeCompras;
use App\Caixa\ProcessaPagamento;

class Caixa {
    private const LIMITE_ITENS = 20;
    protected int $numeroCaixa;
    protected array $pagamentos = [];
    protected bool $aberto;
    protected ProcessaPagamento $processaPagamento;
    protected CarrinhoDeCompras $carrinho;

    public function __construct(int $numeroCaixa, CarrinhoDeCompras $carrinho) {
        $this->numeroCaixa = $numeroCaixa;
        $this->aberto = false;
        $this->carrinho = $carrinho;
    }

    public function getCarrinho(): CarrinhoDeCompras {
        return $this->carrinho;
    }

    public function abrirCaixa(): void {
        $this->aberto = true;
        echo "✅ Caixa $this->numeroCaixa aberto!" . PHP_EOL;
    }

    public function fecharCaixa(): void {
        $this->aberto = false;
        echo "❌ Caixa $this->numeroCaixa fechado!" . PHP_EOL;
    }

    public function processarCompra(ProcessaPagamento $processaPagamento): void {
        if (!$this->aberto) {
            echo "⚠️ O caixa está fechado. Abra o caixa antes de processar pagamentos." . PHP_EOL;
            return;
        }

        if ($this->carrinho->estaVazio()) {
            echo "⚠️ O carrinho está vazio. Adicione produtos antes de finalizar a compra!" . PHP_EOL;
            return;
        }

        if ($processaPagamento->processarPagamentos()) {
            $this->pagamentos[] = $processaPagamento;
            echo "✅ Pagamento processado pelo caixa $this->numeroCaixa com sucesso!" . PHP_EOL;
        } else {
            echo "❌ Falha ao processar o pagamento!" . PHP_EOL;
        }
    }

    public function caixaRapido() {
        if (count($this->carrinho->getProdutos()) > self::LIMITE_ITENS) {
            echo "❌ O Caixa Rápido aceita no máximo " . self::LIMITE_ITENS . " itens!" . PHP_EOL;
            return;
        }
    }

    public function gerarCupomFiscal(ProcessaPagamento $processaPagamento): void {
        if ($this->carrinho->estaVazio()) {
            echo "⚠️ Nenhum item no carrinho para gerar o cupom fiscal." . PHP_EOL;
            return;
        }

        echo PHP_EOL . "🧾 CUPOM FISCAL - Caixa $this->numeroCaixa" . PHP_EOL;
        echo str_repeat("-", 30) . PHP_EOL;

        $totalCompra = 0;
        foreach ($this->carrinho->getProdutos() as $produto) {
            $subtotal = $produto->getPrecoUnitario();
            echo "{$produto->getNome()} - R$ " . number_format($subtotal, 2, ",", ".") . PHP_EOL;
            $totalCompra += $subtotal;
        }

        echo str_repeat("-", 30) . PHP_EOL;
        echo "💰 Total R$: " . number_format($totalCompra, 2, ",", ".") . PHP_EOL;
        echo "💳 Pagamento: {$processaPagamento->getPagamento()->getTipo()}" . PHP_EOL;

        if ($processaPagamento->getTroco() > 0) {
            echo "🪙 Troco: R$: " . number_format($processaPagamento->getTroco(), 2, ",", ".") . PHP_EOL;
        }

        echo "✅ Compra finalizada. Obrigado pela preferência e volte sempre!" . PHP_EOL;
    }
}
