<?php

declare(strict_types=1);

namespace App\Caixa;

use App\Pagamentos\Pagamento;

class ProcessaPagamento {
    private Pagamento $pagamento;
    private bool $taxaAplicada;
    private bool $descontoAplicado;
    private float $valorEmDinheiro = 200;
    private float $troco = 0.0;

    public function __construct(Pagamento $pagamento) {
        $this->pagamento = $pagamento;
        $this->taxaAplicada = false;
        $this->descontoAplicado = false;
    }

    public function getPagamento(): Pagamento {
        return $this->pagamento;
    }

    public function getTaxaAplicada(): bool {
        return $this->taxaAplicada;
    }

    public function setTaxaAplicada(bool $taxaAplicada) {
        $this->taxaAplicada = $taxaAplicada;
    }

    public function getDescontoAplicado(): bool {
        return $this->descontoAplicado;
    }

    public function setDescontoAplicado(bool $descontoAplicado): void {
        $this->descontoAplicado = $descontoAplicado;
    }

    public function getValorEmDinheiro(): float {
        return $this->valorEmDinheiro;
    }

    public function setValorEmDinheiro(float $valorEmDinheiro) {
        $this->valorEmDinheiro = $valorEmDinheiro;
    }

    public function getTroco(): float {
        return $this->troco;
    }

    public function setTroco(float $troco) {
        $this->troco = $troco;
    }

    public function aplicarDescontoPagamentoPix(): void {
        if ($this->descontoAplicado) {
            return;
        }

        $this->pagamento->setValorTotal($this->pagamento->getValorTotal() * 0.95);
        $this->descontoAplicado = true;

        echo "Pagamento via Pix! Desconto de 5% aplicado. Novo total: R$ " . number_format($this->pagamento->getValorTotal(), 2, ',', '.') . PHP_EOL;
    }

    public function calculaTroco(): bool {
        if ($this->getValorEmDinheiro() > $this->pagamento->getValorTotal()) {
            $this->setTroco($this->getValorEmDinheiro() - $this->pagamento->getValorTotal());
            if ($this->getTroco() > 0) {
                echo "🪙 Troco de R$ {$this->getTroco()} devolvido ao cliente." . PHP_EOL;
            }
        }

        return true;
    }

    public function valorInsuficiente(): bool {
        return $this->getValorEmDinheiro() < $this->pagamento->getValorTotal();
    }

    public function processarPagamentos(): bool {
        if (!in_array($this->pagamento->getTipo(), ["Pix", "Dinheiro", "Cartão"], true)) {
            echo "⚠️ Tipo de pagamento inválido!" . PHP_EOL;
            return false;
        }

        if ($this->pagamento->getTipo() === "Pix") {
            $this->aplicarDescontoPagamentoPix();
            return true;
        }

        if ($this->pagamento->getTipo() === "Dinheiro") {
            if ($this->valorInsuficiente()) {
                echo "❌ Valor insuficiente." . PHP_EOL;
                exit();
            }

            $this->calculaTroco();
            return true;
        }

        if ($this->pagamento->getTipo() === "Cartão") {
            return true;
        }

        return false;
    }
}
