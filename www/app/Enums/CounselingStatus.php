<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Requesting()
 * @method static static CounselorAnswered()
 * @method static static BothAnswered()
 * @method static static Completed()
 * @method static static CounselorReject()
 * @method static static ClientReject()
 * @method static static Canceled()
 */
final class CounselingStatus extends Enum
{
    public const Requesting = 0; // Client->Counselorへリクエスト中
    public const CounselorAnswered = 1; // Counselorが承諾し日程調整済
    public const BothAnswered = 2; // Clientも日程調整完了し相談日時が確定済
    public const Completed = 3; // 相談終了
    public const CounselorReject = 4; // Counselorがリクエストを拒否
    public const ClientReject = 5; // Clientが日程調整前にリクエストを取り下げ
    public const Canceled = 6; // 日程調整完了後にどちらかがキャンセル
}
