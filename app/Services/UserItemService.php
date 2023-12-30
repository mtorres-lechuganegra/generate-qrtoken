<?php

namespace App\Services;

use App\Exceptions\EntityException;
use App\Exceptions\UserException;
use App\Exceptions\UserItemException;
use App\Models\UserItem;
use Illuminate\Database\Eloquent\Relations\Relation;

final class UserItemService
{
    public function create(string $userDni, string $itemCode, string $itemType): UserItem
    {
        $user = (new UserService())->show($userDni);

        if (!$user) {
            throw UserException::userNotFound();
        }

        $itemClass = Relation::getMorphedModel($itemType);

        if (!$itemClass) {
            throw EntityException::invalidEntity($itemType);
        }

        $item = $itemClass::query()->where('code', $itemCode)->first();

        if (!$item) {
            throw EntityException::entityNotFound();
        }

        $userItem = UserItem::query()
            ->where('user_id', $user->id)
            ->where('entity_id', $item->id)
            ->where('entity_type', $itemType);

        if ($userItem->exists()) {
            throw UserItemException::entityAlreadyAssignedToUser();
        }

        return UserItem::query()->create([
            'user_id' => $user->id,
            'entity_id' => $item->id,
            'entity_type' => $itemType,
        ]);
    }
}
