<?php

namespace App\Policies;

use App\Models\AuthRegister;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AuthRegisterPolicy
{
    /**
     * Determine if the given transactions can be updated by the user.
     */
    public function modify(User $user, Transactions $transaction): Response
    {
        return $user->id === $transaction->user_id
            ? Response::allow()
            : Response::deny('You do not own this transaction.');
    }

}
