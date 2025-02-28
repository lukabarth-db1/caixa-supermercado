<?php

declare(strict_types=1);

namespace App\Pagamentos;

use App\CarrinhoDeCompras\CarrinhoDeCompras;
use DateTime;

class Pagamento {
    protected float $valorTotal;
    private float $valorRecebido;
    private string $status;
    protected string $metodoPagamento;
    private string $codigoTransacao;
    private DateTime $dataTransacao;
    private CarrinhoDeCompras $carrinho;

    public function __construct(CarrinhoDeCompras $carrinho, string $metodoPagamento) {
        $this->carrinho = $carrinho;
        $this->valorTotal = $carrinho->calcularTotal();
        $this->valorRecebido = 20;
        $this->status = "Pendente";
        $this->metodoPagamento = $metodoPagamento;
        $this->codigoTransacao = uniqid("PG_");
        $this->dataTransacao = new DateTime();
    }

    private function aplicarDesconto(): void {
        if ($this->metodoPagamento === "Pix") {
            $valorTotal = $this->valorTotal;
            $desconto = $this->valorTotal * 0.05;
            $valorComDesconto = $valorTotal - $desconto;
            $this->valorTotal = $valorComDesconto;

            echo "Pagamento via Pix! Desconto de 5% aplicado. Novo total: R$ " . number_format($valorComDesconto, 2, ',', '.') . PHP_EOL;
        }
    }

    protected function cupomFiscal(): void {
        echo "==========Cupom Fiscal==========" . PHP_EOL;
        if ($this->status === "Recusado") {
            echo "PAGAMENTO RECUSADO: Valor insuficiente!" . PHP_EOL;
            echo str_repeat("=", 30) . PHP_EOL;
            return;
        }

        if ($this->metodoPagamento === "Pix") {
            $this->aplicarDesconto();
        }

        if ($this->metodoPagamento === "Cartão Internacional") {
            echo "Para pagamentos internacionais é aplicado uma taxa de 10%. Novo total: R$ " . number_format($this->valorTotal, 2, ',', '.') . PHP_EOL;
        }

        echo "Código de transação: $this->codigoTransacao" . PHP_EOL;
        echo "Método de pagamento: $this->metodoPagamento" . PHP_EOL;
        echo "Status: $this->status" . PHP_EOL;
        echo "Data da transação {$this->dataTransacao->format('d/m/y H:i:s')}" . PHP_EOL;
        echo "Itens comprados:" . PHP_EOL;

        foreach ($this->carrinho->getProdutos() as $produto) {
            echo "=> {$produto->getNome()} R$ {$produto->getPrecoUnitario()}" . PHP_EOL;
        }
        echo "Valor total: R$ " . number_format($this->valorTotal, 2, ',', '.') . PHP_EOL;

        if ($this->metodoPagamento === "Dinheiro") {
            echo "Valor recebido: R$ $this->valorRecebido" . PHP_EOL;
            echo str_repeat("=", 30) . PHP_EOL;
        }
        echo str_repeat("=", 30) . PHP_EOL;
    }

    public function processarPagamento(): void {
        switch($this->metodoPagamento) {
            case "Pix":
                $this->status = "Aprovado";
                break;
            case "Dinheiro":
                if ($this->valorRecebido > $this->valorTotal) {
                    $troco = $this->valorRecebido - $this->valorTotal;
                    echo "Troco de R$ $troco devolvido para o cliente" . PHP_EOL;
                    $this->status = "Aprovado";
                } else $this->status = "Recusado";
                break;
            default:
                $this->status = "Aguardando aprovação";
        }
    }

    public function confirmarPagamento(): void {
        $this->status = "Aprovado";
    }

    public function cancelarPagamento(): void {
        $this->status = "Recusado";
    }

    public function exibirDetalhesPagamento(): void {
        $this->cupomFiscal();
    }

    public function getValorTotal(): float {
        return $this->valorTotal;
    }

    public function getCarrinho(): CarrinhoDeCompras {
        return $this->carrinho;
    }
}