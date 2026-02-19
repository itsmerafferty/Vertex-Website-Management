<?php
class VertexTopEmployee {
    public $image;
    public $name;
    public $position;
    public $description;
    public $email;
    public $linkedin;

    public function __construct($image, $name, $position, $description, $email, $linkedin) {
        $this->image = $image;
        $this->name = $name;
        $this->position = $position;
        $this->description = $description;
        $this->email = $email;
        $this->linkedin = $linkedin;
    }

    public function render() {
        ?>
        <div class="vte-card">
            <img src="<?= htmlspecialchars($this->image) ?>" alt="<?= htmlspecialchars($this->name) ?>" class="vte-img" />
            <div class="vte-info">
                <h3 class="vte-name"><?= htmlspecialchars($this->name) ?></h3>
                <p class="vte-position"><?= htmlspecialchars($this->position) ?></p>
                <p class="vte-desc"><?= htmlspecialchars($this->description) ?></p>
                <div class="vte-links">
                    <a href="mailto:<?= htmlspecialchars($this->email) ?>" class="vte-link">Email</a>
                    <a href="<?= htmlspecialchars($this->linkedin) ?>" class="vte-link" target="_blank">LinkedIn</a>
                </div>
            </div>
        </div>
        <style>
            .vte-card {
                display: flex;
                align-items: flex-start;
                background: #fff;
                border: 1px solid #e5e7eb;
                border-radius: 0.5rem;
                box-shadow: 0 2px 8px rgba(0,0,0,0.04);
                padding: 1.5rem;
                gap: 1.5rem;
                max-width: 540px;
                margin: 2rem auto;
            }
            .vte-img {
                width: 96px;
                height: 96px;
                object-fit: cover;
                border-radius: 0.5rem;
                border: 2px solid #6366f1;
            }
            .vte-info {
                flex: 1;
            }
            .vte-name {
                font-size: 1.25rem;
                font-weight: 600;
                margin: 0 0 0.25em 0;
                color: #6366f1;
            }
            .vte-position {
                font-size: 1rem;
                color: #52525b;
                margin: 0 0 0.5em 0;
            }
            .vte-desc {
                color: #18181b;
                margin-bottom: 1em;
            }
            .vte-links {
                display: flex;
                gap: 1em;
            }
            .vte-link {
                color: #6366f1;
                text-decoration: none;
                font-weight: 500;
                transition: color 0.15s;
            }
            .vte-link:hover {
                color: #4338ca;
                text-decoration: underline;
            }
        </style>
        <?php
    }
}
