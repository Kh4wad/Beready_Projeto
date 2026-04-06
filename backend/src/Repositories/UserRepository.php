<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use Cake\ORM\TableRegistry;

class UserRepository implements UserRepositoryInterface
{
    private $usersTable;
    
    public function __construct()
    {
        $this->usersTable = TableRegistry::getTableLocator()->get('Users');
    }
    
    public function findById(int $id): ?array
    {
        // 🔥 Busca TODOS os campos, sem select específico
        $user = $this->usersTable->get($id);
        return $user ? $user->toArray() : null;
    }
    
    public function findByEmail(string $email): ?array
    {
        // 🔥 Busca TODOS os campos, sem select específico
        $user = $this->usersTable->find()
            ->where(['email' => $email])
            ->first();
        
        if (!$user) {
            return null;
        }
        
        $data = $user->toArray();
        
        // 🔥 Garante que senha_hash está presente
        if (isset($user->senha_hash)) {
            $data['senha_hash'] = $user->senha_hash;
        }
        
        return $data;
    }
    
    public function create(array $data): array
    {
        $user = $this->usersTable->newEntity($data);
        $this->usersTable->saveOrFail($user);
        return $user->toArray();
    }
    
    public function update(int $id, array $data): array
    {
        $user = $this->usersTable->get($id);
        $user = $this->usersTable->patchEntity($user, $data);
        $this->usersTable->saveOrFail($user);
        return $user->toArray();
    }
    
    public function delete(int $id): bool
    {
        $user = $this->usersTable->get($id);
        return $this->usersTable->delete($user);
    }
    
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $query = $this->usersTable->find()->where(['email' => $email]);
        if ($excludeId) {
            $query->where(['id !=' => $excludeId]);
        }
        return $query->count() > 0;
    }
}