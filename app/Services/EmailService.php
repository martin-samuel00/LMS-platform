<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    /**
     * Send transactional password reset email
     */
    public static function sendPasswordReset(User $user, string $resetUrl): bool
    {
        $resendKey = env('RESEND_API_KEY');
        $fromEmail = env('MAIL_FROM_ADDRESS', 'onboarding@resend.dev');
        $fromName = env('MAIL_FROM_NAME', 'Classroom Hub');

        $html = '
        <div style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif; max-width: 600px; margin: 0 auto; padding: 32px 20px; color: #0f172a;">
            <div style="text-align: center; margin-bottom: 28px;">
                <span style="font-size: 36px;">🎓</span>
                <h2 style="margin: 8px 0 0; color: #4f46e5; font-size: 22px;">Classroom Hub</h2>
            </div>
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 32px; box-shadow: 0 4px 12px rgba(0,0,0,0.04);">
                <h3 style="font-size: 19px; margin-top: 0; color: #0f172a;">Reset Your Password</h3>
                <p style="font-size: 14.5px; line-height: 1.6; color: #475569;">Hello ' . htmlspecialchars($user->name) . ',</p>
                <p style="font-size: 14.5px; line-height: 1.6; color: #475569;">You are receiving this email because we received a password reset request for your Classroom Hub account.</p>
                <div style="text-align: center; margin: 28px 0;">
                    <a href="' . $resetUrl . '" style="background: #4f46e5; color: #ffffff; padding: 13px 28px; border-radius: 10px; font-weight: 700; text-decoration: none; display: inline-block; font-size: 14.5px;">Reset Password &rarr;</a>
                </div>
                <p style="font-size: 13px; color: #64748b; line-height: 1.5;">This password reset link will expire in 60 minutes. If you did not request a password reset, no further action is required.</p>
                <hr style="border: none; border-top: 1px solid #f1f5f9; margin: 24px 0;">
                <p style="font-size: 12px; color: #94a3b8; word-break: break-all;">If you\'re having trouble clicking the button, copy and paste this URL into your browser:<br><a href="' . $resetUrl . '" style="color: #4f46e5;">' . $resetUrl . '</a></p>
            </div>
        </div>';

        // 1. Try sending via Resend HTTP API over standard HTTPS port 443
        if (!empty($resendKey)) {
            try {
                $response = Http::withToken($resendKey)
                    ->timeout(10)
                    ->post('https://api.resend.com/emails', [
                        'from' => "{$fromName} <{$fromEmail}>",
                        'to' => [$user->email],
                        'subject' => 'Reset Your Password - Classroom Hub',
                        'html' => $html,
                    ]);

                if ($response->successful()) {
                    return true;
                }
                Log::warning('Resend email API response: ' . $response->body());
            } catch (\Throwable $e) {
                Log::warning('Resend email API exception: ' . $e->getMessage());
            }
        }

        // 2. Try standard Laravel Mailer if configured
        if (config('mail.default') !== 'log' && !empty(config('mail.mailers.smtp.host'))) {
            try {
                Mail::html($html, function ($msg) use ($user, $fromEmail, $fromName) {
                    $msg->to($user->email, $user->name)
                        ->from($fromEmail, $fromName)
                        ->subject('Reset Your Password - Classroom Hub');
                });
                return true;
            } catch (\Throwable $e) {
                Log::warning('Laravel Mailer exception: ' . $e->getMessage());
            }
        }

        return false;
    }

    /**
     * Send transactional email verification message
     */
    public static function sendVerification(User $user, string $verifyUrl): bool
    {
        $resendKey = env('RESEND_API_KEY');
        $fromEmail = env('MAIL_FROM_ADDRESS', 'onboarding@resend.dev');
        $fromName = env('MAIL_FROM_NAME', 'Classroom Hub');

        $html = '
        <div style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif; max-width: 600px; margin: 0 auto; padding: 32px 20px; color: #0f172a;">
            <div style="text-align: center; margin-bottom: 28px;">
                <span style="font-size: 36px;">🎓</span>
                <h2 style="margin: 8px 0 0; color: #4f46e5; font-size: 22px;">Classroom Hub</h2>
            </div>
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 32px; box-shadow: 0 4px 12px rgba(0,0,0,0.04);">
                <h3 style="font-size: 19px; margin-top: 0; color: #0f172a;">Verify Your Email Address</h3>
                <p style="font-size: 14.5px; line-height: 1.6; color: #475569;">Hello ' . htmlspecialchars($user->name) . ',</p>
                <p style="font-size: 14.5px; line-height: 1.6; color: #475569;">Welcome to Classroom Hub! Please click the button below to verify your email address and unlock all platform capabilities.</p>
                <div style="text-align: center; margin: 28px 0;">
                    <a href="' . $verifyUrl . '" style="background: #10b981; color: #ffffff; padding: 13px 28px; border-radius: 10px; font-weight: 700; text-decoration: none; display: inline-block; font-size: 14.5px;">Verify Email Address &rarr;</a>
                </div>
                <p style="font-size: 13px; color: #64748b; line-height: 1.5;">If you did not create an account, no further action is required.</p>
                <hr style="border: none; border-top: 1px solid #f1f5f9; margin: 24px 0;">
                <p style="font-size: 12px; color: #94a3b8; word-break: break-all;">Button not working? Paste this link into your browser:<br><a href="' . $verifyUrl . '" style="color: #4f46e5;">' . $verifyUrl . '</a></p>
            </div>
        </div>';

        if (!empty($resendKey)) {
            try {
                $response = Http::withToken($resendKey)
                    ->timeout(10)
                    ->post('https://api.resend.com/emails', [
                        'from' => "{$fromName} <{$fromEmail}>",
                        'to' => [$user->email],
                        'subject' => 'Verify Your Email Address - Classroom Hub',
                        'html' => $html,
                    ]);

                if ($response->successful()) {
                    return true;
                }
                Log::warning('Resend verification API response: ' . $response->body());
            } catch (\Throwable $e) {
                Log::warning('Resend verification API exception: ' . $e->getMessage());
            }
        }

        if (config('mail.default') !== 'log' && !empty(config('mail.mailers.smtp.host'))) {
            try {
                Mail::html($html, function ($msg) use ($user, $fromEmail, $fromName) {
                    $msg->to($user->email, $user->name)
                        ->from($fromEmail, $fromName)
                        ->subject('Verify Your Email Address - Classroom Hub');
                });
                return true;
            } catch (\Throwable $e) {
                Log::warning('Laravel Mailer exception: ' . $e->getMessage());
            }
        }

        return false;
    }
}
