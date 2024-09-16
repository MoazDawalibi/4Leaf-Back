<?php
namespace App\Observers;

use App\Models\Folder;

class OrderObserver
{
    public function deleted(Folder $folder)
    {
        $parentId = $folder->parent_id;

        $items = Folder::where('parent_id', $parentId)
            ->where('order', '>', $folder->order)
            ->orderBy('order')
            ->get();

        foreach ($items as $item) {
            $item->order--;
            $item->save();
        }

    }
}
