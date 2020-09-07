<?php

namespace App\Support\Database;

use Illuminate\Support\Facades\DB;

trait Migrationable
{
    /**
     * Check if the migration is being run on the testing environment.
     *
     * @return bool
     */
    public function isTesting(): bool
    {
        return DB::getDriverName() === 'sqlite';
    }

    /**
     * Check if the migration is not being run on the
     * testing environment.
     *
     * @return bool
     */
    public function isNotTesting()
    {
        return !$this->isTesting();
    }
}
