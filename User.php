<?php

class User extends Model
{
    protected string $table = 'usuarios';

    public const ROLES = ['cliente', 'admin'];

    public function create(array $data): int|false
    {
        $nome       = $this->sanitize($data['nome']);
        $email      = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
        $cpf        = preg_replace('/\D/', '', $data['cpf']);
        $telefone   = $this->sanitize($data['telefone'] ?? '');
        $nascimento = $data['data_nascimento'] ?? null;
        $role       = in_array($data['role'] ?? 'cliente', self::ROLES) ? $data['role'] : 'cliente';
        $senhaHash  = password_hash($data['senha'], PASSWORD_BCRYPT, ['cost' => 12]);

        $sql  = "INSERT INTO usuarios (nome, email, cpf, telefone, data_nascimento, senha, role, created_at)
                 VALUES (:nome, :email, :cpf, :telefone, :nascimento, :senha, :role, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':cpf', $cpf);
        $stmt->bindValue(':telefone', $telefone);
        $stmt->bindValue(':nascimento', $nascimento);
        $stmt->bindValue(':senha', $senhaHash);
        $stmt->bindValue(':role', $role);

        if ($stmt->execute()) {
            return (int) $this->lastInsertId();
        }
        return false;
    }

    public function update(int $id, array $data): bool
    {
        $nome       = $this->sanitize($data['nome']);
        $email      = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
        $telefone   = $this->sanitize($data['telefone'] ?? '');
        $nascimento = $data['data_nascimento'] ?? null;
        $role       = in_array($data['role'] ?? 'cliente', self::ROLES) ? $data['role'] : 'cliente';

        if (!empty($data['senha'])) {
            $senhaHash = password_hash($data['senha'], PASSWORD_BCRYPT, ['cost' => 12]);
            $sql       = "UPDATE usuarios SET nome=:nome, email=:email, telefone=:telefone,
                          data_nascimento=:nascimento, senha=:senha, role=:role WHERE id=:id";
            $stmt      = $this->db->prepare($sql);
            $stmt->bindValue(':senha', $senhaHash);
        } else {
            $sql  = "UPDATE usuarios SET nome=:nome, email=:email, telefone=:telefone,
                     data_nascimento=:nascimento, role=:role WHERE id=:id";
            $stmt = $this->db->prepare($sql);
        }

        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':telefone', $telefone);
        $stmt->bindValue(':nascimento', $nascimento);
        $stmt->bindValue(':role', $role);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function findByEmail(string $email): array|false
    {
        $sql  = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', filter_var(trim($email), FILTER_SANITIZE_EMAIL));
        $stmt->execute();
        return $stmt->fetch();
    }

    public function authenticate(string $email, string $senha): array|false
    {
        $user = $this->findByEmail($email);
        if ($user && password_verify($senha, $user['senha'])) {
            return $user;
        }
        return false;
    }

    public function findForRecovery(string $cpf, string $nascimento): array|false
    {
        $cpfLimpo = preg_replace('/\D/', '', $cpf);
        $sql      = "SELECT * FROM usuarios WHERE cpf = :cpf AND data_nascimento = :nascimento LIMIT 1";
        $stmt     = $this->db->prepare($sql);
        $stmt->bindValue(':cpf', $cpfLimpo);
        $stmt->bindValue(':nascimento', $nascimento);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updatePassword(int $id, string $novaSenha): bool
    {
        $hash = password_hash($novaSenha, PASSWORD_BCRYPT, ['cost' => 12]);
        $sql  = "UPDATE usuarios SET senha = :senha WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':senha', $hash);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function emailExists(string $email, int $excludeId = 0): bool
    {
        $sql  = "SELECT id FROM usuarios WHERE email = :email AND id != :exclude LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', filter_var(trim($email), FILTER_SANITIZE_EMAIL));
        $stmt->bindValue(':exclude', $excludeId, PDO::PARAM_INT);
        $stmt->execute();
        return (bool) $stmt->fetch();
    }

    public function cpfExists(string $cpf, int $excludeId = 0): bool
    {
        $cpfLimpo = preg_replace('/\D/', '', $cpf);
        $sql      = "SELECT id FROM usuarios WHERE cpf = :cpf AND id != :exclude LIMIT 1";
        $stmt     = $this->db->prepare($sql);
        $stmt->bindValue(':cpf', $cpfLimpo);
        $stmt->bindValue(':exclude', $excludeId, PDO::PARAM_INT);
        $stmt->execute();
        return (bool) $stmt->fetch();
    }

    public function findAllPaginated(int $page = 1, int $perPage = 15): array
    {
        $offset = ($page - 1) * $perPage;
        $sql    = "SELECT id, nome, email, cpf, telefone, role, created_at FROM usuarios
                   ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt   = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findByToken(string $token): array|false
    {
        $sql  = "SELECT * FROM usuarios WHERE remember_token = :token AND token_expires > NOW() LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':token', $token);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function saveRememberToken(int $id, string $token): bool
    {
        $expires = date('Y-m-d H:i:s', time() + COOKIE_LIFETIME);
        $sql     = "UPDATE usuarios SET remember_token = :token, token_expires = :expires WHERE id = :id";
        $stmt    = $this->db->prepare($sql);
        $stmt->bindValue(':token', $token);
        $stmt->bindValue(':expires', $expires);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function clearRememberToken(int $id): bool
    {
        $sql  = "UPDATE usuarios SET remember_token = NULL, token_expires = NULL WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
