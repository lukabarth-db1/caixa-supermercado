<?php

declare(strict_types=1);

namespace App\Produtos;

class Produto {
    private int $codigo;
    private string $nome;
    private float $precoUnitario;
    private Categoria $categoria;

    public function __construct(int $codigo, string $nome, Categoria $categoria, float $precoUnitario) {
        $this->codigo = $codigo;
        $this->nome = $nome;
        $this->precoUnitario = $precoUnitario;
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

    public function setPrecoUnitario(float $precoUnitario): void {
        $this->precoUnitario = $precoUnitario;
    }

    public function getCategoria(): Categoria {
        return $this->categoria;
    }

    public function aplicarTaxaSeImportado(): void {
        $produtosImportados = [];

        if ($this->categoria->getNome() === "Importado") {
            $this->precoUnitario *= 1.10;
            $produtosImportados[] = "{$this->nome} - Preço atualizado: R$ " . number_format($this->precoUnitario, 2, ',', '.') . PHP_EOL;
        }

        if (!empty($produtosImportados)) {
            echo "🔹 Taxa de 10% aplicada ao produto:" . PHP_EOL;
            foreach ($produtosImportados as $produto) {
                echo "=> $produto" . PHP_EOL;
            }
        }
    }
}
