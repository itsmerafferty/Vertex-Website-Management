<?php
class Testimonial {
    public $image;
    public $name;
    public $position;
    public $rate;
    public $testimonial;
    public $systemName;

    public function __construct($image, $name, $position, $rate, $testimonial, $systemName) {
        $this->image       = $image;
        $this->name        = $name;
        $this->position    = $position;
        $this->rate        = max(1, min(5, (int)$rate));
        $this->testimonial = $testimonial;
        $this->systemName  = $systemName;
    }

    private function renderStars(): string {
        return str_repeat('&#9733;', $this->rate) . str_repeat('&#9734;', 5 - $this->rate);
    }

    public function render() {
        ?>
        <div class="tsm-card">
            <div class="tsm-header">
                <img src="<?= htmlspecialchars($this->image) ?>"
                     alt="<?= htmlspecialchars($this->name) ?>"
                     class="tsm-img" />
                <div class="tsm-meta">
                    <h3 class="tsm-name"><?= htmlspecialchars($this->name) ?></h3>
                    <p class="tsm-position"><?= htmlspecialchars($this->position) ?></p>
                    <span class="tsm-stars"><?= $this->renderStars() ?></span>
                </div>
                <?php if ($this->systemName): ?>
                <span class="tsm-system"><?= htmlspecialchars($this->systemName) ?></span>
                <?php endif; ?>
            </div>
            <blockquote class="tsm-quote">"<?= htmlspecialchars($this->testimonial) ?>"</blockquote>
        </div>
        <style>
            .tsm-card {
                background: #fff;
                border: 1px solid #e5e7eb;
                border-radius: 0.5rem;
                box-shadow: 0 2px 8px rgba(0,0,0,0.04);
                padding: 1.5rem;
                max-width: 500px;
                margin: 1.5rem auto;
            }
            .tsm-header {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 1rem;
                position: relative;
            }
            .tsm-img {
                width: 56px;
                height: 56px;
                object-fit: cover;
                border-radius: 50%;
                border: 2px solid #6366f1;
                flex-shrink: 0;
            }
            .tsm-meta { flex: 1; }
            .tsm-name {
                font-size: 1rem;
                font-weight: 700;
                color: #18181b;
                margin: 0 0 0.1em 0;
            }
            .tsm-position {
                font-size: 0.85rem;
                color: #52525b;
                margin: 0 0 0.25em 0;
            }
            .tsm-stars {
                color: #f59e0b;
                font-size: 1rem;
                letter-spacing: 0.05em;
            }
            .tsm-system {
                background: #e0e7ff;
                color: #6366f1;
                border-radius: 999px;
                padding: 0.2rem 0.75rem;
                font-size: 0.78rem;
                font-weight: 600;
                flex-shrink: 0;
            }
            .tsm-quote {
                font-size: 0.95rem;
                color: #374151;
                line-height: 1.6;
                margin: 0;
                padding-left: 1rem;
                border-left: 3px solid #6366f1;
                font-style: italic;
            }
        </style>
        <?php
    }
}
