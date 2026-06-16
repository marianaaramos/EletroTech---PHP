<?php

class Category extends Model
{
    protected string $table = 'categorias';

    public function create(array $data): int|false
    {
        $nome      = $this->sanitize($data['nome']);
        $descricao = $this->sanitize($data['descricao'] ?? '');
        $slug      = $this->generateSlug($nome);
        $ativo     = isset($data['ativo']) ? 1 : 0;

        $sql  = "INSERT INTO categorias (nome, descricao, slug, ativo, created_at)
                 VALUES (:nome, :descricao, :slug, :ativo, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':slug', $slug);
        $stmt->bindValue(':ativo', $ativo, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return (int) $this->lastInsertId();
        }
        return false;
    }

    public function update(int $id, array $data): bool
    {
        $nome      = $this->sanitize($data['nome']);
        $descricao = $this->sanitize($data['descricao'] ?? '');
        $slug      = $this->generateSlug($nome);
        $ativo     = isset($data['ativo']) ? 1 : 0;

        $sql  = "UPDATE categorias SET nome=:nome, descricao=:descricao, slug=:slug, ativo=:ativo WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':slug', $slug);
        $stmt->bindValue(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function findActive(): array
    {
        $sql  = "SELECT * FROM categorias WHERE ativo = 1 ORDER BY nome ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findWithProductCount(): array
    {
        $sql  = "SELECT c.*, COUNT(p.id) as total_produtos
                 FROM categorias c
                 LEFT JOIN produtos p ON p.categoria_id = c.id AND p.ativo = 1
                 WHERE c.ativo = 1
                 GROUP BY c.id
                 ORDER BY c.nome ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function nameExists(string $nome, int $excludeId = 0): bool
    {
        $sql  = "SELECT id FROM categorias WHERE nome = :nome AND id != :exclude LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome', $this->sanitize($nome));
        $stmt->bindValue(':exclude', $excludeId, PDO::PARAM_INT);
        $stmt->execute();
        return (bool) $stmt->fetch();
    }

    private function generateSlug(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');
        $text = str_replace(['á','à','ã','â','ä'], 'a', $text);
        $text = str_replace(['é','è','ê','ë'], 'e', $text);
        $text = str_replace(['í','ì','î','ï'], 'i', $text);
        $text = str_replace(['ó','ò','õ','ô','ö'], 'o', $text);
        $text = str_replace(['ú','ù','û','ü'], 'u', $text);
        $text = str_replace(['ç'], 'c', $text);
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', trim($text));
        return $text;
    }
}
