<?php

namespace App\Models\Bank\Concerns;

use App\Models\Api\Client;
use Illuminate\Support\Str;

trait HasApiTokens
{
    /**
     * The oauth client of this account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    /**
     * Will tell us if account has this client associated.
     *
     * @param int $clientId
     *
     * @return bool
     */
    public function hasClientAssociated(int $clientId): bool
    {
        return !is_null($this->client) && $this->client->id === $clientId;
    }

    /**
     * Regenerate api secret when user logs out.
     *
     * @return bool
     */
    public function regenerateApiSecret(): bool
    {
        return $this->client->update(['secret' => Str::random(40)]);
    }
}
