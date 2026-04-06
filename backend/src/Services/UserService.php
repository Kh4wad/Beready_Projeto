<?php
declare(strict_types=1);

namespace App\Services;

use App\Contracts\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;
    
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function register(array $data): array
    {
        if (empty($data['nome']) || empty($data['email']) || empty($data['senha'])) {
            throw new \InvalidArgumentException('Nome, e-mail e senha são obrigatórios');
        }
        
        if ($this->userRepository->emailExists($data['email'])) {
            throw new \RuntimeException('Este e-mail já está cadastrado', 409);
        }
        
        $data['senha_hash'] = password_hash($data['senha'], PASSWORD_DEFAULT);
        unset($data['senha']);
        
        $user = $this->userRepository->create($data);
        unset($user['senha_hash']);
        
        return $user;
    }
    
   public function login(string $email, string $password): array
  {
      error_log("=== LOGIN SERVICE ===");
      error_log("Email: " . $email);
      
      if (empty($email) || empty($password)) {
          throw new \InvalidArgumentException('E-mail e senha são obrigatórios');
      }
      
      $user = $this->userRepository->findByEmail($email);
      
      error_log("User found: " . ($user ? 'YES' : 'NO'));
      
      if (!$user) {
          throw new \RuntimeException('E-mail ou senha inválidos', 401);
      }
      
      // 🔥 Verifica se o campo senha_hash existe
      error_log("senha_hash exists: " . (isset($user['senha_hash']) ? 'YES' : 'NO'));
      error_log("senha_hash value: " . ($user['senha_hash'] ?? 'NULL'));
      
      $passwordVerify = password_verify($password, $user['senha_hash'] ?? '');
      error_log("Password verify: " . ($passwordVerify ? 'TRUE' : 'FALSE'));
      
      if (!$passwordVerify) {
          throw new \RuntimeException('E-mail ou senha inválidos', 401);
      }
      
      // 🔥 Atualiza último login
      $this->userRepository->update($user['id'], ['ultimo_login' => date('Y-m-d H:i:s')]);
      
      // 🔥 Só remove a senha DEPOIS de verificar
      unset($user['senha_hash']);
      
      return $user;
  }
    
    public function getUserById(int $id): array
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new \RuntimeException('Usuário não encontrado', 404);
        }
        unset($user['senha_hash']);
        return $user;
    }
    
    public function updateUser(int $id, array $data): array
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new \RuntimeException('Usuário não encontrado', 404);
        }
        
        if (isset($data['email']) && $this->userRepository->emailExists($data['email'], $id)) {
            throw new \RuntimeException('Este e-mail já está em uso', 409);
        }
        
        if (isset($data['senha'])) {
            $data['senha_hash'] = password_hash($data['senha'], PASSWORD_DEFAULT);
            unset($data['senha']);
        }
        
        $updatedUser = $this->userRepository->update($id, $data);
        unset($updatedUser['senha_hash']);
        
        return $updatedUser;
    }
    
    public function deleteUser(int $id): bool
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new \RuntimeException('Usuário não encontrado', 404);
        }
        
        return $this->userRepository->delete($id);
    }
}