<?php

declare(strict_types=1);

namespace App\Caixa;

use App\Pagamentos\Pagamento;

class Caixa {
    protected int $numeroCaixa;
    protected array $pagamentos = [];
    protected bool $aberto;

    public function __construct(int $numeroCaixa) {
        $this->numeroCaixa = $numeroCaixa;
        $this->aberto = false;
    }

    public function abrirCaixa(): void {
        $this->aberto = true;
        echo "Caixa $this->numeroCaixa aberto!" . PHP_EOL;
    }

    public function fecharCaixa(): void {
        $this->aberto = false;
        echo "Caixa $this->numeroCaixa fechado!" . PHP_EOL;
    }

    public function processarCompra(Pagamento $pagamento): void {
        if (!$this->aberto) {
            echo "O caixa está fechado. Abra o caixa antes de processar pagamentos." . PHP_EOL;
        }

        $this->pagamentos[] = $pagamento;
        $pagamento->processarPagamento();
        echo "Pagamento processado pelo caixa $this->numeroCaixa" . PHP_EOL;
    }

    public function exibirRelatorio(): void {
        echo "Relatório do caixa $this->numeroCaixa" . PHP_EOL;
        echo "Total de pagamentos: " . count($this->pagamentos) . PHP_EOL;

        $totalRecebido = array_reduce($this->pagamentos, function($total, $pagamento) {
            return $total + $pagamento->getValorTotal();
        }, 0);

        echo "Total recebido: R$ " . number_format($totalRecebido, 2, ',', '.') . PHP_EOL;
    }
}