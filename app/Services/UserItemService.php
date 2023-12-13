<?php

namespace App\Services;

use App\Models\UserItem;
use Illuminate\Database\Eloquent\Relations\Relation;
use Throwable;

final class UserItemService
{
    public function create(string $userDni, string $itemCode, string $itemType): bool
    {
        try {
            $user = (new UserService())->show($userDni);

            if (!$user) {
                return false;
            }

            $itemClass = Relation::getMorphedModel($itemType);

            if (!$itemClass) {
                return false;
            }

            $item = $itemClass::query()->where('code', $itemCode)->first();

            if (!$item) {
                return false;
            }

            $userItem = UserItem::query()
                ->where('user_id', $user->id)
                ->where('entity_id', $item->id)
                ->where('entity_type', $itemType);

            if ($userItem->exists()) {
                return false;
            }

            $userItem = UserItem::query()->create([
                'user_id' => $user->id,
                'entity_id' => $item->id,
                'entity_type' => $itemType,
            ]);

            return true;
        } catch (Throwable $th) {
            report($th);
            return false;
        }
    }
}
