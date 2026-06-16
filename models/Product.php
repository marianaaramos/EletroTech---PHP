<?php

class Product extends Model
{
    protected string $table = 'produtos';

    public function create(array $data): int|false
    {
        $nome        = $this->sanitize($data['nome']);
        $descricao   = $this->sanitize($data['descricao'] ?? '');
        $preco       = (float) str_replace(',', '.', $data['preco']);
        $preco_promo = !empty($data['preco_promocional']) ? (float) str_replace(',', '.', $data['preco_promocional']) : null;
        $estoque     = (int) $data['estoque'];
        $cat_id      = (int) $data['categoria_id'];
        $marca       = $this->sanitize($data['marca'] ?? '');
        $modelo      = $this->sanitize($data['modelo'] ?? '');
        $ativo       = isset($data['ativo']) ? 1 : 0;
        $destaque    = isset($data['destaque']) ? 1 : 0;
        $imagem      = $data['imagem'] ?? '';

        $sql  = "INSERT INTO produtos (nome, descricao, preco, preco_promocional, estoque,
                 categoria_id, marca, modelo, imagem, ativo, destaque, created_at)
                 VALUES (:nome, :descricao, :preco, :preco_promo, :estoque,
                 :cat_id, :marca, :modelo, :imagem, :ativo, :destaque, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':preco', $preco);
        $stmt->bindValue(':preco_promo', $preco_promo);
        $stmt->bindValue(':estoque', $estoque, PDO::PARAM_INT);
        $stmt->bindValue(':cat_id', $cat_id, PDO::PARAM_INT);
        $stmt->bindValue(':marca', $marca);
        $stmt->bindValue(':modelo', $modelo);
        $stmt->bindValue(':imagem', $imagem);
        $stmt->bindValue(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->bindValue(':destaque', $destaque, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return (int) $this->lastInsertId();
        }
        return false;
    }

