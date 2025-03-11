<?php

declare(strict_types=1);

namespace App\CarrinhoDeCompras;

use App\Produtos\Produto;
use App\Servicos\ServicoImportacao;

class CarrinhoDeCompras {
    private array $produtos = [];

    public function getProdutos(): array {
        return $this->produtos;
    }

    public function adicionarProduto(Produto $produto): void {
        $this->produtos[] = $produto;
    }

    public function removerProduto(Produto $codigo): void {
        foreach ($this->getProdutos() as $index => $produto) {
            if ($produto->getCodigo() === $codigo) {
                unset($this->produtos[$index]);
                $this->produtos = array_values($this->produtos);
                echo "=> Produto '{$produto->getNome()}' removido com sucesso!" . PHP_EOL;
                return;
            }
        }
        echo "Produto com o código $codigo não encontrado no carrinho." . PHP_EOL;
    }
    

    public function exibirCarrinho(Produto $produto): void {
        if ($this->estaVazio()) {
            echo "O carrinho está vazio." . PHP_EOL;
            return;
        }

        echo "Produtos no carrinho de compras:" . PHP_EOL;
        foreach ($this->getProdutos() as $produto) {
            $produto->exibirDetalhes();
            echo str_repeat("-", 30) . PHP_EOL;
        }
    }

    public function calcularTotal(): float {
        $servicoImportacao = new ServicoImportacao();
        $servicoImportacao->aplicarTaxa($this->produtos);

        $total = 0;

        foreach ($this->getProdutos() as $produto) {
            $total += $produto->getPrecoUnitario();
        }
        return $total;
    }

    public function estaVazio(): bool {
        return empty($this->getProdutos());
    }

    public function validarCarrinho(): bool {
        if ($this->estaVazio()) {
            echo "Não é possível finalizar a compra com um carrinho vazio." . PHP_EOL;
            return true;
        }
        return false;
    }
}