<?php

namespace Api\Console\Commands;

use Api\Models\User;
use Webpatser\Uuid\Uuid;
use Illuminate\Console\Command;

/**
 * Create user command.
 *
 * @author  Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class UserCreate extends Command
{
    /**
     * @var string
     */
    public $signature = 'user:create';

    /**
     * @var string
     */
    public $description = 'Add a new user for the API';

    /**
     * Run the command.
     *
     * @return int
     */
    public function handle()
    {
        $user = new User;
        $user->setId(Uuid::generate(4));
        $user->setToken(Uuid::generate(4));

        if ($user->save()) {
            $this->output->success("A new user has been created\nThe access token is: {$user->getToken()}");

            \Log::info('[Artisan] A new user has been created', [
                'User id' => $user->getId(),
            ]);
        } else {
            $this->output->error('Failed to create a new user');

            \Log::error('[Artisan] Failed to create a new user');
        }

        return 0;
    }
}
