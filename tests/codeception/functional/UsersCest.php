<?php

class UsersCest
{
    public function testCanLogin(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->click('Login / Signup');

        $I->seeCurrentRouteIs('users.create');
        $I->submitForm('#login', [
            'name'     => 'Anahkiasen',
            'password' => 'furnace',
        ]);

        $I->seeCurrentUrlEquals('');
        $I->seeAuthentication();
    }
}
