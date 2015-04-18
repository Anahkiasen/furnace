<?php

namespace spec\Furnace\Handlers\Commands;

use Furnace\Commands\CreateUserCommand;
use Furnace\Entities\Models\User;
use Furnace\Handlers\Commands\CreateUserCommandHandler;
use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin CreateUserCommandHandler
 */
class CreateUserCommandHandlerSpec extends LaravelObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(new User());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CreateUserCommandHandler::class);
    }

    public function it_can_create_user()
    {
        $command = new CreateUserCommand('foo@bar.com', 'foobar', 'foobar');
        $user    = $this->handle($command);

        $user->shouldHaveType(User::class);
        $user->name->shouldEqual('foobar');
        $user->email->shouldEqual('foo@bar.com');
    }
}
