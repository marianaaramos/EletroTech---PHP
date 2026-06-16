<?php

class Cart
{
    private string $sessionKey = 'carrinho';

    public function __construct()
    {
        if (!isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [];
        }
    }

    public function addItem(array $produto, int $quantidade = 1): void
    {
        $id = (int) $produto['id'];

        if (isset($_SESSION[$this->sessionKey][$id])) {
            $_SESSION[$this->sessionKey][$id]['quantidade'] += $quantidade;
        } else {
            $preco = !empty($produto['preco_promocional']) && $produto['preco_promocional'] > 0
                ? (float) $produto['preco_promocional']
                : (float) $produto['preco'];

            $_SESSION[$this->sessionKey][$id] = [
                'produto_id' => $id,
                'nome'       => htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8'),
                'preco'      => $preco,
                'imagem'     => $produto['imagem'] ?? '',
                'quantidade' => $quantidade,
                'estoque'    => (int) $produto['estoque'],
            ];
        }
    }

    public function removeItem(int $id): void
    {
        unset($_SESSION[$this->sessionKey][$id]);
    }

    public function updateQuantity(int $id, int $quantidade): void
    {
        if (isset($_SESSION[$this->sessionKey][$id])) {
            if ($quantidade <= 0) {
                $this->removeItem($id);
            } else {
                $estoqueMax = $_SESSION[$this->sessionKey][$id]['estoque'];
                $_SESSION[$this->sessionKey][$id]['quantidade'] = min($quantidade, $estoqueMax);
            }
        }
    }

    public function getItems(): array
    {
        return $_SESSION[$this->sessionKey] ?? [];
    }

    public function getTotal(): float
    {
        $total = 0.0;
        foreach ($this->getItems() as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }
        return $total;
    }

    public function countItems(): int
    {
        return count($this->getItems());
    }

    public function countTotal(): int
    {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += $item['quantidade'];
        }
        return $total;
    }

    public function clear(): void
    {
        $_SESSION[$this->sessionKey] = [];
    }

    public function isEmpty(): bool
    {
        return empty($this->getItems());
    }
}
