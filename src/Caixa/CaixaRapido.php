<?php

declare(strict_types=1);

namespace App\Caixa;

use App\CarrinhoDeCompras\CarrinhoDeCompras;
use App\Pagamentos\Pagamento;

class CaixaRapido extends Caixa {
    private const LIMITE_ITENS = 20;

    public function processarCompra(Pagamento $pagamento): void {
        if (!$this->aberto) {
            echo "⚠️ O caixa está fechado! Abra o caixa antes de processar pagamentos" . PHP_EOL;
            return;
        }

        if ($this->carrinho->estaVazio()) {
            echo "⚠️ O carrinho está vazio. Adicione produtos antes de finalizar a compra!" . PHP_EOL;
            return;
        }

        if (count($this->carrinho->getProdutos()) > self::LIMITE_ITENS) {
            echo "❌ O Caixa Rápido aceita no máximo " . self::LIMITE_ITENS . " itens!" . PHP_EOL;
            return;
        }

        if ($pagamento->processarPagamento()) {
            $this->pagamentos[] = $pagamento;
            echo "✅ Pagamento processado no Caixa Rápido com sucesso!" . PHP_EOL;
        } 

        echo "❌ Falha ao processar o pagamento!" . PHP_EOL;
    }
}
