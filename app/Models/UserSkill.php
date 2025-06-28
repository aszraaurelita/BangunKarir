<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_skill',
        'tipe',
        'deskripsi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getSkillRecommendations()
    {
        return [
            'soft_skill' => [
                'Teamwork', 'Leadership', 'Communication', 'Problem Solving',
                'Time Management', 'Adaptability', 'Critical Thinking',
                'Creativity', 'Public Speaking', 'Negotiation'
            ],
            'hard_skill' => [
                'Programming', 'Web Development', 'Mobile Development',
                'Data Analysis', 'Digital Marketing', 'Graphic Design',
                'Project Management', 'Database Management', 'UI/UX Design',
                'Machine Learning', 'Cybersecurity', 'Cloud Computing'
            ]
        ];
    }
}
