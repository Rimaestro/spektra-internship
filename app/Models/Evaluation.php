<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'internship_id',
        'evaluator_id',
        'evaluator_type',
        'discipline_score',
        'teamwork_score',
        'initiative_score',
        'responsibility_score',
        'problem_solving_score',
        'communication_score',
        'technical_skill_score',
        'final_score',
        'grade',
        'comment',
        'strength',
        'weakness',
        'is_final',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'discipline_score' => 'float',
        'teamwork_score' => 'float',
        'initiative_score' => 'float',
        'responsibility_score' => 'float',
        'problem_solving_score' => 'float',
        'communication_score' => 'float',
        'technical_skill_score' => 'float',
        'final_score' => 'float',
        'is_final' => 'boolean',
    ];

    /**
     * Get the internship that owns the evaluation.
     */
    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }

    /**
     * Get the evaluator that owns the evaluation.
     */
    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    /**
     * Calculate the final score based on weighted average of all scores.
     */
    public function calculateFinalScore()
    {
        $weights = [
            'discipline_score' => 0.15,
            'teamwork_score' => 0.15,
            'initiative_score' => 0.10,
            'responsibility_score' => 0.15,
            'problem_solving_score' => 0.15,
            'communication_score' => 0.15,
            'technical_skill_score' => 0.15,
        ];

        $totalWeightedScore = 0;
        $totalWeight = 0;

        foreach ($weights as $field => $weight) {
            if ($this->$field !== null) {
                $totalWeightedScore += $this->$field * $weight;
                $totalWeight += $weight;
            }
        }

        if ($totalWeight > 0) {
            $this->final_score = round($totalWeightedScore / $totalWeight, 2);
            $this->grade = $this->calculateGrade();
        }

        return $this;
    }

    /**
     * Calculate the grade based on the final score.
     */
    protected function calculateGrade()
    {
        if ($this->final_score === null) {
            return null;
        }

        if ($this->final_score >= 90) {
            return 'A';
        } elseif ($this->final_score >= 80) {
            return 'B';
        } elseif ($this->final_score >= 70) {
            return 'C';
        } elseif ($this->final_score >= 60) {
            return 'D';
        } else {
            return 'E';
        }
    }

    /**
     * Get the student that is being evaluated.
     */
    public function student()
    {
        return $this->internship->student;
    }

    /**
     * Scope a query to only include final evaluations.
     */
    public function scopeFinal($query)
    {
        return $query->where('is_final', true);
    }
}
