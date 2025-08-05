<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Helpers\CardFactories\UserCardFactory;

class UserService
{
    private $cardFactory;
    public function __construct() {
        $this->cardFactory = app(UserCardFactory::class);
    }
    public function getUserById(int $id): User
    {
        return User::with(['student', 'teacher'])->where([
            ["Id", "=", $id],
            ["IsActive", "=", true]
        ])->first();
    }
    public function getUsers(string $search = "", string $role = ""): Collection
    {
        $users = User::with(['student', 'teacher'])->where([
            ["IsActive", "=", true]
        ]);
        if (!empty($search)) {
            $users = $users->where("Name", "LIKE", "%$search%");
        }
        if (!empty($role)) {
            switch ($role) {
                case 'admin':
                    $users = $users->where('IsAdmin', true);
                    break;
                default:
                    $users = $users->whereHas($role);
                    break;
            }
        }
        $users = $users->get();
        return $users;
    }
    public function getUserCards(string $search = ""): array
    {
        $users = $this->getUsers($search);
        $cards = $this->cardFactory->makeCards($users, addNew: true);
        return $cards;
    }
}