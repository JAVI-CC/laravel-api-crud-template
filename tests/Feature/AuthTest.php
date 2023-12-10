<?php

namespace Tests\Feature;

use App\Mail\RecoveryPasswordMail;
use App\Mail\VerifiedMail;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CreateNewUser;
use Tests\Traits\GetResourceUser;

class AuthTest extends TestCase
{
    use DatabaseMigrations, CreateNewUser, GetResourceUser;

    private const PATH = '/api/auth/';
    private const PATH_USER = '/api/user/';

    public function test_user_pueda_hacer_login(): void
    {
        //Organizar
        $user = $this->createNewUser();
        $data = ['email' => 'user@email.com', 'password' => '12345678'];

        //Actuar
        $res = $this->postJson(self::PATH . 'login', $data);

        //Afirmar
        $res->assertStatus(200);
        $res->assertJsonCount(10);
        $res->assertJson($this->getNewResourceUser($user, true, $data['email']));

        $this->assertDatabaseCount('personal_access_tokens', 1);
        $this->assertStringContainsString('Bearer', $res->json()['token']);
    }

    public function test_comprobar_que_el_user_este_autenticado(): void
    {
        $user = $this->createNewUser();
        Sanctum::actingAs($user);

        $res = $this->getJson(self::PATH . 'check');

        $res->assertStatus(200);
        $res->assertJsonCount(10);
        $res->assertJson($this->getNewResourceUser($user, true));
        $this->assertNull($res->json()['token']);
    }

    public function test_cerrar_session_del_user(): void
    {
        Sanctum::actingAs($this->createNewUser());

        $res = $this->getJson(self::PATH . 'logout');

        $res->assertStatus(204);
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_cambiar_el_password_del_user(): void
    {
        $data = ['password' => 'Test-1234', 'password_confirmation' => 'Test-1234'];
        Sanctum::actingAs($this->createNewUser());
        $user = User::first();

        $res = $this->postJson(self::PATH . 'change/password', $data);
        $userUpdate = User::first();

        $this->assertNotEquals($user->password, $userUpdate->password);
        $res->assertStatus(200);
        $res->assertExactJson(['message' => __('The password has been changed successfully')]);
    }

    public function test_llamar_al_endpoint_restablecer_password(): void
    {
        $data = ['email' => 'user@email.com'];
        Sanctum::actingAs($this->createNewUser());

        $res = $this->postJson(self::PATH . 'recovery/password', $data);

        $res->assertStatus(200);
        $res->assertExactJson(['message' => __('In a few moments you will receive an email to reset your password. Check your mailbox')]);
    }

    public function test_email_restablecer_password(): void
    {
        $data = ['email' => 'user@email.com'];
        $user = $this->createNewUser();

        $mailable = (new RecoveryPasswordMail($user))->to($user->email);

        $mailable->assertTo($data['email']);
        $mailable->assertHasSubject(config('app.name') . ' - ' . __('Restore password'));
        $mailable->assertSeeInOrderInHtml([$user->nombre, config('app.DOMAIN_FRONTEND') . '/auth/reset/password/Bearer']);
    }

    public function test_llamar_al_endpoint_verificacion_usuario_ya_verificado(): void
    {
        Sanctum::actingAs($this->createNewUser());

        $res = $this->postJson(self::PATH_USER . 'verification/email/notification');

        $res->assertStatus(200);
        $res->assertExactJson(['message' => __('Email already verified')]);
    }

    public function test_llamar_al_endpoint_verificacion_usuario_no_verificado(): void
    {
        Sanctum::actingAs($this->createNewUser(false, false));

        $res = $this->postJson(self::PATH_USER . 'verification/email/notification');

        $res->assertStatus(200);
        $res->assertExactJson(['message' => __('Email forwarded successfully')]);
    }

    public function test_email_verificar_usuario(): void
    {
        $data = ['email' => 'user@email.com'];
        $url = config('app.DOMAIN_FRONTEND') . "/user/verification/email" . Str::random(10) . "&token=" . Str::random(10);
        $user = $this->createNewUser(false, false);

        $mailable = (new VerifiedMail($url))->to($user->email);

        $mailable->assertTo($data['email']);
        $mailable->assertHasSubject(config('app.name') . ' - ' . __('Verify email'));
        $mailable->assertSeeInHtml(config('app.DOMAIN_FRONTEND') . '/user/verification/email');
        $mailable->assertSeeInHtml('&token=');
    }

    public function test_verificar_usuario(): void
    {
        $data = ['email' => 'user@email.com'];
        $user = $this->createNewUser(false, false);
        Sanctum::actingAs($user);

        $res = $this->getJson(self::PATH_USER . 'verification/email/' . $user->id . '/' . sha1($data['email']));

        $this->assertNotNull($user->email_verified_at);
        $res->assertStatus(200);
        $res->assertExactJson(['message' => __('Email has been verified')]);
    }

    public function test_verificar_usuario_ya_verificado(): void
    {
        $data = ['email' => 'user@email.com'];
        $user = $this->createNewUser(false);
        $emailVerifiedAt = $user->email_verified_at;
        Sanctum::actingAs($user);

        $res = $this->getJson(self::PATH_USER . 'verification/email/' . $user->id . '/' . sha1($data['email']));

        $this->assertEquals($emailVerifiedAt, $user->email_verified_at);
        $res->assertStatus(200);
        $res->assertExactJson(['message' => __('Email already verified')]);
    }
}
