<?php

namespace App\Traits;


trait InvitationTrait
{
    public function generateUniqueInvitationCode()
    {
        do {
            $code = mt_rand(10000000, 99999999);
        } while (self::where('invitation_code', $code)->exists());

        return $code;
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->invitation_code = $user->generateUniqueInvitationCode();

        });

    }

}
