<?php
class VertexRegularEmployee {
    public $image;
    public $name;
    public $position;
    public $description;
    public $email;
    public $linkedin;

    public function __construct($image, $name, $position, $description, $email, $linkedin) {
        $this->image       = $image;
        $this->name        = $name;
        $this->position    = $position;
        $this->description = $description;
        $this->email       = $email;
        $this->linkedin    = $linkedin;
    }

    public function render() {
        ?>
        <div class="vre-card">
            <img src="<?= htmlspecialchars($this->image) ?>" alt="<?= htmlspecialchars($this->name) ?>" class="vre-img" />
            <div class="vre-info">
                <h3 class="vre-name"><?= htmlspecialchars($this->name) ?></h3>
                <p class="vre-position"><?= htmlspecialchars($this->position) ?></p>
                <p class="vre-desc"><?= htmlspecialchars($this->description) ?></p>
                <div class="vre-links">
                    <a href="mailto:<?= htmlspecialchars($this->email) ?>" class="vre-link">Email</a>
                    <a href="<?= htmlspecialchars($this->linkedin) ?>" class="vre-link" target="_blank">LinkedIn</a>
                </div>
            </div>
        </div>
        <style>
            .vre-card {
                display: flex;
                align-items: flex-start;
                background: #fff;
                border: 1px solid #e5e7eb;
                border-radius: 0.5rem;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
                padding: 1.25rem;
                gap: 1.25rem;
                max-width: 480px;
                margin: 1.5rem auto;
            }
            .vre-img {
                width: 72px;
                height: 72px;
                object-fit: cover;
                border-radius: 0.5rem;
                border: 2px solid #e5e7eb;
                flex-shrink: 0;
            }
            .vre-info { flex: 1; }
            .vre-name {
                font-size: 1.1rem;
                font-weight: 600;
                margin: 0 0 0.2em 0;
                color: #18181b;
            }
            .vre-position {
                font-size: 0.9rem;
                color: #6366f1;
                margin: 0 0 0.5em 0;
                font-weight: 500;
            }
            .vre-desc {
                color: #52525b;
                font-size: 0.92rem;
                margin-bottom: 0.75em;
            }
            .vre-links { display: flex; gap: 1em; }
            .vre-link {
                color: #6366f1;
                text-decoration: none;
                font-size: 0.88rem;
                font-weight: 500;
                transition: color 0.15s;
            }
            .vre-link:hover { color: #4338ca; text-decoration: underline; }
        </style>
        <?php
    }
}
