<?php

declare(strict_types=1);

namespace App\Caixa;

class TipoEValorPagamento {
    private string $tipoPagamento;
    private float $valorPagamento;

    public function __construct(string $tipoPagamento, float $valorPagamento) {
        $this->tipoPagamento = $tipoPagamento;
        $this->valorPagamento = $valorPagamento;
    }

    public function getTipoPagamento(): string {
        return $this->tipoPagamento;
    }

    public function getValorPagamento(): float {
        return $this->valorPagamento;
    }

    public function setValorPagamento(float $valorPagamento): void {
        $this->valorPagamento = $valorPagamento;
    }
}
