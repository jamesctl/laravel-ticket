<?php

namespace App\Library;

use App\Enums\BookingStatus;
use App\Enums\QueueType;
use App\Jobs\SendEmailJob;
use App\Mail\PurchaseCoinUser;
use App\Mail\BonusCoinToTeacher;
use App\Mail\InformBookingToStudent;
use App\Mail\InformBookingToTeacher;
use App\Mail\TeachingScheduleCancelInformMail;
use App\Mail\ConfirmApproveKycToTeacher;
use App\Mail\UserHasUpdatedKyc;
use App\Mail\WithdrawRequestApprovedMail;
use App\Models\Booking;
use App\Models\CoinPlan;
use App\Models\Coin;
use App\Models\TeachingSchedule;
use App\Models\User;
use App\Models\Subscription;
use App\Mail\RegisterTeacherAdmin;
use App\Mail\UserSubscribeSubscription;
use App\Mail\WithdrawRequestCreatedInformMail;
use App\Models\WithdrawRequest;
use App\Mail\RegisterTeacherConfirm;
use App\Mail\WithdrawRequestCanceledMail;
use App\Models\Setting;
use App\Mail\UserRenewalSubscription;

class MailService {
    public function sendPurchaseCoinConfirmMail(Coin $coin, CoinPlan $plan) {
        return dispatch(new SendEmailJob($coin->user_coin, new PurchaseCoinUser($coin, $plan, 'user')))
            ->onQueue(QueueType::SEND_MAIL);
    }

    public function sendAdminPurchaseCoinConfirmMail(Coin $coin, CoinPlan $plan) {
        $toAdminAddress = Setting::getEmailAccountSupportSetting();
        return dispatch(new SendEmailJob($coin->user_coin, new PurchaseCoinUser($coin, $plan), $toAdminAddress))
            ->onQueue(QueueType::SEND_MAIL);
    }

    public function sendBonusCoinConfirmMail(User $teacher, User $student, Coin $coin) {
        return dispatch(new SendEmailJob($teacher, new BonusCoinToTeacher($teacher, $student, $coin)))
            ->onQueue(QueueType::SEND_MAIL);
    }

    public function sendConfirmEmailToTeacher(Booking $booking) {
        dispatch(new SendEmailJob($booking->teacher, new InformBookingToTeacher($booking)))->onQueue(QueueType::SEND_MAIL);
    }
    public function sendConfirmEmailToStudent(Booking $booking) {
        dispatch(new SendEmailJob($booking->student, new InformBookingToStudent($booking)))->onQueue(QueueType::SEND_MAIL);
    }
    public function sendConfirmEmail(Booking $booking) {
        $this->sendConfirmEmailToTeacher($booking);
        $this->sendConfirmEmailToStudent($booking);
    }
    public function sendTeachingScheduleCancelInformEmail(TeachingSchedule $teachingSchedule) {
        $bookings = $teachingSchedule->bookings()->where('status', BookingStatus::SUCCESS)->with('student')->get();
        foreach ($bookings as $booking) {
            dispatch(new SendEmailJob($booking->student, new TeachingScheduleCancelInformMail($teachingSchedule, $booking->student)));
        }
    }

    public function sendApproveKycConfirmMail(User $teacher) {
        return dispatch(new SendEmailJob($teacher, new ConfirmApproveKycToTeacher($teacher)))
            ->onQueue(QueueType::SEND_MAIL);
    }

    /**
     * System Send Email to Admin to Notification that User updated KYC
     * 
     * @param User $teacher
     * 
     * @return [type]
     */
    public function sendAdminNotificationUserUpdateKYCMail(User $user) {
        $to = Setting::getEmailAccountAdminSetting();
        return dispatch(new SendEmailJob($user, new UserHasUpdatedKyc($user), $to))->onQueue(QueueType::SEND_MAIL);
    }

    /**
     * System Send Email to Admin notification that A New Teacher just registered
     * 
     * @param User $teacher
     * 
     * @return [type]
     */
    public function sendAdminTeacherRegisterMail(User $teacher) {
        $to = Setting::getEmailAccountAdminSetting();
        return dispatch(new SendEmailJob($teacher, new RegisterTeacherAdmin($teacher), $to))->onQueue(QueueType::SEND_MAIL);
    }

    /**
     * System Send Email to New Teacher for Waiting Admin Confirm
     * 
     * @param User $teacher
     * 
     * @return [type]
     */
    public function sendTeacherRegisterWaitingConfirmMail(User $teacher) {
        return dispatch(new SendEmailJob($teacher, new RegisterTeacherConfirm($teacher)))->onQueue(QueueType::SEND_MAIL);
    }

    public function sendWithdrawRequestCreatedInformEmail(WithdrawRequest $withdrawRequest) {
        $to = Setting::getEmailAccountPaymentSetting();
        return dispatch(new SendEmailJob($withdrawRequest->teacher, new WithdrawRequestCreatedInformMail($withdrawRequest), $to))->onQueue(QueueType::SEND_MAIL);
    }
    public function sendWithdrawRequestApprovedEmail(WithdrawRequest $withdrawRequest) {
        return dispatch(new SendEmailJob($withdrawRequest->teacher, new WithdrawRequestApprovedMail($withdrawRequest)))->onQueue(QueueType::SEND_MAIL);
    }
    public function sendWithdrawRequestCanceledEmail(WithdrawRequest $withdrawRequest) {
        return dispatch(new SendEmailJob($withdrawRequest->teacher, new WithdrawRequestCanceledMail($withdrawRequest)))->onQueue(QueueType::SEND_MAIL);
    }

    public function sendAdminSubscribePlan(User $user, Subscription $subscription) {
        $toAdminAddress = Setting::getEmailAccountSupportSetting();
        return dispatch(new SendEmailJob($user, new UserSubscribeSubscription($subscription), $toAdminAddress))
            ->onQueue(QueueType::SEND_MAIL);
    }

    public function sendUserSubscribePlan(User $user, Subscription $subscription) {
        return dispatch(new SendEmailJob($user, new UserSubscribeSubscription($subscription, 'user')))
            ->onQueue(QueueType::SEND_MAIL);
    }

    public function sendSubscriptionRenewalEmail(User $user, Subscription $subscription)
    {
        $this->sendAdminSubscriptionRenewed($user, $subscription);
        $this->sendUserSubscriptionRenewed($user, $subscription);
    }

    public function sendAdminSubscriptionRenewed(User $user, Subscription $subscription) 
    {
        $toAdminAddress = Setting::getEmailAccountSupportSetting();
        return dispatch(new SendEmailJob($user, new UserRenewalSubscription($subscription), $toAdminAddress))
            ->onQueue(QueueType::SEND_MAIL);
    }

    public function sendUserSubscriptionRenewed(User $user, Subscription $subscription) 
    {
        return dispatch(new SendEmailJob($user, new UserRenewalSubscription($subscription, 'user')))
            ->onQueue(QueueType::SEND_MAIL);
    }
}
