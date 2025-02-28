<?php

declare(strict_types=1);

namespace App\CarrinhoDeCompras;

use App\Produtos\Produtos;

class CarrinhoDeCompras {
    private array $produtos = [];

    public function adicionarProduto(Produtos $produto): void {
        $this->produtos[] = $produto;
    }

    public function removerProduto(int $codigo): void {
        foreach ($this->produtos as $index => $produto) {
            if ($produto->getCodigo() === $codigo) {
                unset($this->produtos[$index]);
                echo "=> Produto '{$produto->getNome()}' removido com sucesso!" . PHP_EOL;
                return;
            }
        }
        echo "Produto com o código $codigo não encontrado no carrinho." . PHP_EOL;
    }

    public function exibirCarrinho(): void {
        if ($this->estaVazio()) {
            echo "O carrinho está vazio." . PHP_EOL;
            return;
        }

        echo "Produtos no carrinho de compras:" . PHP_EOL;
        foreach ($this->produtos as $produto) {
            $produto->exibirDetalhes();
            echo str_repeat("-", 30) . PHP_EOL;
        }
    }

    public function calcularTotal(): float {
        $total = 0;

        foreach ($this->produtos as $produto) {
            $total += $produto->getPrecoUnitario();
        }
        return $total;
    }

    public function estaVazio(): bool {
        return empty($this->produtos);
    }

    public function validarCarrinho(): bool {
        if ($this->estaVazio()) {
            echo "Não é possível finalizar a compra com um carrinho vazio." . PHP_EOL;
            return true;
        }
        return false;
    }

    public function getProdutos(): array {
        return $this->produtos;
    }
}