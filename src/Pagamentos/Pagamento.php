<?php

declare(strict_types=1);

namespace App\Pagamentos;

class Pagamento {
    private float $valorTotal;
    private string $tipo;

    public function __construct(float $valorTotal, string $tipo) {
        $this->valorTotal = $valorTotal;
        $this->tipo = $tipo;
    }

    public function getValorTotal(): float {
        return $this->valorTotal;
    }

    public function setValorTotal($valorTotal): void {
        $this->valorTotal = $valorTotal;
    }

    public function getTipo(): string {
        return $this->tipo;
    }

    public function setTipo(string $tipo) {
        $this->tipo = $tipo;
    }
}