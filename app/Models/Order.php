<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'payment_details',
        'yape_qr_code',
        'transaction_reference',
        'billing_details',
        'completed_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'payment_details' => 'array',
        'billing_details' => 'array',
        'completed_at' => 'datetime',
    ];

    // Generar número de orden automáticamente
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'NX-' . strtoupper(Str::random(8));
            }
        });
    }

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByPaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    // Métodos auxiliares
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'payment_status' => 'paid',
            'completed_at' => now(),
        ]);
        
        // Agregar juegos a la biblioteca del usuario
        foreach ($this->items as $item) {
            UserLibrary::create([
                'user_id' => $this->user_id,
                'game_id' => $item->game_id,
                'purchased_at' => now(),
                'purchase_price' => $item->price,
            ]);
        }
    }

    public function getFormattedTotal()
    {
        return 'S/ ' . number_format($this->total_amount, 2);
    }

    public function generateYapeQR()
    {
        // Aquí puedes integrar con una librería para generar QR
        // Por ahora, simulamos la generación
        $qrData = [
            'amount' => $this->total_amount,
            'reference' => $this->order_number,
            'merchant' => 'Nexus Games'
        ];
        
        $this->update(['yape_qr_code' => json_encode($qrData)]);
        return $qrData;
    }
}