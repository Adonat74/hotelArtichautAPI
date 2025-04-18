<?php

namespace App\Services;

class AttachService
{
    public function attachRoomModel ($model, $relatedModelIds) {
        if (isset($relatedModelIds)) {
            $model->rooms()->attach($relatedModelIds);
        }
    }

    public function attachServiceModel ($model, $relatedModelIds) {
        if (isset($relatedModelIds)) {
            $model->services()->attach($relatedModelIds);
        }
    }

    public function attachCategoryModel ($model, $relatedModelIds) {
        if (isset($relatedModelIds)) {
            $model->roomsCategories()->attach($relatedModelIds);
        }
    }

    public function attachFeatureModel ($model, $relatedModelIds) {
        if (isset($relatedModelIds)) {
            $model->features()->attach($relatedModelIds);
        }
    }
}
