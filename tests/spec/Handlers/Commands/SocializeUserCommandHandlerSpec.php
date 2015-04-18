<?php

namespace spec\Furnace\Handlers\Commands;

use Furnace\Commands\SocializeUserCommand;
use Furnace\Entities\Models\User;
use Furnace\Handlers\Commands\SocializeUserCommandHandler;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\Furnace\FurnaceObjectBehavior;

/**
 * @mixin SocializeUserCommandHandler
 */
class SocializeUserCommandHandlerSpec extends FurnaceObjectBehavior
{
    public function let()
    {
        parent::let();

        $this->beConstructedWith(new User());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SocializeUserCommandHandler::class);
    }

    public function it_can_create_user_first_time()
    {
        $user = $this->getDummyFacebookUser();

        $command = new SocializeUserCommand('facebook', $user);
        $user    = $this->handle($command);

        $user->shouldHaveType(User::class);
        $user->facebook_id->shouldEqual('12345');
        $user->name->shouldEqual('Maxime Fabre');
        $user->email->shouldEqual('foo@bar.com');
    }

    public function it_can_retrieve_created_user()
    {
        $user = $this->getDummyFacebookUser();
        $existing = User::where('facebook_id', '12345')->first();

        $command = new SocializeUserCommand('facebook', $user);
        $user    = $this->handle($command);

        $user->shouldHaveType(User::class);
        $user->id->shouldEqual($existing->id);
        $user->facebook_id->shouldEqual('12345');
        $user->name->shouldEqual('Maxime Fabre');
        $user->email->shouldEqual('foo@bar.com');
    }

    /**
     * @return \Laravel\Socialite\Two\User
     */
    protected function getDummyFacebookUser()
    {
        $user = new \Laravel\Socialite\Two\User();
        $user->map([
            'id'    => '12345',
            'name'  => 'Maxime Fabre',
            'email' => 'foo@bar.com',
        ]);

        return $user;
    }
}
