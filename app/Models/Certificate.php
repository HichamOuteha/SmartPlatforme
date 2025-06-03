<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'certificate_number',
        'pdf_path',
        'issued_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Helper methods
    public static function generateNumber()
    {
        do {
            $number = 'CERT-' . strtoupper(uniqid());
        } while (static::where('certificate_number', $number)->exists());

        return $number;
    }
} 
?>