    public function update(int $id, array $data): bool
    {
        $nome        = $this->sanitize($data['nome']);
        $descricao   = $this->sanitize($data['descricao'] ?? '');
        $preco       = (float) str_replace(',', '.', $data['preco']);
        $preco_promo = !empty($data['preco_promocional']) ? (float) str_replace(',', '.', $data['preco_promocional']) : null;
        $estoque     = (int) $data['estoque'];
        $cat_id      = (int) $data['categoria_id'];
        $marca       = $this->sanitize($data['marca'] ?? '');
        $modelo      = $this->sanitize($data['modelo'] ?? '');
        $ativo       = isset($data['ativo']) ? 1 : 0;
        $destaque    = isset($data['destaque']) ? 1 : 0;

        if (!empty($data['imagem'])) {
            $sql  = "UPDATE produtos SET nome=:nome, descricao=:descricao, preco=:preco,
                     preco_promocional=:preco_promo, estoque=:estoque, categoria_id=:cat_id,
                     marca=:marca, modelo=:modelo, imagem=:imagem, ativo=:ativo, destaque=:destaque WHERE id=:id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':imagem', $data['imagem']);
        } else {
            $sql  = "UPDATE produtos SET nome=:nome, descricao=:descricao, preco=:preco,
                     preco_promocional=:preco_promo, estoque=:estoque, categoria_id=:cat_id,
                     marca=:marca, modelo=:modelo, ativo=:ativo, destaque=:destaque WHERE id=:id";
            $stmt = $this->db->prepare($sql);
        }

        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':preco', $preco);
        $stmt->bindValue(':preco_promo', $preco_promo);
        $stmt->bindValue(':estoque', $estoque, PDO::PARAM_INT);
        $stmt->bindValue(':cat_id', $cat_id, PDO::PARAM_INT);
        $stmt->bindValue(':marca', $marca);
        $stmt->bindValue(':modelo', $modelo);
        $stmt->bindValue(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->bindValue(':destaque', $destaque, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function findAllWithCategory(int $page = 1, int $perPage = ITEMS_PER_PAGE): array
    {
        $offset = ($page - 1) * $perPage;
        $sql    = "SELECT p.*, c.nome as categoria_nome
                   FROM produtos p
                   LEFT JOIN categorias c ON p.categoria_id = c.id
                   ORDER BY p.created_at DESC
                   LIMIT :limit OFFSET :offset";
        $stmt   = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findByIdWithCategory(int $id): array|false
    {
        $sql  = "SELECT p.*, c.nome as categoria_nome
                 FROM produtos p
                 LEFT JOIN categorias c ON p.categoria_id = c.id
                 WHERE p.id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function findByCategory(int $catId, int $page = 1, int $perPage = ITEMS_PER_PAGE): array
    {
        $offset = ($page - 1) * $perPage;
        $sql    = "SELECT p.*, c.nome as categoria_nome
                   FROM produtos p
                   LEFT JOIN categorias c ON p.categoria_id = c.id
                   WHERE p.categoria_id = :cat_id AND p.ativo = 1
                   ORDER BY p.nome ASC
                   LIMIT :limit OFFSET :offset";
        $stmt   = $this->db->prepare($sql);
        $stmt->bindValue(':cat_id', $catId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function search(string $termo, int $page = 1, int $perPage = ITEMS_PER_PAGE): array
    {
        $offset     = ($page - 1) * $perPage;
        $termoBusca = '%' . $this->sanitize($termo) . '%';
        $sql        = "SELECT p.*, c.nome as categoria_nome
                       FROM produtos p
                       LEFT JOIN categorias c ON p.categoria_id = c.id
                       WHERE p.ativo = 1 AND (p.nome LIKE :termo OR p.descricao LIKE :termo2 OR p.marca LIKE :termo3)
                       ORDER BY p.nome ASC
                       LIMIT :limit OFFSET :offset";
        $stmt       = $this->db->prepare($sql);
        $stmt->bindValue(':termo', $termoBusca);
        $stmt->bindValue(':termo2', $termoBusca);
        $stmt->bindValue(':termo3', $termoBusca);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countSearch(string $termo): int
    {
        $termoBusca = '%' . $this->sanitize($termo) . '%';
        $sql        = "SELECT COUNT(*) as total FROM produtos
                       WHERE ativo = 1 AND (nome LIKE :termo OR descricao LIKE :termo2 OR marca LIKE :termo3)";
        $stmt       = $this->db->prepare($sql);
        $stmt->bindValue(':termo', $termoBusca);
        $stmt->bindValue(':termo2', $termoBusca);
        $stmt->bindValue(':termo3', $termoBusca);
        $stmt->execute();
        return (int) $stmt->fetch()['total'];
    }

    public function findFeatured(int $limit = 8): array
    {
        $sql  = "SELECT p.*, c.nome as categoria_nome
                 FROM produtos p
                 LEFT JOIN categorias c ON p.categoria_id = c.id
                 WHERE p.ativo = 1 AND p.destaque = 1
                 ORDER BY p.created_at DESC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countByCategory(int $catId): int
    {
        $sql  = "SELECT COUNT(*) as total FROM produtos WHERE categoria_id = :cat_id AND ativo = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':cat_id', $catId, PDO::PARAM_INT);
        $stmt->execute();
        return (int) $stmt->fetch()['total'];
    }

    public function updateStock(int $id, int $quantidade): bool
    {
        $sql  = "UPDATE produtos SET estoque = estoque - :qtd WHERE id = :id AND estoque >= :qtd2";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':qtd', $quantidade, PDO::PARAM_INT);
        $stmt->bindValue(':qtd2', $quantidade, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function handleImageUpload(array $file): string|false
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ALLOWED_EXTENSIONS)) {
            return false;
        }

        if ($file['size'] > UPLOAD_MAX_SIZE) {
            return false;
        }

        $nomeArquivo = uniqid('produto_', true) . '.' . $ext;
        $destino     = UPLOAD_DIR . $nomeArquivo;

        if (move_uploaded_file($file['tmp_name'], $destino)) {
            return $nomeArquivo;
        }
        return false;
    }

    public function countActive(): int
    {
        $sql  = "SELECT COUNT(*) as total FROM produtos WHERE ativo = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return (int) $stmt->fetch()['total'];
    }

    public function findLowStock(int $limit = 5): array
    {
        $sql  = "SELECT * FROM produtos WHERE ativo = 1 AND estoque <= 5 ORDER BY estoque ASC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
