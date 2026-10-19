<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicActivityExercise extends Model
{
    protected $fillable = [
        'academic_activity_id', 'order', 'type', 'prompt', 'payload', 'points',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(AcademicActivity::class, 'academic_activity_id');
    }

    /**
     * Public shape of this exercise, safe to send to the browser BEFORE the
     * student has submitted. Never includes the correct answer.
     */
    public function toPublicArray(): array
    {
        $base = [
            'id' => $this->id,
            'type' => $this->type,
            'prompt' => $this->prompt,
            'points' => $this->points,
        ];

        return match ($this->type) {
            'vf' => $base + [
                'statement' => $this->payload['statement'] ?? $this->prompt,
            ],
            'mcq' => $base + [
                'options' => array_values($this->payload['options'] ?? []),
            ],
            'matching' => $base + [
                'left' => $this->payload['left'] ?? [],
                'right' => $this->shuffledRight(),
            ],
            'ordering' => $base + [
                'items' => $this->shuffledItems(),
            ],
            'memory' => $base + [
                'cards' => $this->shuffledMemoryCards(),
            ],
            'fillblank' => $base + [
                'template' => $this->payload['template'] ?? '',
                'blanks' => $this->shuffledBlankOptions(),
            ],
            'vfgroup' => $base + [
                'statements' => collect($this->payload['statements'] ?? [])
                    ->map(fn ($s) => ['id' => $s['id'], 'text' => $s['text']])->values()->all(),
            ],
            'multi' => $base + [
                'questions' => collect($this->payload['questions'] ?? [])
                    ->map(fn ($q) => ['id' => $q['id'], 'prompt' => $q['prompt'], 'options' => array_values($q['options'])])
                    ->values()->all(),
            ],
            'crossword' => $base + [
                'rows' => $this->payload['rows'] ?? 0,
                'cols' => $this->payload['cols'] ?? 0,
                'words' => collect($this->payload['words'] ?? [])
                    ->map(fn ($w) => [
                        'id' => $w['id'],
                        'number' => $w['number'],
                        'dir' => $w['dir'],
                        'row' => $w['row'],
                        'col' => $w['col'],
                        'length' => mb_strlen($w['answer']),
                        'clue' => $w['clue'],
                    ])->values()->all(),
            ],
            default => $base,
        };
    }

    /**
     * Full shape including the correct answer, for after submission.
     */
    public function toGradedArray(mixed $studentAnswer): array
    {
        $public = $this->toPublicArray();
        $correct = $this->isCorrect($studentAnswer);

        return $public + [
            'student_answer' => $studentAnswer,
            'correct' => $correct,
            'correct_answer' => $this->correctAnswerForDisplay(),
        ];
    }

    /**
     * Fraction of this exercise's points the answer earns, 0.0 to 1.0. Every classic
     * single-answer type is all-or-nothing (exactly isCorrect()), so activities built
     * before long, multi-part exercises existed score exactly as they always did. The
     * "long" types (vfgroup, multi, crossword — and ordering/fillblank when their payload
     * sets 'partial' => true) instead earn proportional credit per statement, option,
     * word, position or blank, because losing the whole exercise over one slip in a
     * 12-item block would be disproportionate.
     */
    public function score(mixed $studentAnswer): float
    {
        if ($studentAnswer === null) {
            return 0.0;
        }

        $partial = (bool) ($this->payload['partial'] ?? false);

        return match (true) {
            $this->type === 'vfgroup' => $this->vfGroupScore($studentAnswer),
            $this->type === 'multi' => $this->multiScore($studentAnswer),
            $this->type === 'crossword' => $this->crosswordScore($studentAnswer),
            $this->type === 'ordering' && $partial => $this->orderingScore($studentAnswer),
            $this->type === 'fillblank' && $partial => $this->fillBlankScore($studentAnswer),
            default => $this->isCorrect($studentAnswer) ? 1.0 : 0.0,
        };
    }

    public function isCorrect(mixed $studentAnswer): bool
    {
        if ($studentAnswer === null) {
            return false;
        }

        return match ($this->type) {
            'vf' => $this->normalizeBool($studentAnswer) === $this->normalizeBool($this->payload['answer'] ?? null),
            'mcq' => (int) $studentAnswer === (int) ($this->payload['correct'] ?? -1),
            'matching' => $this->matchingIsCorrect($studentAnswer),
            'ordering' => $this->orderingIsCorrect($studentAnswer),
            'memory' => $this->memoryIsCorrect($studentAnswer),
            'fillblank' => $this->fillBlankIsCorrect($studentAnswer),
            'vfgroup', 'multi', 'crossword' => $this->score($studentAnswer) >= 1.0,
            default => false,
        };
    }

    private function normalizeBool(mixed $v): ?bool
    {
        if (is_bool($v)) {
            return $v;
        }
        if ($v === 'true' || $v === '1' || $v === 1) {
            return true;
        }
        if ($v === 'false' || $v === '0' || $v === 0) {
            return false;
        }

        return null;
    }

    private function matchingIsCorrect(mixed $studentAnswer): bool
    {
        if (! is_array($studentAnswer)) {
            return false;
        }

        $correct = $this->payload['pairs'] ?? [];
        if (count($correct) !== count(array_filter($studentAnswer, fn ($v) => $v !== null && $v !== ''))) {
            return false;
        }

        foreach ($correct as $leftId => $rightId) {
            if (($studentAnswer[$leftId] ?? null) !== $rightId) {
                return false;
            }
        }

        return true;
    }

    private function orderingIsCorrect(mixed $studentAnswer): bool
    {
        if (! is_array($studentAnswer)) {
            return false;
        }

        $correctOrder = $this->payload['correctOrder'] ?? [];

        return array_values($studentAnswer) === array_values($correctOrder);
    }

    /**
     * A memory game is correct when every pair has been found (order doesn't matter — a
     * "wrong" flip is never recorded, since the game only saves a pair once both cards
     * flipped actually match).
     */
    private function memoryIsCorrect(mixed $studentAnswer): bool
    {
        if (! is_array($studentAnswer)) {
            return false;
        }

        $expected = collect($this->payload['pairs'] ?? [])->pluck('id')->sort()->values()->all();
        $got = collect($studentAnswer)->unique()->sort()->values()->all();

        return $expected === $got;
    }

    /**
     * A fill-in-the-blank exercise is correct when the option picked for every blank
     * matches its expected word, compared case- and accent-insensitively (so
     * "protección"/"Protección"/"PROTECCION" all count) so a student isn't marked
     * wrong over capitalization or a missing tilde. Each blank offers up to 3
     * selectable options (the right word plus distractors) rather than free text,
     * so grading is always unambiguous.
     */
    private function fillBlankIsCorrect(mixed $studentAnswer): bool
    {
        if (! is_array($studentAnswer)) {
            return false;
        }

        $blanks = array_values($this->payload['blanks'] ?? []);
        $given = array_values($studentAnswer);

        if (count($blanks) === 0 || count($given) !== count($blanks)) {
            return false;
        }

        foreach ($blanks as $i => $blank) {
            $answer = is_array($blank) ? ($blank['answer'] ?? '') : $blank;
            if ($this->normalizeBlankAnswer($given[$i] ?? '') !== $this->normalizeBlankAnswer($answer)) {
                return false;
            }
        }

        return true;
    }

    /**
     * V/F block: one true/false pick per statement, keyed by statement id.
     */
    private function vfGroupScore(mixed $studentAnswer): float
    {
        if (! is_array($studentAnswer)) {
            return 0.0;
        }

        $statements = $this->payload['statements'] ?? [];
        if (count($statements) === 0) {
            return 0.0;
        }

        $right = 0;
        foreach ($statements as $statement) {
            if ($this->normalizeBool($studentAnswer[$statement['id']] ?? null) === $this->normalizeBool($statement['answer'])) {
                $right++;
            }
        }

        return $right / count($statements);
    }

    /**
     * "Marca todas las que correspondan": every option of every question is a yes/no
     * decision (ticked or not), and the score is the share of decisions that are right —
     * so ticking a wrong option or missing a right one each cost the same single option.
     */
    private function multiScore(mixed $studentAnswer): float
    {
        if (! is_array($studentAnswer)) {
            return 0.0;
        }

        $decisions = 0;
        $right = 0;
        foreach ($this->payload['questions'] ?? [] as $question) {
            $picked = array_map('intval', (array) ($studentAnswer[$question['id']] ?? []));
            foreach (array_values($question['options']) as $i => $_) {
                $decisions++;
                if (in_array($i, $picked, true) === in_array($i, $question['correct'], true)) {
                    $right++;
                }
            }
        }

        return $decisions > 0 ? $right / $decisions : 0.0;
    }

    /**
     * Crossword: the student's answer maps "row,col" => letter. A word counts when every
     * one of its cells holds the right letter (accent/case-insensitive); the score is the
     * share of words completed.
     */
    private function crosswordScore(mixed $studentAnswer): float
    {
        if (! is_array($studentAnswer)) {
            return 0.0;
        }

        $words = $this->payload['words'] ?? [];
        if (count($words) === 0) {
            return 0.0;
        }

        $right = 0;
        foreach ($words as $word) {
            if ($this->crosswordWordIsCorrect($word, $studentAnswer)) {
                $right++;
            }
        }

        return $right / count($words);
    }

    private function crosswordWordIsCorrect(array $word, array $studentAnswer): bool
    {
        $letters = mb_str_split($this->normalizeBlankAnswer($word['answer']));
        foreach ($letters as $i => $letter) {
            $row = $word['row'] + ($word['dir'] === 'down' ? $i : 0);
            $col = $word['col'] + ($word['dir'] === 'across' ? $i : 0);
            if ($this->normalizeBlankAnswer($studentAnswer["{$row},{$col}"] ?? '') !== $letter) {
                return false;
            }
        }

        return true;
    }

    /**
     * Ordering with partial credit: the share of items sitting in their right position.
     */
    private function orderingScore(mixed $studentAnswer): float
    {
        if (! is_array($studentAnswer)) {
            return 0.0;
        }

        $correctOrder = array_values($this->payload['correctOrder'] ?? []);
        $given = array_values($studentAnswer);
        if (count($correctOrder) === 0) {
            return 0.0;
        }

        $right = 0;
        foreach ($correctOrder as $i => $id) {
            if (($given[$i] ?? null) === $id) {
                $right++;
            }
        }

        return $right / count($correctOrder);
    }

    /**
     * Fill-in-the-blank with partial credit: the share of blanks with the right word.
     */
    private function fillBlankScore(mixed $studentAnswer): float
    {
        if (! is_array($studentAnswer)) {
            return 0.0;
        }

        $blanks = array_values($this->payload['blanks'] ?? []);
        $given = array_values($studentAnswer);
        if (count($blanks) === 0) {
            return 0.0;
        }

        $right = 0;
        foreach ($blanks as $i => $blank) {
            $answer = is_array($blank) ? ($blank['answer'] ?? '') : $blank;
            if ($this->normalizeBlankAnswer($given[$i] ?? '') === $this->normalizeBlankAnswer($answer)) {
                $right++;
            }
        }

        return $right / count($blanks);
    }

    /**
     * Human-readable Spanish rendering of a student's raw answer for this exercise,
     * used in the admin panel so a teacher can see exactly what was picked (not just
     * the score) without having to decode the raw JSON payload themselves.
     */
    public function formatStudentAnswer(mixed $answer): string
    {
        $isBlank = $answer === null || $answer === ''
            || (is_array($answer) && count(array_filter($answer, fn ($v) => $v !== null && $v !== '')) === 0);

        if ($isBlank) {
            return 'Sin responder';
        }

        return match ($this->type) {
            'vf' => match ($this->normalizeBool($answer)) {
                true => 'Verdadero',
                false => 'Falso',
                default => 'Sin responder',
            },
            'mcq' => $this->payload['options'][(int) $answer] ?? 'Sin responder',
            'ordering' => collect($answer)
                ->map(fn ($id) => collect($this->payload['items'] ?? [])->firstWhere('id', $id)['text'] ?? $id)
                ->implode(' → '),
            'fillblank' => collect($answer)->map(fn ($a) => $a ?: '—')->implode(', '),
            'matching' => collect($answer)
                ->map(function ($rightId, $leftId) {
                    $leftText = collect($this->payload['left'] ?? [])->firstWhere('id', $leftId)['text'] ?? $leftId;
                    $rightText = collect($this->payload['right'] ?? [])->firstWhere('id', $rightId)['text'] ?? $rightId;

                    return $leftText.' → '.$rightText;
                })
                ->implode('; '),
            'memory' => is_array($answer) ? implode(', ', $answer) : (string) $answer,
            'vfgroup' => collect($this->payload['statements'] ?? [])
                ->map(fn ($s, $i) => ($i + 1).'. '.match ($this->normalizeBool($answer[$s['id']] ?? null)) {
                    true => 'V',
                    false => 'F',
                    default => '—',
                })
                ->implode('  '),
            'multi' => collect($this->payload['questions'] ?? [])
                ->map(fn ($q, $i) => 'P'.($i + 1).': '.(collect((array) ($answer[$q['id']] ?? []))
                    ->map(fn ($n) => $q['options'][(int) $n] ?? '?')
                    ->implode(' | ') ?: '—'))
                ->implode(' · '),
            'crossword' => collect($this->payload['words'] ?? [])
                ->map(function ($w) use ($answer) {
                    $typed = '';
                    foreach (range(0, mb_strlen($w['answer']) - 1) as $i) {
                        $row = $w['row'] + ($w['dir'] === 'down' ? $i : 0);
                        $col = $w['col'] + ($w['dir'] === 'across' ? $i : 0);
                        $typed .= ($answer["{$row},{$col}"] ?? '') ?: '_';
                    }

                    return $w['number'].($w['dir'] === 'down' ? '↓' : '→').' '.$typed;
                })
                ->implode(' · '),
            default => is_scalar($answer) ? (string) $answer : 'Sin responder',
        };
    }

    private function normalizeBlankAnswer(mixed $value): string
    {
        return trim(mb_strtolower(\Illuminate\Support\Str::ascii((string) $value)));
    }

    private function correctAnswerForDisplay(): mixed
    {
        return match ($this->type) {
            'vf' => (bool) ($this->payload['answer'] ?? false),
            'mcq' => $this->payload['correct'] ?? null,
            'matching' => $this->payload['pairs'] ?? [],
            'ordering' => $this->payload['correctOrder'] ?? [],
            'memory' => collect($this->payload['pairs'] ?? [])->pluck('id')->values()->all(),
            'fillblank' => collect($this->payload['blanks'] ?? [])
                ->map(fn ($blank) => is_array($blank) ? ($blank['answer'] ?? '') : $blank)
                ->values()->all(),
            'vfgroup' => collect($this->payload['statements'] ?? [])
                ->mapWithKeys(fn ($s) => [$s['id'] => (bool) $s['answer']])->all(),
            'multi' => collect($this->payload['questions'] ?? [])
                ->mapWithKeys(fn ($q) => [$q['id'] => array_values($q['correct'])])->all(),
            'crossword' => $this->crosswordSolution(),
            default => null,
        };
    }

    /**
     * "row,col" => letter for every cell of the grid, plus each word's full answer under
     * 'words' so the review can print what the right word was.
     */
    private function crosswordSolution(): array
    {
        $cells = [];
        $words = [];
        foreach ($this->payload['words'] ?? [] as $word) {
            $words[$word['id']] = $word['answer'];
            foreach (mb_str_split($word['answer']) as $i => $letter) {
                $row = $word['row'] + ($word['dir'] === 'down' ? $i : 0);
                $col = $word['col'] + ($word['dir'] === 'across' ? $i : 0);
                $cells["{$row},{$col}"] = $letter;
            }
        }

        return ['cells' => $cells, 'words' => $words];
    }

    /**
     * Each blank's options (correct word + distractors), shuffled into a stable order per
     * exercise+blank so the correct answer isn't always in the same position but also
     * doesn't reshuffle on every request. Never reveals which option is correct.
     */
    private function shuffledBlankOptions(): array
    {
        return collect($this->payload['blanks'] ?? [])->values()->map(function ($blank, $i) {
            $options = is_array($blank) ? ($blank['options'] ?? []) : [$blank];
            mt_srand(($this->id ?: 1) + 3000 + $i);
            $shuffled = collect($options)->shuffle()->values()->all();
            mt_srand();

            return ['options' => $shuffled];
        })->all();
    }

    private function shuffledRight(): array
    {
        $right = $this->payload['right'] ?? [];
        // Stable order based on the exercise id so it doesn't reshuffle on every request.
        mt_srand($this->id ?: 1);
        $right = collect($right)->shuffle()->values()->all();
        mt_srand();

        return $right;
    }

    private function shuffledItems(): array
    {
        $items = $this->payload['items'] ?? [];
        mt_srand(($this->id ?: 1) + 1000);
        $items = collect($items)->shuffle()->values()->all();
        mt_srand();

        return $items;
    }

    /**
     * Two face-down cards per pair (one showing the left text, one the right text),
     * shuffled together into a single deck for the memory game's grid. Stable per
     * exercise id so the layout doesn't reshuffle on every request.
     */
    private function shuffledMemoryCards(): array
    {
        $pairs = $this->payload['pairs'] ?? [];
        $cards = [];
        foreach ($pairs as $pair) {
            $cards[] = ['cardId' => $pair['id'].'-a', 'pairId' => $pair['id'], 'text' => $pair['left']];
            $cards[] = ['cardId' => $pair['id'].'-b', 'pairId' => $pair['id'], 'text' => $pair['right']];
        }
        mt_srand(($this->id ?: 1) + 2000);
        $cards = collect($cards)->shuffle()->values()->all();
        mt_srand();

        return $cards;
    }
}
