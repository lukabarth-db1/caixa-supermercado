<?php

declare(strict_types=1);

namespace App\Pagamentos;

class Cartao extends Pagamento {
    private float $saldo;
    private float $limite;

    public function __construct(float $valorTotal, string $tipo, float $saldo, float $limite) {
        parent::__construct($valorTotal, $tipo);
        $this->saldo = $saldo;
        $this->limite = $limite;
    }

    public function getSaldo(): float {
        return $this->saldo;
    }

    public function setSaldo(float $saldo): void {
        $this->saldo = $saldo;
    }

    public function getLimite(): float {
        return $this->limite;
    }

    public function setLimite(float $limite): void {
        $this->limite = $limite;
    }

    public function limiteInsuficiente(float $valor): bool {
        return $this->getLimite() < $valor;
    }

    public function saldoInsuficiente(float $valor): bool {
        return $this->getSaldo() < $valor;
    }

    public function processarPagamento(): bool {
        if (!in_array($this->getTipo(), ["Débito", "Crédito"])) {
            echo "Tipo de pagamento inválido!";
            $this->setStatus("Recusado");
            return false;
        }

        if ($this->getTipo() === "Débito") {
            if ($this->saldoInsuficiente($this->getValorTotal())) {
                echo "Saldo insuficiente para compra";
                $this->setStatus("Recusado");
                return false;
            }

            $this->setSaldo($this->getSaldo() - $this->getValorTotal());
            $this->setStatus("Aprovado");
            return true;
        }

        if ($this->getTipo() === "Crédito") {
            if ($this->limiteInsuficiente($this->getValorTotal())) {
                echo "Limite insuficiente para compra.";
                $this->setStatus("Recusado");
                return false;
            }

            $this->setLimite($this->getLimite() - $this->getValorTotal());
            $this->setStatus("Aprovado");
            return true;
        }
        
        return false;
    }

    public function exibirDetalhes(): void {
        echo $this->detalhesPagamento();
        echo "Saldo: R$ " . number_format($this->getSaldo(), 2, ",", ".") . PHP_EOL;
        echo "Limite: R$ " . number_format($this->getLimite(), 2, ",", ".") . PHP_EOL;
    }
}
