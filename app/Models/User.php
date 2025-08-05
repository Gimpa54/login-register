<?php
namespace App\Models;

use App\Core\BaseModel;
use App\Utils\Pagination;

class User extends BaseModel
{
    protected $table = 'users';

    public function getByEmail(string $email): ?object
    {
        return $this->findBy('email', $email);
    }

    public function getByToken(string $token): ?object
    {
        return $this->findBy('activation_token', $token);
    }

    public function getById(int $id): ?object
    {
        return $this->findById($id);
    }

    public function searchPaginated(string $search = '', string $role = '', int $perPage = 10): array
    {
        $query = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];
        
        if (!empty($search)) {
            $query .= " AND (lastname LIKE :search OR email LIKE :search_email)";
            $params['search'] = '%' . $search . '%';
            $params['search_email'] = '%' . $search . '%';
        }
        
        if (!empty($role)) {
            $query .= " AND role = :role";
            $params['role'] = $role;
        }
        
        $query .= " ORDER BY created_at DESC";
        
        $paginated = $this->paginate($query, $params, $perPage);
        
        return [
            'data' => $paginated['data'],
            'pagination' => new Pagination($paginated['total'], $paginated['perPage'], $paginated['page'])
        ];
    }
    

    public function create(array $data): ?int
    {
        //return parent::create($data);
        return $this->insertAndGetId($this->table, $data);
    }

    public function update(int $id, array $data)
    {
        return parent::update($id, $data);
    }

    public function updateBy($column, $value, array $data)
    {
        return parent::updateBy($column, $value, $data);
    }

    public function deleteBy(string $column, $value): bool
    {
        return parent::deleteBy($column, $value);
    }
}
