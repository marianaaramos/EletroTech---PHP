<?php

class Order extends Model
{
    protected string $table = 'pedidos';

    public const STATUS = ['pendente', 'processando', 'enviado', 'entregue', 'cancelado'];

    public function createWithItems(int $userId, array $itens, float $total): int|false
    {
        try {
            $this->db->beginTransaction();

            $sql  = "INSERT INTO pedidos (usuario_id, total, status, created_at)
                     VALUES (:usuario_id, :total, 'pendente', NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':usuario_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':total', $total);
            $stmt->execute();
            $pedidoId = (int) $this->lastInsertId();

            foreach ($itens as $item) {
                $sqlItem  = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario)
                             VALUES (:pedido_id, :produto_id, :qtd, :preco)";
                $stmtItem = $this->db->prepare($sqlItem);
                $stmtItem->bindValue(':pedido_id', $pedidoId, PDO::PARAM_INT);
                $stmtItem->bindValue(':produto_id', (int) $item['produto_id'], PDO::PARAM_INT);
                $stmtItem->bindValue(':qtd', (int) $item['quantidade'], PDO::PARAM_INT);
                $stmtItem->bindValue(':preco', (float) $item['preco']);
                $stmtItem->execute();

                $sqlEstoque = "UPDATE produtos SET estoque = estoque - :qtd WHERE id = :id AND estoque >= :qtd2";
                $stmtEst    = $this->db->prepare($sqlEstoque);
                $stmtEst->bindValue(':qtd', (int) $item['quantidade'], PDO::PARAM_INT);
                $stmtEst->bindValue(':qtd2', (int) $item['quantidade'], PDO::PARAM_INT);
                $stmtEst->bindValue(':id', (int) $item['produto_id'], PDO::PARAM_INT);
                $stmtEst->execute();
            }

            $this->db->commit();
            return $pedidoId;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function findByUser(int $userId): array
    {
        $sql  = "SELECT * FROM pedidos WHERE usuario_id = :uid ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':uid', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findWithItems(int $id): array|false
    {
        $sqlPedido = "SELECT p.*, u.nome as usuario_nome, u.email as usuario_email
                      FROM pedidos p
                      LEFT JOIN usuarios u ON p.usuario_id = u.id
                      WHERE p.id = :id LIMIT 1";
        $stmtPed   = $this->db->prepare($sqlPedido);
        $stmtPed->bindValue(':id', $id, PDO::PARAM_INT);
        $stmtPed->execute();
        $pedido = $stmtPed->fetch();

        if (!$pedido) return false;

        $sqlItens = "SELECT i.*, pr.nome as produto_nome, pr.imagem
                     FROM itens_pedido i
                     LEFT JOIN produtos pr ON i.produto_id = pr.id
                     WHERE i.pedido_id = :pid";
        $stmtIt   = $this->db->prepare($sqlItens);
        $stmtIt->bindValue(':pid', $id, PDO::PARAM_INT);
        $stmtIt->execute();
        $pedido['itens'] = $stmtIt->fetchAll();

        return $pedido;
    }

    public function findAllWithUser(int $page = 1, int $perPage = 15): array
    {
        $offset = ($page - 1) * $perPage;
        $sql    = "SELECT p.*, u.nome as usuario_nome
                   FROM pedidos p
                   LEFT JOIN usuarios u ON p.usuario_id = u.id
                   ORDER BY p.created_at DESC
                   LIMIT :limit OFFSET :offset";
        $stmt   = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateStatus(int $id, string $status): bool
    {
        if (!in_array($status, self::STATUS)) return false;
        $sql  = "UPDATE pedidos SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function totalRevenue(): float
    {
        $sql  = "SELECT SUM(total) as faturamento FROM pedidos WHERE status != 'cancelado'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return (float) ($stmt->fetch()['faturamento'] ?? 0);
    }

    public function recentCount(): int
    {
        $sql  = "SELECT COUNT(*) as total FROM pedidos WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return (int) $stmt->fetch()['total'];
    }
}
