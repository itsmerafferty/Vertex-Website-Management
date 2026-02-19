<?php
class RegularEmployeeController {
    private $storagePath;
    private $uploadDir;

    public function __construct() {
        $this->storagePath = __DIR__ . '/../../storage/regular_employees.json';
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
        $filename = 're_' . uniqid() . '.' . $ext;
        $dest     = $this->uploadDir . $filename;
        if (move_uploaded_file($_FILES[$field]['tmp_name'], $dest)) {
            return 'uploads/' . $filename;
        }
        return null;
    }

    public function index(): void {
        $employees  = $this->load();
        $action     = $_GET['action'] ?? 'list';
        $editItem   = null;
        $activePage = 'regular_employees';

        if ($action === 'delete' && !empty($_GET['id'])) {
            $id = $_GET['id'];
            $employees = array_values(array_filter($employees, fn($e) => $e['id'] !== $id));
            $this->persist($employees);
            header('Location: ?regular_employees');
            exit;
        }

        if ($action === 'edit' && !empty($_GET['id'])) {
            foreach ($employees as $emp) {
                if ($emp['id'] === $_GET['id']) { $editItem = $emp; break; }
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id          = trim($_POST['id'] ?? '');
            $name        = trim($_POST['name'] ?? '');
            $position    = trim($_POST['position'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $email       = trim($_POST['email'] ?? '');
            $linkedin    = trim($_POST['linkedin'] ?? '');
            $imagePath   = $this->handleUpload('image');

            if ($id) {
                foreach ($employees as &$emp) {
                    if ($emp['id'] === $id) {
                        $emp['name']        = $name;
                        $emp['position']    = $position;
                        $emp['description'] = $description;
                        $emp['email']       = $email;
                        $emp['linkedin']    = $linkedin;
                        if ($imagePath) $emp['image'] = $imagePath;
                        break;
                    }
                }
                unset($emp);
            } else {
                $employees[] = [
                    'id'          => uniqid('re_'),
                    'image'       => $imagePath ?? '',
                    'name'        => $name,
                    'position'    => $position,
                    'description' => $description,
                    'email'       => $email,
                    'linkedin'    => $linkedin,
                ];
            }
            $this->persist($employees);
            header('Location: ?regular_employees');
            exit;
        }

        include __DIR__ . '/../Views/admin/regular_employees.php';
    }
}
