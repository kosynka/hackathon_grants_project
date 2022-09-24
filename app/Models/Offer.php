<?php

namespace App\Models;

use App\Events\OfferUpdatedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    const STATUS_CREATED = 'CREATED';
    const STATUS_ON_REVIEW = 'ON_REVIEW';
    const STATUS_ACCEPTED = 'ACCEPTED';
    const STATUS_DECLINED = 'DECLINED';

    protected $fillable = [
        'id',
        'title',
        'description',
        'user_id',
        'status',
        'document_path',
        'image_path',
        'rate',
    ];

    protected $dispatchesEvents = [
        'updated' => OfferUpdatedEvent::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function getStatus() : string
    {
        switch ($this->status) {
            case self::STATUS_ACCEPTED:
                return 'Принят';
                break;
            case self::STATUS_ON_REVIEW:
                return 'На рассмотрении';
                break;
            case self::STATUS_CREATED:
                return 'Создан';
                break;
            case self::STATUS_DECLINED:
                return 'Отклонён';
                break;
            default:
                return '';
                break;
        }
    }
}
