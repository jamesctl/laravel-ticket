<?php

namespace Database\Seeders;

use App\Models\MailTemplate;
use Illuminate\Database\Seeder;
use App\Http\Traits\Translation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class SettingUpdateEmailTemplateSeeder extends Seeder {
    use Translation;

    /**
     * Run the database seeds.
     * php artisan db:seed --class=SettingUpdateEmailTemplateSeeder
     * @return void
     */
    public function run() {
        $contentDataType = Schema::getColumnType('mail_template', 'content');
        if ($contentDataType === 'string') {
            Schema::table('mail_template', function (Blueprint $table) {
                $table->text('content')->change();
            });
        }

        // Change Column Mail Key to Not Unique
        // $indexes = DB::connection()->getDoctrineSchemaManager()->listTableIndexes('mail_template');
        // if (!empty($indexes)) {
        //     foreach ($indexes as $index_name => $index_data) {
        //         if (!$index_data->isPrimary() && $index_data->isUnique()) {
        //             $columns = $index_data->getColumns();
        //             foreach ($columns as $column) {
        //                 if ($column === 'mail_key') {
        //                     Schema::table('mail_template', function (Blueprint $table) {
        //                         $table->string('mail_key')->unique(false)->change();
        //                     });
        //                 }
        //             }
        //         }
        //     }
        // }

        if (MailTemplate::count() === 0) {
            $emailTemplatesUpdateData =
            [
                // English
                [
                    'title' => 'Account Registration Confirmation',
                    'mail_key' => 'when_sending_otp_during_account_registration',
                    'content' => "<div>Dear user,</div><div><br></div><div>Thank you for registering an account with Lovely-talks.com. To activate your account, please enter the confirmation code (OTP) provided below.</div><div><br></div><div>Confirmation Code: {{confirmationCode}}</div><div><br></div><div>Please enter the above confirmation code along with the email address you used for registration to complete the account activation process.</div><div><br></div><div>If you have any questions or need further assistance, please don't hesitate to contact us.</div><div><br></div><div>Best regards, Lovely-talks.com Support Team</div>",
                    'locale' => 'en'
                ], [
                    'title' => 'Teacher Account Registration Request',
                    'mail_key' => 'when_a_teacher_registers_a_new_account',
                    'content' => "
                    <p>Thank you for registering a new account with Lovely-talks. We have received your application for a teacher account and will now proceed with the account approval process. Once approved, you will be able to access our system.</p>
                    <p>Information provided during registration:</p>
                    <p>Name: {{teacherName}}</p>
                    <p>Email Address: {{email}}</p>
                    <p>Please allow some time for the account approval process. We will contact you separately once the approval is complete.</p>
                    <p>If you have any questions or need further assistance, please feel free to contact us.</p>
                    <p>Best regards, Lovely-talks.com Support Team</p>
                ",
                    'locale' => 'en'
                ], [
                    'title' => 'Password Reset Code Notification',
                    'mail_key' => 'when_sending_otp_for_password_reset',
                    'content' => "
                    <p>We have received your password reset request. To reset your password, please enter the reset code (OTP) provided below.</p>
                    <p>Reset Code: {{resetCode}}</p>
                    <p>Please enter the above reset code to set a new password. Please note that this reset code will expire after a certain period, so please use it promptly.</p>
                    <p>If you have any questions or need further assistance, please don't hesitate to contact us.</p>
                    <p>Best regards, Lovely-talks.com Support Team</p>
                ",
                    'locale' => 'en'
                ], [
                    'title' => 'Teacher Just updated KYC Information',
                    'mail_key' => 'when_a_teacher_updates_their_kyc_information_send_to_admin',
                    'content' => '
                    <p>Teacher just updated KYC</p>
                    <p>Name: {{teacherName}}</p>
                    <p>Please visit the link and confirm: {{link}}</p>
                ',
                    'locale' => 'en'
                ], [
                    'title' => 'Subscription Confirmation - {{planName}}',
                    'mail_key' => 'when_a_user_subscribes_to_a_plan_send_to_user',
                    'content' => "
                    <p>Thank you for choosing Lovely-talks.com and subscribing to our services.</p>
                    <p>Subscription Details: </p>
                    <p>Plan Name: {{planName}}</p>
                    <p>Payment Date: {{paymentDate}}</p>
                    <p>Amount: {{amount}}</p>
                    <p>Moving forward, the specified amount will be automatically charged at regular intervals. If you wish to make any changes to your plan or cancel the subscription, please adjust the settings in your account's \"My Page\" section.</p>
                    <p>If you have any questions or need assistance, please don't hesitate to contact us.</p>
                    <p>Best regards, Lovely-talks.com Support Team</p>
                ",
                    'locale' => 'en'
                ],
                [
                    'title' => '[ADMIN] Subscription Confirmation - {{planName}}',
                    'mail_key' => 'when_a_user_subscribes_to_a_plan_send_to_admin',
                    'content' => "
                    <p>Thank you for choosing Lovely-talks.com and subscribing to our services.</p>
                    <p>Subscription Details: </p>
                    <p>Plan Name: {{planName}}</p>
                    <p>Payment Date: {{paymentDate}}</p>
                    <p>Amount: {{amount}}</p>
                    <p>Moving forward, the specified amount will be automatically charged at regular intervals. If you wish to make any changes to your plan or cancel the subscription, please adjust the settings in your account's \"My Page\" section.</p>
                    <p>If you have any questions or need assistance, please don't hesitate to contact us.</p>
                    <p>Best regards, Lovely-talks.com Support Team</p>
                ",
                    'locale' => 'en'
                ], [
                    'title' => 'Automatic Renewal Notification',
                    'mail_key' => 'when_the_system_auto_charges',
                    'content' => "
                    <p>Thank you for your continued support and for using Lovely-talks.com. </p>
                    <p>We would like to inform you about the payment for your subscription. The following amount has been automatically deducted from your registered credit card or PayPal account:</p>
                    <p>Amount: {{amount}}</p>
                    <p>Payment Date: {{paymentDate}}</p>
                    <p>If you have any questions or concerns, please feel free to contact us.</p>
                    <p>Best regards, Lovely-talks.com Support Team</p>
                ",
                    'locale' => 'en'
                ],
                [
                    'title' => '[ADMIN] Automatic Renewal Notification',
                    'mail_key' => 'when_the_system_auto_charges_send_to_admin',
                    'content' => "
                    <p>Thank you for your continued support and for using Lovely-talks.com. </p>
                    <p>We would like to inform you about the payment for your subscription. The following amount has been automatically deducted from your registered credit card or PayPal account:</p>
                    <p>Amount: {{amount}}</p>
                    <p>Payment Date: {{paymentDate}}</p>
                    <p>If you have any questions or concerns, please feel free to contact us.</p>
                    <p>Best regards, Lovely-talks.com Support Team</p>
                ",
                    'locale' => 'en'
                ], [
                    'title' => 'Coin Purchase Confirmation',
                    'mail_key' => 'when_sending_an_email_for_coin_purchase',
                    'content' => "
                    <p>We are pleased to inform you that your coin purchase has been successfully completed. Here are the details of your purchase:</p>
                    <p>Purchase Details:</p>
                    <p>Purchase Date: {{purchaseDate}}</p>
                    <p>Number of Coins Purchased: {{numberOfCoinsPurchased}}</p>
                    <p>Payment Amount: {{paymentAmount}}</p>
                    <p>Expiration Date: {{untilNextRenewal}}</p>
                    <p>The coins you have purchased can be used for tipping within Lovely-talks.com.</p>
                    <p>If you have any questions or need assistance, please feel free to contact us.</p>
                    <p>Best regards, Lovely-talks.com Support Team</p>
                ",
                    'locale' => 'en'
                ],
                [
                    'title' => '[ADMIN] Coin Purchase Confirmation',
                    'mail_key' => 'when_sending_an_email_for_coin_purchase_send_to_admin',
                    'content' => "
                    <p>We are pleased to inform you that your coin purchase has been successfully completed. Here are the details of your purchase:</p>
                    <p>Purchase Details:</p>
                    <p>Purchase Date: {{purchaseDate}}</p>
                    <p>Number of Coins Purchased: {{numberOfCoinsPurchased}}</p>
                    <p>Payment Amount: {{paymentAmount}}</p>
                    <p>Expiration Date: {{untilNextRenewal}}</p>
                    <p>The coins you have purchased can be used for tipping within Lovely-talks.com.</p>
                    <p>If you have any questions or need assistance, please feel free to contact us.</p>
                    <p>Best regards, Lovely-talks.com Support Team</p>
                ",
                    'locale' => 'en'
                ], [
                    'title' => 'KYC Information Update Confirmation',
                    'mail_key' => 'when_a_teacher_updates_their_kyc_information_send_to_teacher',
                    'content' => "
                    <p>Thank you for updating your KYC information. The provided information has been successfully registered. We will notify you again once the KYC information is reviewed and approved.</p>
                    <p>If you have any questions or need further assistance, please feel free to contact us.</p>
                    <p>Best regards, Lovely-talks.com Support Team</p>
                ",
                    'locale' => 'en'
                ], [
                    'title' => 'Urgent Withdrawal Request - Approval Requested',
                    'mail_key' => 'when_a_teacher_requests_an_urgent_withdrawal',
                    'content' => "
                    <p>We have received an urgent withdrawal request from a teacher. Please find the details of the request below:</p>
                    <p>Request Details:</p>
                    <p>Teacher's Name: {{teacherName}}</p>
                    <p>Requested Amount: {{amount}}</p>
                    <p>Reason: {{reason}}</p>
                    <p>We kindly request your approval or rejection of this request. The withdrawal will not be processed until we receive your response.</p>
                    <p>If you have any questions or need further information, please feel free to contact us.</p>
                    <p>Best regards, Lovely-talks.com Support Team</p>
                ",
                    'locale' => 'en'
                ], [
                    'title' => 'Urgent Withdrawal Request Result Notification',
                    'mail_key' => 'when_the_administrator_approves_or_rejects_a_teachers_urgent_withdrawal_request',
                    'content' => "
                    <p>We would like to inform you of the result of the urgent withdrawal request that was submitted earlier.</p>
                    <p>Request Result:</p>
                    <p>Result: {{status}}</p>
                    <p>Approval Date and Time: {{date}}</p>
                    <p>Approved Amount: {{approveAmount}}</p>
                    <p>If you have any questions or need further assistance, please feel free to contact us.</p>
                    <p>Best regards, Lovely-talks.com Support Team</p>
                ",
                    'locale' => 'en'
                ], [
                    'title' => 'Plan Purchase Confirmation - {{planName}}',
                    'mail_key' => 'when_a_teacher_purchases_a_plan',
                    'content' => "
                    <p>We are pleased to inform you that your plan purchase has been successfully completed. Here are the details of the plan you have purchased.</p>
                    <p>Purchase Details:</p>
                    <p>Plan Name: {{planName}}</p>
                    <p>Purchase Date and Time: {{date}}</p>
                    <p>Payment Amount: {{paymentAmount}}</p>
                    <p>If you have any questions or need further assistance, please feel free to contact us.</p>
                    <p>Best regards, Lovely-talks.com Support Team</p>
                ",
                    'locale' => 'en'
                ], [
                    'title' => 'You received {{amountCoin}} coins from a student',
                    'mail_key' => 'when_a_student_bonus_coins_to_teacher',
                    'content'  => "
                    <p>Hi, {{teacherName}}</p>
                    <p>{{studentName}} has sent to you {{amountCoin}} coins.</p>
                    <p><a href='{{accountLink}}' target='_blank' style='cursor:pointer'>Please go to your account to see detail</a></p>
                ",
                'locale' => 'en'
                ], [
                'title' => 'Thank you for always using Lovely-talks.',
                'mail_key' => 'when_a_user_canceled_subscription',
                'content' => "
                    <p>Your plan has been canceled.</p>
                    <p>Username: {{userName}}</p>
                    <p>Plan name: {{planName}}</p>
                    <p>Expiry date: {{expiryDate}}</p>
                    <p>Thank you for your usage. 
                    If you have any concerns, please kindly inform us at support@lovely-talks.com.</p>
                    <p>Best regards,<br/>
                    Lovely-talks.com Support Team</p>
                ",
                'locale' => 'en'
                ], [
                'title' => 'Cancellation notice.',
                'mail_key' => 'when_a_user_canceled_subscription_to_admin',
                'content' => "
                    <p>A subscription plan has been canceled.</p>
                    <p>Username: {{userName}}</p>
                    <p>Plan name: {{planName}}</p>
                    <p>Expiry date: {{expiryDate}}</p>
                    <p>Lovely-talks.com Support team.</p>
                ",
                    'locale' => 'en'
                ],
                [
                    'locale' => 'en',
                    "title" => "Request for Lesson: {{level}}",
                    "mail_key" => 'student_lesson_request_email',
                    'content' => '
                        <p>Dear {{teacherName}},</p>
                        
                        <p>I hope this message finds you well. I am writing to request an English lesson on {{time}}. I am eager to improve my English skills and believe that your expertise would greatly benefit me.</p>
                        
                        <p>If you are available at the mentioned date and time, kindly approve by clicking the "Accept" button. If not, please feel free to suggest an alternative time that suits your schedule.</p>
                        
                        <p>Thank you very much for considering my request. I look forward to hearing from you soon.</p>
                        
                        <p>Best regards,</p>
                        <p>{{studentName}}</p>
                        <div style="display: flex; justify-content: space-between">
                        <a href="{{acceptLink}}" style="cursor: pointer; background: green; padding: 0.5rem 1rem; color: white; border: none">
                            Accept
                            </a
                        >
                        <a href="{{cancelLink}}" style="cursor: pointer; background: red; padding: 0.5rem 1rem; color: white; border: none">Cancel</a>
                        <a href="{{changeTimeLink}}" style="cursor: pointer; background: orange; padding: 0.5rem 1rem; color: white; border: none">Change time</a>
                        </div>
                    '
                ],
                [
                    'locale' => 'en',
                    'title' => 'Confirmation of English Lesson on {{time}}',
                    'mail_key' => 'teacher_accept_lesson_request',
                    'content' => "
                    <p>Dear {{studentName}},</p>

                    I am pleased to inform you that I have approved your request for an English lesson on {{time}}. I am looking forward to our session and am confident that we will make great progress together.
                    
                    Please feel free to reach out if you have any questions or specific topics you would like to focus on during our lesson.
                    
                    Thank you for choosing me as your English teacher. See you soon!
                    
                    Best regards,
                    {{teacherName}}"
                ],
                [
                    'locale' => 'en',
                    'title' => 'Regret: Unable to Schedule English Lesson for {{time}}',
                    'mail_key' => 'teacher_decline_lesson_request',
                    'content' => "
                    <p>Dear {{studentName}},</p>
                    
                    <p>Thank you for your request for an English lesson on {{time}}.</p>
                    
                    <p>Unfortunately, due to scheduling conflicts, I regret to inform you that I am unable to accommodate the lesson at the requested time.</p>
                    
                    <p>I apologize for any inconvenience this may cause. I would be happy to discuss alternative dates for our lesson.</p>
                    
                    <p>Thank you for your understanding.</p>
                    
                    <p>Best regards,<br>{{teacherName}}</p>"
                ],
                [
                    'locale' => 'en',
                    'title' => 'Request to Change English Lesson Time',
                    'mail_key' => 'teacher_change_lesson_request_time',
                    'content' => "
                    <p>Dear {{teacherName}},</p>
                    
                    <p>I hope this email finds you well.</p>
                    
                    <p>I am writing to request a change in the scheduled time for our upcoming English lesson. Due to unforeseen circumstances, I am unable to attend the lesson at the originally scheduled time.</p>
                    
                    <p>Could we please reschedule the lesson to a new time that is convenient for both of us? I am available on [provide alternative dates and times], and I hope we can find a suitable time slot.</p>
                    
                    <p>I apologize for any inconvenience this may cause, and I appreciate your understanding and flexibility.</p>
                    
                    <p>Thank you for your attention to this matter.</p>
                    
                    <p>Best regards,<br>{{studentName}}</p>"
                ],

                // Japan
                [
                    'title' => 'アカウント登録の確認コードをお知らせします ',
                    'mail_key' => 'when_sending_otp_during_account_registration',
                    'content' => "
                    <p>親愛なるユーザー様、</p>
                    <p>英会話Zoomシステムへのアカウント登録を受け付けました。アカウントの有効化には確認コード（OTP）の入力が必要です。</p>
                    <p>確認コード：{{confirmationCode}}</p>
                    <p>ご登録いただいたメールアドレスと一緒に上記の確認コードを入力して、アカウントの有効化手続きを完了させてください。</p>
                    <p>何かご不明な点やご質問がございましたら、お気軽にお問い合わせください。</p>
                ",
                    'locale' => 'ja'
                ], [
                    'title' => 'アカウント登録完了のお知らせ ',
                    'mail_key' => 'when_a_teacher_registers_a_new_account',
                    'content' => "
                    <p>親愛なる先生、</p>
                    <p>このたびは英会話Zoomシステムへのアカウント登録をありがとうございます。ご登録いただいた情報を確認の上、アカウントの承認手続きを行います。承認完了後、本システムをご利用いただけます。</p>
                    <p>ご登録いただいた情報：</p>
                    <p>名前: {{teacherName}}</p>
                    <p>メールアドレス: {{email}}</p>
                    <p>アカウントの承認が完了するまで、しばらくお待ちください。承認が完了しましたら、別途ご連絡いたします。</p>
                ",
                    'locale' => 'ja'
                ], [
                    'title' => 'パスワードのリセットコードをお知らせします ',
                    'mail_key' => 'when_sending_otp_for_password_reset',
                    'content' => "
                    <p>親愛なるユーザー様、</p>
                    <p>パスワードのリセットを受け付けました。パスワードをリセットするには、リセットコード（OTP）の入力が必要です。</p>
                    <p>リセットコード：{{resetCode}}</p>
                    <p>上記のリセットコードを入力して、新しいパスワードを設定してください。このリセットコードは一定時間で失効しますので、お早めにご利用ください。</p>
                    <p>何かご不明な点やご質問がございましたら、お気軽にお問い合わせください。</p>
                    <p>敬具 英会話Zoomシステムサポートチーム</p>
                ",
                    'locale' => 'ja'
                ], [
                    'title' => '教師が KYC 情報を更新しました',
                    'mail_key' => 'when_a_teacher_updates_their_kyc_information_send_to_admin',
                    'content' => '
                    <p>教師が KYC を更新しました</p>
                    <p>名前： {{teacherName}}</p>
                    <p>リンクにアクセスして以下を確認してください。 {{link}}</p>
                ',
                    'locale' => 'ja'
                ], [
                    'title' => 'プランの定期購読完了のお知らせ - {{planName}}',
                    'mail_key' => 'when_a_user_subscribes_to_a_plan_send_to_user',
                    'content' => "
                    <p>親愛なるユーザー様、</p>
                    <p>ご利用いただきありがとうございます。お客様が選択されたプランの定期購読が正常に完了しました。以下に定期購読の詳細をご案内いたします。</p>
                    <p>定期購読の詳細：</p>
                    <p>プラン名: {{planName}}</p>
                    <p>支払い日: {{paymentDate}}</p>
                    <p>金額: {{amount}}</p>
                    <p>今後、指定の期間ごとに自動的にお支払いが行われます。プランの更新や解約をご希望の場合は、マイアカウントページより設定変更を行ってください。</p>
                    <p>何かご質問やお困りの点がございましたら、お気軽にお問い合わせください。</p>
                    <p>敬具</p>
                ",
                    'locale' => 'ja'
                ],
                [
                    'title' => '[ADMIN] プランの定期購読完了のお知らせ - {{planName}}',
                    'mail_key' => 'when_a_user_subscribes_to_a_plan_send_to_admin',
                    'content' => "
                    <p>親愛なるユーザー様、</p>
                    <p>ご利用いただきありがとうございます。お客様が選択されたプランの定期購読が正常に完了しました。以下に定期購読の詳細をご案内いたします。</p>
                    <p>定期購読の詳細：</p>
                    <p>プラン名: {{planName}}</p>
                    <p>支払い日: {{paymentDate}}</p>
                    <p>金額: {{amount}}</p>
                    <p>今後、指定の期間ごとに自動的にお支払いが行われます。プランの更新や解約をご希望の場合は、マイアカウントページより設定変更を行ってください。</p>
                    <p>何かご質問やお困りの点がございましたら、お気軽にお問い合わせください。</p>
                    <p>敬具</p>
                ",
                    'locale' => 'ja'
                ], [
                    'title' => '自動課金のお知らせ ',
                    'mail_key' => 'when_the_system_auto_charges',
                    'content' => "
                    <p>ご利用いただきありがとうございます。お支払いについてご案内いたします。以下の金額が、ご登録いただいたクレジットカードから自動的に引き落とされます。</p>
                    <p>金額: {{amount}}</p>
                    <p>支払い日: {{paymentDate}}</p>
                    <p>何かご不明な点やご質問がございましたら、お気軽にお問い合わせください。</p>
                    <p>敬具 英会話Zoomシステムサポートチーム</p>
                ",
                    'locale' => 'ja'
                ],
                [
                    'title' => '[ADMIN] 自動課金のお知らせ ',
                    'mail_key' => 'when_the_system_auto_charges_send_to_admin',
                    'content' => "
                    <p>ご利用いただきありがとうございます。お支払いについてご案内いたします。以下の金額が、ご登録いただいたクレジットカードから自動的に引き落とされます。</p>
                    <p>金額: {{amount}}</p>
                    <p>支払い日: {{paymentDate}}</p>
                    <p>何かご不明な点やご質問がございましたら、お気軽にお問い合わせください。</p>
                    <p>敬具 英会話Zoomシステムサポートチーム</p>
                ",
                    'locale' => 'ja'
                ], [
                    'title' => 'コインの購入完了のお知らせ ',
                    'mail_key' => 'when_sending_an_email_for_coin_purchase',
                    'content' => "
                    <p>自動課金のお知らせ </p>
                    <p>親愛なるユーザー様、</p>
                    <p>コインの購入が完了しました。ご購入いただいたコインの詳細は以下の通りです。</p>
                    <p>購入詳細：</p>
                    <p>購入日時: {{purchaseDate}}</p>
                    <p>購入コイン数: {{numberOfCoinsPurchased}}</p>
                    <p>支払い金額: {{paymentAmount}}</p>
                    <p>ご購入いただいたコインは、英会話Zoomシステム内での投げ銭やその他のサービスにご利用いただけます。</p>
                    <p>ご不明な点やご質問がございましたら、お気軽にお問い合わせください。</p>
                    <p>敬具 英会話Zoomシステムサポートチーム</p>
                ",
                    'locale' => 'ja'
                ],
                [
                    'title' => '[ADMIN] コインの購入完了のお知らせ ',
                    'mail_key' => 'when_sending_an_email_for_coin_purchase_send_to_admin',
                    'content' => "
                    <p>自動課金のお知らせ </p>
                    <p>親愛なるユーザー様、</p>
                    <p>コインの購入が完了しました。ご購入いただいたコインの詳細は以下の通りです。</p>
                    <p>購入詳細：</p>
                    <p>購入日時: {{purchaseDate}}</p>
                    <p>購入コイン数: {{numberOfCoinsPurchased}}</p>
                    <p>支払い金額: {{paymentAmount}}</p>
                    <p>ご購入いただいたコインは、英会話Zoomシステム内での投げ銭やその他のサービスにご利用いただけます。</p>
                    <p>ご不明な点やご質問がございましたら、お気軽にお問い合わせください。</p>
                    <p>敬具 英会話Zoomシステムサポートチーム</p>
                ",
                    'locale' => 'ja'
                ], [
                    'title' => 'KYC情報の更新完了のお知らせ ',
                    'mail_key' => 'when_a_teacher_updates_their_kyc_information_send_to_teacher',
                    'content' => "
                    <p>親愛なる先生、</p>
                    <p>このたびはKYC情報の更新を行っていただき、ありがとうございます。ご提供いただいた情報は正常に登録されました。KYC情報の確認と承認が完了次第、改めてご連絡いたします。</p>
                    <p>ご不明な点やご質問がございましたら、お気軽にお問い合わせください。</p>
                    <p>敬具 英会話Zoomシステムサポートチーム</p>
                ",
                    'locale' => 'ja'
                ], [
                    'title' => '緊急引き出しリクエストの承認依頼 ',
                    'mail_key' => 'when_a_teacher_requests_an_urgent_withdrawal',
                    'content' => "
                    <p> 親愛なる管理者様、</p>
                    <p>先生から緊急の引き出しリクエストがありました。以下にリクエストの詳細をご案内いたします。</p>
                    <p>リクエストの詳細：</p>
                    <p>先生名: {{teacherName}}</p>
                    <p>リクエスト金額: {{amount}}</p>
                    <p>理由: {{reason}}</p>
                    <p>リクエストの承認または却下をお願いいたします。ご対応いただけるまで、引き出しは行われません。</p>
                    <p>ご不明な点やご質問がございましたら、お気軽にお問い合わせください。</p>
                    <p>敬具 英会話Zoomシステムサポートチーム</p>
                ",
                    'locale' => 'ja'
                ], [
                    'title' => '緊急引き出しリクエストの結果のお知らせ ',
                    'mail_key' => 'when_the_administrator_approves_or_rejects_a_teachers_urgent_withdrawal_request',
                    'content' => "
                    <p>親愛なる先生、</p>
                    <p>先程行われた緊急引き出しリクエストの承認結果をご案内いたします。</p>
                    <p>リクエスト結果：</p>
                    <p>結果: {{status}}</p>
                    <p>承認日時: {{date}}</p>
                    <p>承認金額: {{approveAmount}}</p>
                    <p>ご不明な点やご質問がございましたら、お気軽にお問い合わせください。</p>
                    <p>敬具 英会話Zoomシステムサポートチーム</p>
                ",
                    'locale' => 'ja'
                ], [
                    'title' => 'プランの購入完了のお知らせ - {{planName}}',
                    'mail_key' => 'when_a_teacher_purchases_a_plan',
                    'content' => "
                    <p>親愛なる先生、</p>
                    <p>プランの購入が完了しました。ご購入いただいたプランの詳細は以下の通りです。</p>
                    <p>購入詳細：</p>
                    <p>プラン名: {{planName}}</p>
                    <p>購入日時: {{date}}</p>
                    <p>支払い金額: {{paymentAmount}}</p>
                    <p>ご不明な点やご質問がございましたら、お気軽にお問い合わせください。</p>
                    <p>敬具 英会話Zoomシステムサポートチーム</p>
                ",
                    'locale' => 'ja'
                ], [
                    'title' => 'あなたは生徒からコイン{{amountCoin}}枚を受け取りました',
                    'mail_key' => 'when_a_student_bonus_coins_to_teacher',
                    'content'  => "
                    <p>やあ、{{teacherName}}</p>
                    <p>{{studentName}} さんはあなたに{{amountCoin}}枚のコインを送りました。</p>
                    <p><a href='{{accountLink}}' target='_blank' style='cursor:pointer'>アカウントを確認するためにログインしてください。</a></p>
                ",
                'locale' => 'ja'
                ], [
                'title' => 'いつもLovely-talksをご利用ありがとうございます',
                'mail_key' => 'when_a_user_canceled_subscription',
                'content' => "
                    <p>お客様のプランがキャンセルされました。</p>
                    <p>ユーザー名 {{userName}}</p>
                    <p>プラン名 {{planName}}</p>
                    <p>有効期限 {{expiryDate}}</p>
                    <p>ご利用頂きありがとうございます。
                    お気づきの事などございましたらお手数ではございますが、support@lovely-talks.comまでお知らせ頂けますと幸いです。</p>
                    <p>Lovely-talks.comサポートチーム</p>
                ",
                'locale' => 'ja'
                ], [
                'title' => '解約通知',
                'mail_key' => 'when_a_user_canceled_subscription_to_admin',
                'content' => "
                    <p>お客様のプランがキャンセルされました。</p>
                    <p>ユーザー名 {{userName}}</p>
                    <p>プラン名 {{planName}}</p>
                    <p>有効期限 {{expiryDate}}</p>
                    <p>Lovely-talks.comサポートチーム</p>
                ",
                'locale' => 'ja'
                    ]
                ,  [
                    'title' => 'Lesson reminder - {{lessonTitle}}',
                    'mail_key' => 'student_lesson_reminder',
                    'locale' => 'en',
                    'content' => "
                <p>Dear {{studentName}},</p>
                <p>We hope this email finds you well. We wanted to remind you that we have a lesson scheduled {{timeDescription}}. Here are the details:</p>
                <ul>
                  <li><strong>Title:</strong> {{lessonTitle}}</li>
                  <li><strong>Time:</strong> {{beginAt}}</li>
                  <li><strong>Teacher:</strong> {{teacherName}}</li>
                </ul>
                <p>Please make sure to come prepared with any necessary materials or assignments. If you have any questions or need clarification on any topics, please feel free to reach out to us before the lesson.</p>
                <p>Looking forward to seeing you all tomorrow and having a productive session!</p>
                <p>Best regards,<br>{{senderName}}</p>
                "
                ],
                [
                    'title' => 'レッスンのリマインダー - {{lessonTitle}}',
                    'mail_key' => 'student_lesson_reminder',
                    'content' => "<p>親愛なる{{studentName}}さんへ</p>
                <p>お元気でいらっしゃいますか。このメールは、{{timeDescription}}に予定されているレッスンのリマインダーです。以下に詳細を記載します：</p>
                <ul>
                  <li><strong>タイトル：</strong>{{lessonTitle}}</li>
                  <li><strong>時間：</strong>{{beginAt}}</li>
                  <li><strong>先生：</strong>{{teacherName}}</li>
                </ul>
                <p>必要な教材や宿題を持参するようにしてください。もしトピックについて質問や疑問点があれば、レッスン前に遠慮なくお問い合わせください。</p>
                <p>明日皆さんにお会いできることを楽しみにしており、有意義なセッションを行えることを願っております。</p>
                <p>よろしくお願いいたします。<br>{{senderName}}より</p>",
                'locale' => 'ja',
                ],
                [
                    'title' => 'Refund Complete - {{lessonTitle}}',
                    'mail_key' => 'student_refund_inform',
                    'locale' => 'en',
                    'content' => '
                    <p>Dear {{studentName}},</p>

                        <p>We hope this email finds you well. We are writing to inform you that your refund for Lesson {{lessonTitle}} has been successfully processed.</p>

                        <h2>Refund Details:</h2>
                        <hr>
                        <ul>
                            <li>Lesson title: {{lessonTitle}}</li>
                            <li>Refund Amount: {{refundAmount}}</li>
                        </ul>
                        <hr>

                        <p>The refund amount will be credited back to your original payment method within 5-10 business days. Please note that it may take additional time for the refund to reflect on your bank or credit card statement.</p>

                        <p>Thank you for your patience and understanding throughout this process. We apologize for any inconvenience caused. We value your continued support and hope to serve you again in the future.</p>

                        <p>Best regards,</p>

                        <p>{{senderName}}</p>
                    '
                ],
               [
                'title' => '返金完了 - {{lessonTitle}}',
                'mail_key' => 'student_refund_inform',
                'locale' => 'ja',
                'content' => '
                <p>{{studentName}}さんへ</p>

                <p>お元気でお過ごしのことと存じます。このメールは、レッスン「{{lessonTitle}}」の返金が正常に処理されたことをお知らせするために書かれています。</p>

                <h2>返金の詳細:</h2>
                <hr>
                <ul>
                    <li>レッスンタイトル: {{lessonTitle}}</li>
                    <li>返金金額: {{refundAmount}}</li>
                </ul>
                <hr>

                <p>返金金額は、5〜10営業日以内に元の支払い方法に返金されます。返金が銀行またはクレジットカードの明細に反映されるまで、追加の時間がかかる場合があることにご注意ください。</p>

                <p>このプロセス全体におけるご忍耐とご理解に感謝申し上げます。ご不便をおかけしましたことをお詫び申し上げます。貴重なご支援に感謝し、今後もお客様にご満足いただけるよう努めてまいります。</p>

                <p>敬具</p>

                <p>{{senderName}}</p>'
               ]

            ];

            foreach ($emailTemplatesUpdateData as $data) {
                MailTemplate::firstOrCreate(['mail_key' => $data['mail_key'], 'locale' => $data['locale']], $data);
            }

            DB::table('mail_template')->delete();
            foreach ($emailTemplatesUpdateData as $data) {
                MailTemplate::create($data);
            }

        }

    }
}
