<?php
declare(strict_types=1);

namespace App\Contracts;

interface UserRepositoryInterface
{
    public function findById(int $id): ?array;
    public function findByEmail(string $email): ?array;
    public function create(array $data): array;
    public function update(int $id, array $data): array;
    public function delete(int $id): bool;
    public function emailExists(string $email, ?int $excludeId = null): bool;
}