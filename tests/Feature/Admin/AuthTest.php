<?php

it('can render the login page', function () {
    $this->get('login')->assertSee('Email')
        ->assertSee('Password')
        ->assertSee('Remember me')
        ->assertSee('Forgot your password?');
});

it('can render admin dashboard page', function () {
    $this->get('dashboard')->assertSee("You are logged in!");
});