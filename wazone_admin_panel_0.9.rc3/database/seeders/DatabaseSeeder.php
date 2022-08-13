<?php

namespace Database\Seeders;

use App\Models\Autoreply;
use App\Models\User;
use App\Models\Package;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // table users seeder
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'phone' => '16264838489',
                'password'=>Hash::make('password'),
                'role' => 'admin',
                'package_id' => 1,
                'trial_period' => 125,
                'billing_interval' => 'monthly',
                'billing_start' => now(),
                'billing_end' => Carbon::now()->addYears(1),
            ],
            [
                'name' => 'bank',
                'email' => 'bank@bank.com',
                'email_verified_at' => now(),
                'phone' => '18184838489',
                'password'=>Hash::make('password'),
                'role' => 'admin',
                'package_id' => 1,
                'trial_period' => 125,
                'billing_interval' => 'monthly',
                'billing_start' => now(),
                'billing_end' => Carbon::now()->addYears(1),
            ],
            [
                'name' => 'demo',
                'email' => 'demo@demo.com',
                'email_verified_at' => now(),
                'phone' => '13235609448',
                'password'=>Hash::make('password'),
                'role' => 'user',
                'package_id' => 2,
                'trial_period' => 125,
                'billing_interval' => 'monthly',
                'billing_start' => now(),
                'billing_end' => Carbon::now()->addYears(1),
            ],
        ];
        foreach ($users as $user) {
            if (User::where('name', '=', $user['name'])->count() == 0) {
              User::insert($user);
            }
        }

        // table autoreplies seeder
        $autoreplies = [
            [
                'user_id' => 1,
                'sender' => 'all',
                'keyword' => 'info',
                'match_percent' => 100,
                'response' => 'Hi {name}! This is the main menu of autoreply test response.  Do you want to continue?',
                'data' => '[{"index":1,"quickReplyButton":{"displayText":"YES","id":"yesContinue"}},{"index":2,"quickReplyButton":{"displayText":"NO","id":"noContinue"}}]',
            ],
            [
                'user_id' => 1,
                'sender' => 'all',
                'keyword' => 'yesContinue',
                'match_percent' => 100,
                'response' => 'Great! Now I can show you a little sample of how to create a chat bot.  You can create as many keywords and responses with buttons!  Can I show you how?',
                'data' => '[{"index":1,"quickReplyButton":{"displayText":"YES","id":"yesShow"}},{"index":2,"quickReplyButton":{"displayText":"NO","id":"noShow"}}]',
            ],
            [
                'user_id' => 1,
                'sender' => 'all',
                'keyword' => 'noContinue',
                'match_percent' => 100,
                'response' => 'I hope to see you again soon. In the mean time, you can check our website or give us a call anytime.',
                'data' => '[{"index":1,"urlButton":{"displayText":"Visit website","url":"https://visimisi.net"}},{"index":2,"callButton":{"displayText":"Call now!","phoneNumber":"+13235584948"}}]',
            ],
            [
                'user_id' => 1,
                'sender' => 'all',
                'keyword' => 'yesShow',
                'match_percent' => 100,
                'response' => 'Please go to "Autoreply menu" and see how this chat bot is created.   Please do not hesitate to call us anytime if you have any question.  We are open from 10:00 to 20:00.  Hope to see you again soon!',
                'data' => '[{"index":1,"callButton":{"displayText":"Call now!","phoneNumber":"+13235674948"}},{"index":2,"quickReplyButton":{"displayText":"Main menu","id":"test"}}]',
            ],
            [
                'user_id' => 1,
                'sender' => 'all',
                'keyword' => 'noShow',
                'match_percent' => 100,
                'response' => 'Maybe we can chat again soon.  Please check our website',
                'data' => '[{"index":1,"urlButton":{"displayText":"Visit website","url":"https://visimisi.net"}},{"index":2,"quickReplyButton":{"displayText":"Main menu","id":"test"}}]',
            ],
            [
                'user_id' => 3,
                'sender' => 'all',
                'keyword' => 'info',
                'match_percent' => 100,
                'response' => 'Hi {name}! This is the main menu of autoreply test response.  Do you want to continue?',
                'data' => '[{"index":1,"quickReplyButton":{"displayText":"YES","id":"yesContinue"}},{"index":2,"quickReplyButton":{"displayText":"NO","id":"noContinue"}}]',
            ],
            [
                'user_id' => 3,
                'sender' => 'all',
                'keyword' => 'yesContinue',
                'match_percent' => 100,
                'response' => 'Great! Now I can show you a little sample of how to create a chat bot.  You can create as many keywords and responses with buttons!  Can I show you how?',
                'data' => '[{"index":1,"quickReplyButton":{"displayText":"YES","id":"yesShow"}},{"index":2,"quickReplyButton":{"displayText":"NO","id":"noShow"}}]',
            ],
            [
                'user_id' => 3,
                'sender' => 'all',
                'keyword' => 'noContinue',
                'match_percent' => 100,
                'response' => 'I hope to see you again soon. In the mean time, you can check our website or give us a call anytime.',
                'data' => '[{"index":1,"urlButton":{"displayText":"Visit website","url":"https://visimisi.net"}},{"index":2,"callButton":{"displayText":"Call now!","phoneNumber":"+13235584948"}}]',
            ],
            [
                'user_id' => 3,
                'sender' => 'all',
                'keyword' => 'yesShow',
                'match_percent' => 100,
                'response' => 'Please go to "Autoreply menu" and see how this chat bot is created.   Please do not hesitate to call us anytime if you have any question.  We are open from 10:00 to 20:00.  Hope to see you again soon!',
                'data' => '[{"index":1,"callButton":{"displayText":"Call now!","phoneNumber":"+13235674948"}},{"index":2,"quickReplyButton":{"displayText":"Main menu","id":"test"}}]',
            ],
            [
                'user_id' => 3,
                'sender' => 'all',
                'keyword' => 'noShow',
                'match_percent' => 100,
                'response' => 'Maybe we can chat again soon.  Please check our website',
                'data' => '[{"index":1,"urlButton":{"displayText":"Visit website","url":"https://visimisi.net"}},{"index":2,"quickReplyButton":{"displayText":"Main menu","id":"test"}}]',
            ],
        ];
        foreach ($autoreplies as $autoreply) {
            if (Autoreply::where('keyword', '=', $autoreply['keyword'])->count() == 0) {
                Autoreply::insert($autoreply);
            }
        }

        // table packages seeder
        $packages = [
            [
                'name' => 'super',
                'description' => 'Super Package',
                'rate_monthly' => 0,
                'rate_yearly' => 0,
                'max_outbox' => 0,
                'max_device' => 0,
                'max_template' => 0,
                'max_phonebook' => 0,
            ],
            [
                'name' => 'trial',
                'description' => 'Trial Package',
                'rate_monthly' => 0,
                'rate_yearly' => 0,
                'max_outbox' => 100,
                'max_device' => 1,
                'max_template' => 1,
                'max_phonebook' => 1,
            ],
        ];
        foreach ($packages as $package) {
            if (Package::where('name', '=', $package['name'])->count() == 0) {
                Package::insert($package);
            }
        }

        // table settings seeder
        $settings = [
            [
                'key'   => 'bulkMsgDelay',
                'value' => 2,
            ],
            [
                'key'   => 'currencyCode',
                'value' => 'USD',
            ],
            [
                'key'   => 'encType',
                'value' => 'ssl',
            ],
            [
                'key'   => 'logoUrl',
                'value' => url('/app-assets/images/logo/logo.png'),
            ],
            [
                'key'   => 'mpAccessToken',
                'value' => '',
            ],
            [
                'key'   => 'mpPublicKey',
                'value' => '',
            ],
            [
                'key'   => 'numOfButtons',
                'value' => 2,
            ],
            [
                'key'   => 'orderID',
                'value' => '',
            ],
            [
                'key'   => 'paypalClientId',
                'value' => 'AfPi2XnSujC3xLB5X7otIojy4-v2uKY4Vena9yDtie_d1Y-PrA1_AmBZua9gF7Y731TpQxO7ZqtKvD08',
            ],
            [
                'key'   => 'razorpayKeyId',
                'value' => 'rzp_test_1LEOeLAiCeEjfT',
            ],
            [
                'key'   => 'topupValues',
                'value' => '5, 10, 20',
            ],
            [
                'key'   => 'trialPeriod',
                'value' => 30,
            ],
            [
                'key'   => 'waVerification',
                'value' => 'true',
            ],
            [
                'key'   => 'waVerificationMsg',
                'value' => 'Hi *{name}*! This is a verification process because you have just registered a new account on *{appurl}*. If you did not register an account, please ignore this message. If you did, please click the button below to verify. Thank you, *-{appname}-*',
            ],
        ];
        foreach ($settings as $setting) {
            if (Setting::where('key', '=', $setting['key'])->count() == 0) {
                Setting::insert($setting);
            }
        }
        Setting::updateOrInsert(['key' => 'restApi'],['value' => 'P2NvbnN1bWVyX2tleT1ja19kMGVhMDFiZDAzNmRjMzA0MWViMjlmNDEyYjNjOTZlNzY3ZGJiYzhhJmNvbnN1bWVyX3NlY3JldD1jc18yYjNiOTVkZWY0MWM5YTNlYmU2NmZhMDI0NmFlYjNmYjg3NGViYjdj']);
    }
}
