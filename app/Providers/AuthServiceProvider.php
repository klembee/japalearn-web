<?php

namespace App\Providers;

use App\Models\Message;
use App\Models\StudentInvitation;
use App\Models\User;
use App\Models\Vocabulary;
use App\Policies\MessagesPolicy;
use App\Policies\StudentInvitationPolicy;
use App\Policies\UsersPolicy;
use App\Policies\VocabularyPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UsersPolicy::class,
        StudentInvitation::class => StudentInvitationPolicy::class,
        Vocabulary::class => VocabularyPolicy::class,
        Message::class => MessagesPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
