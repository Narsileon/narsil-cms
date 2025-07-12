<?php

#region USE

use App\Http\Forms\ConfirmPasswordForm;
use App\Http\Forms\ForgotPasswordForm;
use App\Http\Forms\LoginForm;
use App\Http\Forms\RegisterForm;
use App\Http\Forms\ResetPasswordForm;
use App\Http\Forms\SiteForm;
use App\Http\Forms\SiteGroupForm;
use App\Http\Forms\TwoFactorChallengeForm;
use App\Models\Site;
use App\Models\SiteGroup;

#endregion

return [
    'confirm-password'     => ConfirmPasswordForm::class,
    'forgot-password'      => ForgotPasswordForm::class,
    'login'                => LoginForm::class,
    'register'             => RegisterForm::class,
    'reset-password'       => ResetPasswordForm::class,
    'two-factor-challenge' => TwoFactorChallengeForm::class,

    Site::TABLE      => SiteForm::class,
    SiteGroup::TABLE => SiteGroupForm::class,
];
