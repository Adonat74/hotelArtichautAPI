<?php

namespace App\Services;

class SyncService
{
     public function syncRelatedModel($model, $relatedModelIds) {
         if (isset($relatedModelIds)) {
             $model->rooms()->sync($relatedModelIds);
         }
     }


}
