<?php
class TestimonialController {
    private $storagePath;
    private $uploadDir;

    public function __construct() {
        $this->storagePath = __DIR__ . '/../../storage/testimonials.json';
        $this->uploadDir   = __DIR__ . '/../../public/uploads/';
    }

    private function load(): array {
        if (!file_exists($this->storagePath)) return [];
        return json_decode(file_get_contents($this->storagePath), true) ?: [];
    }

    private function persist(array $data): void {
        file_put_contents($this->storagePath, json_encode(array_values($data), JSON_PRETTY_PRINT));
    }

    private function handleUpload(string $field): ?string {
        if (empty($_FILES[$field]['name'])) return null;
        if (!is_dir($this->uploadDir)) mkdir($this->uploadDir, 0755, true);
        $ext     = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($ext, $allowed)) return null;
        $filename = 'ts_' . uniqid() . '.' . $ext;
        $dest     = $this->uploadDir . $filename;
        if (move_uploaded_file($_FILES[$field]['tmp_name'], $dest)) {
            return 'uploads/' . $filename;
        }
        return null;
    }

    public function index(): void {
        $testimonials = $this->load();
        $action       = $_GET['action'] ?? 'list';
        $editItem     = null;
        $activePage   = 'testimonials';

        if ($action === 'delete' && !empty($_GET['id'])) {
            $id = $_GET['id'];
            $testimonials = array_values(array_filter($testimonials, fn($t) => $t['id'] !== $id));
            $this->persist($testimonials);
            header('Location: ?testimonials');
            exit;
        }

        if ($action === 'edit' && !empty($_GET['id'])) {
            foreach ($testimonials as $t) {
                if ($t['id'] === $_GET['id']) { $editItem = $t; break; }
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id          = trim($_POST['id'] ?? '');
            $name        = trim($_POST['name'] ?? '');
            $position    = trim($_POST['position'] ?? '');
            $rate        = max(1, min(5, (int)($_POST['rate'] ?? 5)));
            $testimonial = trim($_POST['testimonial'] ?? '');
            $systemName  = trim($_POST['system_name'] ?? '');
            $imagePath   = $this->handleUpload('image');

            if ($id) {
                foreach ($testimonials as &$t) {
                    if ($t['id'] === $id) {
                        $t['name']        = $name;
                        $t['position']    = $position;
                        $t['rate']        = $rate;
                        $t['testimonial'] = $testimonial;
                        $t['system_name'] = $systemName;
                        if ($imagePath) $t['image'] = $imagePath;
                        break;
                    }
                }
                unset($t);
            } else {
                $testimonials[] = [
                    'id'          => uniqid('ts_'),
                    'image'       => $imagePath ?? '',
                    'name'        => $name,
                    'position'    => $position,
                    'rate'        => $rate,
                    'testimonial' => $testimonial,
                    'system_name' => $systemName,
                ];
            }
            $this->persist($testimonials);
            header('Location: ?testimonials');
            exit;
        }

        include __DIR__ . '/../Views/admin/testimonials.php';
    }
}
