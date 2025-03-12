<?php

declare(strict_types=1);

namespace App\Caixa;

use App\Caixa\Caixa;

class ProcessaPagamento {
    private Caixa $caixa;
    private bool $taxaAplicada = false;
    private bool $descontoAplicado = false;
    private float $valorEmDinheiro = 200;
    private float $troco = 0.0;

    public function __construct(Caixa $caixa) {
        $this->caixa = $caixa;
    }

    public function getTaxaAplicada(): bool {
        return $this->taxaAplicada;
    }

    public function setTaxaAplicada(bool $taxaAplicada): void {
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

    public function setValorEmDinheiro(float $valorEmDinheiro): void {
        $this->valorEmDinheiro = $valorEmDinheiro;
    }

    public function getTroco(): float {
        return $this->troco;
    }

    public function setTroco(float $troco): void {
        $this->troco = $troco;
    }

    public function aplicarDescontoPagamentoPix(): void {
        if ($this->descontoAplicado) {
            return;
        }

        $novoValor = $this->caixa->getCarrinho()->calcularTotal() * 0.95;
        $this->caixa->setTotalCompra($novoValor);
        $this->descontoAplicado = true;

        echo "💰 Pagamento via Pix! Desconto de 5% aplicado. Novo total: R$ " . number_format($novoValor, 2, ',', '.') . PHP_EOL;
    }

    public function calcularTroco(): void {
        $troco = $this->getValorEmDinheiro() - $this->caixa->getTotalCompra();
        if ($troco > 0) {
            $this->setTroco($troco);
            echo "💸 Valor recebido: " . number_format($this->getValorEmDinheiro(), 2, ',', '.'). PHP_EOL;
            echo "🪙 Troco de R$ " . number_format($troco, 2, ',', '.') . " devolvido ao cliente." . PHP_EOL;
        }
    }

    public function valorInsuficiente(): bool {
        return $this->getValorEmDinheiro() < $this->caixa->getTotalCompra();
    }

    public function processarPagamentos(): bool {
        if (!in_array($this->caixa->getTipoPagamento()->getTipoPagamento(), ["Pix", "Dinheiro", "Cartão"], true)) {
            echo "⚠️ Tipo de pagamento inválido!" . PHP_EOL;
            exit();
        }

        if ($this->caixa->getTipoPagamento()->getTipoPagamento() === "Pix") {
            $this->aplicarDescontoPagamentoPix();
            return true;
        }
        
        if ($this->caixa->getTipoPagamento()->getTipoPagamento() === "Dinheiro") {
            if ($this->valorInsuficiente()) {
                echo "❌ Valor insuficiente." . PHP_EOL;
                exit();
            }
            $this->calcularTroco();
            return true;
        }
        
        if ($this->caixa->getTipoPagamento()->getTipoPagamento() === "Cartão") {
            return true;
        }

        return false;
    }
}
