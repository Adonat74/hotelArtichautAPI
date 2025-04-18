<?php

namespace App\Services;

class SyncService
{
     public function syncRoomModel($model, $relatedModelIds) {
         if (isset($relatedModelIds)) {
             $model->rooms()->sync($relatedModelIds);
         }
     }

    public function syncServiceModel ($model, $relatedModelIds) {
        if (isset($relatedModelIds)) {
            $model->services()->sync($relatedModelIds);
        }
    }

    public function syncCategoryModel ($model, $relatedModelIds) {
        if (isset($relatedModelIds)) {
            $model->roomsCategories()->sync($relatedModelIds);
        }
    }

    public function syncFeatureModel ($model, $relatedModelIds) {
        if (isset($relatedModelIds)) {
            $model->features()->sync($relatedModelIds);
        }
    }

}
