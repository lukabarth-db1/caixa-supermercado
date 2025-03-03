<?php

declare(strict_types=1);

namespace App\Pagamentos;

class PagamentoInternacional extends Pagamento {
    private bool $taxaAplicada = false;

    public function __construct(float $valorTotal, string $tipo) {
        parent::__construct($valorTotal, $tipo);
    }

    public function aplicarTaxa(): void {
        if ($this->taxaAplicada) {
            return;
        }

        $this->setValorTotal($this->getValorTotal() * 1.10);
        $this->taxaAplicada = true;

        echo "Para pagamentos internacionais será aplicado uma taxa de 10%. Novo total: R$ $this->valorTotal";
    }

    public function processarPagamento(): bool {
        if ($this->getTipo() !== "Internacional") {
            echo "Tipo de pagamento inválido!" . PHP_EOL;
            $this->setStatus("Recusado");
            return false;
        }

        $this->aplicarTaxa();

        $this->setStatus("Aprovado");
        return true;
    }

    public function exibirDetalhes(): void {
        echo $this->detalhesPagamento();
    }
}