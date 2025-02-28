<?php

declare(strict_types=1);

namespace App\Produtos;

use App\Produtos\Categoria;

abstract class Produtos {
    protected int $codigo;
    protected string $nome;
    protected float $precoUnitario;
    protected string $unidadeMedida;
    protected Categoria $categoria;

    public function __construct(int $codigo, string $nome, float $precoUnitario, string $unidadeMedida, Categoria $categoria) {
        $this->codigo = $codigo;
        $this->nome = $nome;
        $this->precoUnitario = $precoUnitario;
        $this->unidadeMedida = $unidadeMedida;
        $this->categoria = $categoria;
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

    public function getUnidadeMedida(): string {
        return $this->unidadeMedida;
    }

    public function detalhesProduto(): string {
        return "Código: {$this->getCodigo()}" . PHP_EOL .
                "Nome: {$this->getNome()}" . PHP_EOL .
                "Preço: {$this->getPrecoUnitario()}" . PHP_EOL .
                "Unidade de medida: {$this->getUnidadeMedida()}" . PHP_EOL . 
                "Categoria do produto: {$this->categoria->getNome()}" . PHP_EOL;
    }

    abstract public function exibirDetalhes(): void;
}
