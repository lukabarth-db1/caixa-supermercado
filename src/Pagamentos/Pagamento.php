<?php

declare(strict_types=1);

namespace App\Pagamentos;

use DateTime;

abstract class Pagamento {
    protected float $valorTotal;
    protected string $tipo;
    private string $status;
    private string $codigoTransacao;
    private DateTime $dataTransacao;

    public function __construct(float $valorTotal, string $tipo) {
        $this->valorTotal = $valorTotal;
        $this->tipo = $tipo;
        $this->status = "Pendente";
        $this->codigoTransacao = uniqid("PG_");
        $this->dataTransacao = new DateTime();
    }

    abstract public function processarPagamento(): bool;

    abstract protected function exibirDetalhes(): void;

    public function getValorTotal(): float {
        return $this->valorTotal;
    }

    public function setValorTotal($valorTotal): void {
        $this->valorTotal = $valorTotal;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function getTipo(): string {
        return $this->tipo;
    }

    public function getCodigoTransacao(): string {
        return $this->codigoTransacao;
    }

    public function getDataTransacao(): DateTime {
        return $this->dataTransacao;
    }

    public function detalhesPagamento(): string {
        return "Valor total: {$this->getValorTotal()}" . PHP_EOL .
        "Status do pagamento: {$this->getStatus()}" . PHP_EOL .
        "Código da transação: {$this->getCodigoTransacao()}" . PHP_EOL .
        "Data da transação: {$this->getDataTransacao()->format('d/m/Y H:i:s')}" . PHP_EOL;
    }
}