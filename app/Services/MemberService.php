<?php

namespace App\Services;

use App\Mail\WelcomeMail;
use App\Models\Member;
use Illuminate\Support\Facades\Mail;

/**
 * Бизнес логиката за членовете - извън контролера (лекция 5, слайд 13 „Тънки контролери“).
 */
class MemberService
{
    /**
     * Register a new member and send a welcome email.
     *
     * @param  array{name: string, email: string}  $data
     */
    public function register(array $data): Member
    {
        $member = Member::create($data);

        Mail::to($member->email)->send(new WelcomeMail($member));

        return $member;
    }
}
