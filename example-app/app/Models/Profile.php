<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// User মডেলটি ইমপোর্ট করা হলো
use App\Models\User;

class Profile extends Model
{
    use HasFactory;

    /**
     * যে কলামগুলোতে ডেটা অ্যা সাইন করা যাবে।
     * user_id কলামটি আপডেট বা তৈরির সময় দরকার হবে।
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'phone',
        'address',
    ];

    // ----------------------------------------------------------------------
    // One-to-One সম্পর্ক এখানে ডিফাইন করা হয়েছে
    // ----------------------------------------------------------------------

    /**
     * User মডেলের সাথে বিপরীত One-to-One সম্পর্ক।
     * * এই Profile-টি একজন User-এর সাথে সম্পর্কিত।
     */
    public function user()
    {
        // belongsTo মেথডটি বোঝায় যে এই Profile টেবিলটির
        // user_id কলামে Foreign Key আছে, যা User টেবিলকে নির্দেশ করছে।
        return $this->belongsTo(User::class);
    }
}
