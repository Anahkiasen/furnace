<?php
namespace Notetracker\Providers;

use ErrorException;
use Exception;
use League\Container\ServiceProvider;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class ErrorsServiceProvider extends ServiceProvider
{
    /**
     * @type array
     */
    protected $provides = [
        Run::class,
    ];

    /**
     * Register method.
     */
    public function register()
    {
        $this->container->add(Run::class, function () {
            $whoops = new Run();
            $whoops->pushHandler(new PrettyPageHandler());

            return $whoops;
        });

        set_error_handler(function ($level, $message, $file = '', $line = 0, $context = []) {
            if (error_reporting() & $level) {
                throw new ErrorException($message, 0, $level, $file, $line);
            }
        });

        set_exception_handler(function (Exception $exception) {
            $this->container->call(function (Run $whoops) use ($exception) {
                $whoops->handleException($exception);
            });
        });
    }
}
