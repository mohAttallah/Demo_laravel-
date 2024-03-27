<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Illuminate\Support\Facades\Log;
use App\Mail\ConfirmEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Str; 
class AuthController extends Controller
{   
public function generateJwt() {
   $key = bin2hex(random_bytes(32)); 
    $config = \Lcobucci\JWT\Configuration::forSymmetricSigner(
        new \Lcobucci\JWT\Signer\Hmac\Sha256(),
        \Lcobucci\JWT\Signer\Key\InMemory::plainText($key) 
    );

    $now   = new \DateTimeImmutable();
    $user = Auth::user(); 

    $token = $config->builder()
                    ->issuedBy('your_issuer') 
                    ->permittedFor('your_audience') 
                    ->identifiedBy('4f1g23a12aa', true) 
                    ->issuedAt($now)
                    ->canOnlyBeUsedAfter($now->modify('+1 minute'))
                    ->expiresAt($now->modify('+1 hour'))
                    ->withClaim('userId', $user->id) // Use the user's id
                    ->withClaim('email', $user->email) // Use the user's email
                    ->getToken($config->signer(), $config->signingKey());

    return $token->toString();  
}
public function signup(Request $request)
{
    $verificationCode = Str::random(6);
    $user = new User;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->verification_code = $verificationCode;  
    $user->save();

    Auth::login($user); // Log in the user

    $token = $this->generateJwt();
    // Mail::to($user->email)->send(new ConfirmEmail());
    // $user->sendEmailVerificationNotification();
    Mail::to($user->email)->send(new ConfirmEmail($user, $verificationCode));


    return response()->json([
        'token' => $token,
        'user' => $user 
    ], 201);
}

public function toMail($notifiable)
{
    $verificationUrl = url("/verify-email?code={$this->verificationCode}");

    return (new MailMessage)
        ->subject('Verify Your Email Address')
        ->line('Please click the button below to verify your email address.')
        ->action('Verify Email Address', $verificationUrl)
        ->line('If you did not create an account, no further action is required.');
}


public function verifyEmail(Request $request)
{
    $request->validate([
        'email' => 'required|string|email',
        'code' => 'required|string',
    ]);

    $user = User::where('email', $request->email)
                ->where('verification_code', $request->code)
                ->first();

    if ($user) {
        $user->email_verified_at = now();
        $user->verification_code = null; 
        $user->save();

        return response()->json(['message' => 'Email verified successfully.']);
    }

    return response()->json(['error' => 'Invalid verification code.'], 400);
}


public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    $user->email_verified_at = null;
    $user->save();

    $token = $this->generateJwt();
    $user = Auth::user();

        Mail::to($user->email)->send(new ConfirmEmail());
    return response()->json([
        'token' => $token,
        'user' => $user 
    ], 201);
}
}