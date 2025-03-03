<?php

declare(strict_types=1);

namespace App\Pagamentos;

class Pix extends Pagamento {
    private bool $descontoAplicado = false;

    public function __construct(float $valorTotal, string $tipo) {
        parent::__construct($valorTotal, $tipo);
    }

    private function aplicarDesconto(): void {
        if ($this->descontoAplicado) {
            return;
        }

        $desconto = $this->valorTotal * 0.05;
        $this->setValorTotal($this->getValorTotal() * 0.95);
        $this->descontoAplicado = true;

        echo "Pagamento via Pix! Desconto de 5% aplicado. Novo total: R$ " . number_format($this->valorTotal, 2, ',', '.') . PHP_EOL;
    }

    public function processarPagamento(): bool {
        if ($this->getTipo() !== "Pix") {
            echo "Tipo de pagamento inválido!" . PHP_EOL;
            $this->setStatus("Recusado");
            return false;
        }

        $this->aplicarDesconto();

        $this->setStatus("Aprovado");
        return true;
    }

    public function exibirDetalhes(): void {
        echo $this->detalhesPagamento() . PHP_EOL;
    }
}

