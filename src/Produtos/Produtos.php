<?php

declare(strict_types=1);

namespace App\Produtos;

abstract class Produtos {
    protected int $codigo;
    protected string $nome;
    protected float $precoUnitario;
    protected string $unidadeMedida;

    public function __construct(int $codigo, string $nome, float $precoUnitario, string $unidadeMedida) {
        $this->codigo = $codigo;
        $this->nome = $nome;
        $this->precoUnitario = $precoUnitario;
        $this->unidadeMedida = $unidadeMedida;
    }

    public function getCodigo(): int {
        return $this->codigo;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getPrecoUnitario(): float {
        return $this->precoUnitario;
    }

    public function detalhesProduto(): string {
        return "Código: $this->codigo" . PHP_EOL .
                "Nome: $this->nome" . PHP_EOL .
                "Preço: $this->precoUnitario" . PHP_EOL .
                "Unidade de medida: $this->unidadeMedida" . PHP_EOL;
    }

    abstract public function exibirDetalhes(): void;
}
