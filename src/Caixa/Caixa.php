<?php

declare(strict_types=1);

namespace App\Caixa;

use App\CarrinhoDeCompras\CarrinhoDeCompras;
use App\Pagamentos\Pagamento;

class Caixa {
    protected int $numeroCaixa;
    protected array $pagamentos = [];
    protected bool $aberto;
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

    public function processarCompra(Pagamento $pagamento): void {
        if (!$this->aberto) {
            echo "⚠️ O caixa está fechado. Abra o caixa antes de processar pagamentos." . PHP_EOL;
            return;
        }

        if ($this->carrinho->estaVazio()) {
            echo "⚠️ O carrinho está vazio. Adicione produtos antes de finalizar a compra!" . PHP_EOL;
            return;
        }

        if ($pagamento->processarPagamento()) {
            $this->pagamentos[] = $pagamento;
            echo "✅ Pagamento processado pelo caixa $this->numeroCaixa com sucesso!" . PHP_EOL;
        } else {
            echo "❌ Falha ao processar o pagamento!" . PHP_EOL;
        }
    }

    public function exibirRelatorio(): void {
        if (empty($this->pagamentos)) {
            echo "⚠️ Nenhum pagamento foi processado no caixa $this->numeroCaixa." . PHP_EOL;
            return;
        }

        echo PHP_EOL . "📜 Relatório do caixa $this->numeroCaixa" . PHP_EOL;
        echo "Total de pagamentos: " . count($this->pagamentos) . PHP_EOL;

        $totalRecebido = 0;

        foreach ($this->pagamentos as $pagamento) {
            echo "💳 Pagamento de R$ " . number_format($pagamento->getValorTotal(), 2, ',', '.') . 
                 " | Status: " . $pagamento->getStatus() . PHP_EOL;
            $totalRecebido += $pagamento->getValorTotal();
        }

        echo "💰 Total recebido: R$ " . number_format($totalRecebido, 2, ',', '.') . PHP_EOL;
    }
}
