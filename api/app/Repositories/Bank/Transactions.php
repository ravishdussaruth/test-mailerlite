<?php

namespace App\Repositories\Bank;

use LaraChimp\MangoRepo\Annotations\EloquentModel;
use LaraChimp\MangoRepo\Repositories\EloquentRepository;

/**
 * @EloquentModel(target="App\Models\Bank\Transaction")
 */
class Transactions extends EloquentRepository
{
    //
}
