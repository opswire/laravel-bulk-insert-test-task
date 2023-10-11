<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ImportService
{
    public const USERS_REQUEST_COUNT = 5000;
    public const USERS_REQUEST_URL = 'https://randomuser.me/api/?results=' . self::USERS_REQUEST_COUNT;

    public function insertOrUpdateUsers(): array
    {
        $response = Http::get(self::USERS_REQUEST_URL);

        $usersData = $this->collectDataFromResponse($response);

        DB::beginTransaction();
        try {
            $upsertResult = User::upsert(
                $usersData,
                ['first_name', 'last_name'],
                ['email', 'age']
            );
        } catch (QueryException $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
        DB::commit();

        $totalUsers = User::count();

        return [
            'total' => $totalUsers,
            'added' => $this->calculateTotalAddedUsers($upsertResult),
            'updated' => $this->calculateTotalUpdatedUsers($upsertResult),
        ];
    }

    private function collectDataFromResponse(Response $response): array
    {
        $data = $response->json()['results'];

        $usersData = [];

        foreach ($data as $user) {
            $usersData[] = [
                'first_name' => $user['name']['first'],
                'last_name'  => $user['name']['last'],
                'email'      => $user['email'],
                'age'        => $user['dob']['age'],
            ];
        }

        return $usersData;
    }

    private function calculateTotalUpdatedUsers(int $upsertResult): int
    {
        return $upsertResult - self::USERS_REQUEST_COUNT;
    }

    private function calculateTotalAddedUsers(int $upsertResult): int
    {
        return 2 * self::USERS_REQUEST_COUNT - $upsertResult;
    }
}
