# Getting Started (Scratch Laravel)

## 1. Install Laravel

```bash
composer create-project laravel/laravel project
cd project
```

---

### Laravel - Initial Setup

```bash
composer install
npm install
php artisan key:generate
php artisan storage:link
```

---

### Laravel - Database Setup

.env

```env
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

```bash
php artisan migrate
```

---

### Laravel - Soft Deletes

Migration - 0001_01_02_000000_add_user_soft_deletes.php

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
```

Model - User.php

```php
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;
    // ...
}
```

---

### Laravel - Mailling Setup

.env

```env
# Development - Mailtrap
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=**********
MAIL_PASSWORD=**********
MAIL_ENCRYPTION=tls
```

---

### Laravel - Mailling Testing

Model - User.php

```php
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    // ...
}
```

Route - debug.php

```php
<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/debug/mail', function () {

    Mail::raw('Test Email', function ($message) {
        $message->to('exryze@gmail.com')
                ->subject('Mailtrap Test');
    });

    return "Mail sent!";
});

Route::get('/debug/mail/resend', function () {

    Mail::raw('Test Email', function ($message) {
        $message->to('exryze@gmail.com')
                ->subject('Mailtrap Test');
    });

    return "Mail sent!";
});
```

Route - web.php

```php
// ...
require __DIR__.'/debug.php';
```

---

### Laravel - Sanctum Setup (Optional)

```bash
php artisan install:api
```

Model - User.php

```php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    // ...
}
```

---

## 2. Install Filament

See: [Filament Installation](https://filamentphp.com/docs/5.x/introduction/installation)

```bash
composer require filament/filament:"^5.0"
php artisan filament:install --panels
php artisan filament:theme
php artisan filament:make-user
```

Model - User.php

```php
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
    public function canAccessPanel(Panel $panel): bool
    {
        // return $this->hasVerifiedEmail();
        return true;
    }
    // ...
}
```

---

### Filament - Avatar Setup (Optional)

See: [User's Avatar Setup](https://filamentphp.com/docs/5.x/users/overview#setting-up-user-avatars)

Migration - 0001_02_01_000000_add_user_avatar_url.php

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('avatar_url')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar_url');
        });
    }
};
```

Model - User.php

```php
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements HasAvatar
{
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null;
    }
    // ...
}
```

---

### Filament - Authentication (Optional)

See: [Filament Authentication](https://filamentphp.com/docs/5.x/users/multi-factor-authentication)

Migration - 0001_02_01_000001_add_user_email_authentication.php

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('has_email_authentication')->default(false)->after('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('has_email_authentication');
        });
    }
};
```

Migration - 0001_02_01_000002_add_user_2fa_authentication.php

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('app_authentication_secret')->nullable()->after('has_email_authentication');
            $table->text('app_authentication_recovery_codes')->nullable()->after('app_authentication_secret');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('app_authentication_secret');
            $table->dropColumn('app_authentication_recovery_codes');
        });
    }
};
```

Model - User.php

```php
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements HasEmailAuthentication, HasAppAuthentication, HasAppAuthenticationRecovery
{
    use InteractsWithAppAuthentication;
    use InteractsWithAppAuthenticationRecovery;
    use InteractsWithEmailAuthentication;

    public function hasEmailAuthentication(): bool
    {
        return $this->has_email_authentication;
    }

    public function toggleEmailAuthentication(bool $condition): void
    {
        $this->has_email_authentication = $condition;
        $this->save();
    }

    public function getAppAuthenticationSecret(): ?string
    {
        return $this->app_authentication_secret;
    }

    public function setAppAuthenticationSecret(?string $secret): void
    {
        $this->app_authentication_secret = $secret;
        $this->save();
    }

    public function getAppAuthenticationHolderName(): string
    {
        return $this->name;
    }
    // ...
}
```

---

### Plugin - Filament Breezy

See: [Filament Breezy](https://filamentphp.com/plugins/jeffgreco-breezy)

```bash
composer require jeffgreco13/filament-breezy
php artisan breezy:install
php artisan vendor:publish --tag="filament-breezy-views"
```

Filament - theme.css

```css
@source '../../../../vendor/jeffgreco13/filament-breezy/resources/**/*';
```

Model - User.php

```php
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;
    // ...

}
```

---

### Plugin - Filament Shield

See: [Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)

```bash
composer require bezhansalleh/filament-shield
php artisan vendor:publish --tag="filament-shield-config"
php artisan shield:setup
php artisan shield:super-admin
php artisan shield:generate
```

---

### Plugin - Env Editor

See: [Env Editor](https://filamentphp.com/plugins/geo-sot-env-editor)

```bash
composer require geo-sot/filament-env-editor
```

---

### Plugin - Curator

See: [Curator](https://filamentphp.com/plugins/awcodes-curator)

```bash
composer require awcodes/filament-curator
php artisan curator:install
php artisan vendor:publish --tag="curator-config"
```

Filament - theme.css

```css
@import "../../../../vendor/awcodes/filament-curator/resources/css/plugin.css";

@source '../../../../vendor/awcodes/filament-curator/resources/**/*.blade.php';
```

---

### Widget - Apex Charts

See: [Apex Charts](https://filamentphp.com/plugins/leandrocfe-apex-charts)

```bash
composer require leandrocfe/filament-apex-charts
```

---

### Action - CSV Export

See: [CSV Export](https://filamentphp.com/plugins/pxlrbt-excel)

```bash
composer require pxlrbt/filament-excel
```

---

### Field - Map Picker

See: [Map Picker](https://filamentphp.com/plugins/dotswan-map-picker)

```bash
composer require dotswan/filament-map-picker
```

---

## 3. Deploy

```bash
php artisan optimize
php artisan queue:work
npm run dev
php artisan serve
```

---
