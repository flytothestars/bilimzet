<?php namespace App\Models;

use App\CoursePart;
use App\Certificate;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	public static function createForCertificate(Certificate $certificate): Notification
	{
		$notification = new Notification();
		$notification->user_id = $certificate->user_id;
		$notification->title = "Вы получили сертификат";
		$notification->title_kz = "Сіз сертификат алдыңыз";
		$notification->desc = $certificate->title;
		$notification->desc_kz = $certificate->title_kz;
		$notification->link = route('certificates');
		$notification->save();
		return $notification;
	}

	public static function createForContestCertificate(ContestCertificate $certificate): Notification
	{
		$notification = new Notification();
		$notification->user_id = $certificate->user_id;
		$notification->title = "Вы получили сертификат";
		$notification->title_kz = "Сіз сертификат алдыңыз";
		$notification->desc = $certificate->title;
		$notification->desc_kz = $certificate->title_kz;
		$notification->link = route('certificates');
		$notification->save();
		return $notification;
	}

	public static function createForCoursePart(CoursePart $coursePart, User $user): Notification
	{
		$notification = new Notification();
		$notification->title = "Вы приобрели курс";
		$notification->desc = "Вы приобрели часть курса <b>\"{$coursePart->course->title}\"</b> " .
			"длительностью <b>{$coursePart->duration_hours}&nbsp;Ак.ч.</b> " .
			"за <b>{$coursePart->price_kzt}&nbsp;Tг.</b>";
		$notification->title_kz = "Сіз курсты сатып алдыңыз";
		$notification->desc_kz = "Сіз курстың бір бөлігін сатып алдыңыз <b>\"{$coursePart->course->title_kz}\"</b> " .
			"ұзақтығы <b>{$coursePart->duration_hours}&nbsp;ак.с.</b> " .
			"<b>{$coursePart->price_kzt}&nbsp;Tг.</b>";
		$notification->link = "/handouts";
		$notification->user_id = $user->id;
		$notification->save();
		return $notification;
	}

	public static function createForContestPart(ContestPart $contestPart, User $user): Notification
	{
		$notification = new Notification();
		$notification->title = "Вы приобрели конкурс";
		$notification->desc = "Вы приобрели часть конкурса <b>\"{$contestPart->contest->title}\"</b> " .
			"длительностью <b>{$contestPart->duration_hours}&nbsp;Ак.ч.</b> " .
			"за <b>{$contestPart->price_kzt}&nbsp;Tг.</b>";
		$notification->title_kz = "Сіз байқау сатып алдыңыз";
		$notification->desc_kz = "Сіз байқаудың бір бөлігін сатып алдыңыз <b>\"{$contestPart->contest->title}\"</b> " .
			"ұзақтығы <b>{$contestPart->duration_hours}&nbsp;ак.с.</b> " .
			"<b>{$contestPart->price_kzt}&nbsp;Tг.</b>";
		$notification->link = "/handouts";
		$notification->user_id = $user->id;
		$notification->save();
		return $notification;
	}

	public static function createForFreeMoney(): Notification
	{
		$notification = new Notification();
		$notification->title = "Пополнение счёта";
		$notification->desc = "Вам были начислены <b>50000&nbsp;Tг.</b>";
		$notification->title_kz = "Шотты толтыру";
		$notification->desc_kz = "Сіз есептелдіңіз <b>50000&nbsp;Tг.</b>";
		$notification->link = route('profile');
		$notification->user_id = auth()->user()->id;
		$notification->save();
		return $notification;
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
