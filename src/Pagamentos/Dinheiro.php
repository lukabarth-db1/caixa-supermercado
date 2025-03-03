<?php

declare(strict_types=1);

namespace App\Pagamentos;

class Dinheiro extends Pagamento {
    private float $valorEmDinheiro;
    private float $troco = 0.0;

    public function __construct(float $valorTotal, string $tipo, float $valorEmDinheiro) {
        parent::__construct($valorTotal, $tipo);
        $this->valorEmDinheiro = $valorEmDinheiro;
    }

    public function getValorEmDinheiro(): float {
        return $this->valorEmDinheiro;
    }

    public function getTroco(): float {
        return $this->troco;
    }

    public function calculaTroco(): void {
        if ($this->getValorEmDinheiro() > $this->getValorTotal()) {
            $this->troco = $this->getValorEmDinheiro() - $this->getValorTotal();
            echo "Troco de R$ {$this->troco} devolvido ao cliente." . PHP_EOL;
        }
    }

    public function valorInsuficiente(): bool {
        return $this->getValorEmDinheiro() < $this->getValorTotal();
    }

    public function processarPagamento(): bool {
        if ($this->getTipo() !== "Dinheiro") {
            echo "Tipo de pagamento inválido!" . PHP_EOL;
            $this->setStatus("Recusado");
            return false;
        }

        if ($this->valorInsuficiente()) {
            echo "Valor insuficiente." . PHP_EOL;
            $this->setStatus("Recusado");
            return false;
        }

        $this->setStatus("Aprovado");
        $this->calculaTroco();
        return true;
    }

    public function exibirDetalhes(): void {
        echo $this->detalhesPagamento() . PHP_EOL;
        echo "Valor em dinheiro: R$ " . number_format($this->getValorEmDinheiro(), 2, ",", ".") . PHP_EOL;
        echo "Troco: R$: " . number_format($this->getTroco(), 2, ",", ".") . PHP_EOL;
    }
}
