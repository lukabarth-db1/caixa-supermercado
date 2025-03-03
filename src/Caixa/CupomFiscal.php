<?php

declare(strict_types=1);

namespace App\Caixa;

use App\Pagamentos\Pagamento;
use App\CarrinhoDeCompras\CarrinhoDeCompras;

class CupomFiscal {
    private Pagamento $pagamento;
    private CarrinhoDeCompras $carrinho;

    public function recusarPagamento(): void {
        if ($this->pagamento->getStatus() === "Recusado") {
            echo "❌ PAGAMENTO RECUSADO. Verifique o valor ou método de pagamento." . PHP_EOL;
            echo str_repeat("=", 30) . PHP_EOL;
            return;
        }
    }
    
    public function cupomFiscal(): void {
        echo "==========Cupom Fiscal==========" . PHP_EOL;
        
        $this->recusarPagamento();

        $this->pagamento->detalhesPagamento();

        echo "Itens:" . PHP_EOL;
        $this->carrinho->exibirCarrinho();

        echo "Valor total: R$ " . number_format($this->carrinho->calcularTotal(), 2, ',', '.') . PHP_EOL;

        echo str_repeat("=", 30) . PHP_EOL;
    }
}
