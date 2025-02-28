<?php

declare(strict_types=1);

namespace App\Produtos;

class Bebidas extends Produtos implements Perecivel {
    private string $dataValidade;
    private string $tipoEmbalagem;
    private string $sabor;
    private float $volume;

    public function __construct(
        int $codigo, string $nome, float $precoUnitario, string $unidadeMedida, Categoria $categoria, string $dataValidade, string $tipoEmbalagem, string $sabor, float $volume
    ) {
        parent::__construct($codigo, $nome, $precoUnitario, $unidadeMedida, $categoria);
        $this->dataValidade = $dataValidade;
        $this->tipoEmbalagem = $tipoEmbalagem;
        $this->sabor = $sabor;
        $this->volume = $volume;
    }

    public function getDataValidade(): string {
        return $this->dataValidade;
    }

    public function exibirDetalhes(): void {
        echo $this->detalhesProduto();
        echo "Validade: $this->dataValidade" . PHP_EOL;
        echo "Tipo da embalagem: $this->tipoEmbalagem" . PHP_EOL;
        echo "Sabor: $this->sabor" . PHP_EOL;
        echo "Volume: $this->volume" . PHP_EOL;
        echo str_repeat("-", 30) . PHP_EOL;
    }
}
