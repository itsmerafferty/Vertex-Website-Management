<?php
class CombinedEmployeesController
{

    private string $filter;
    private string $storagePath;
    private string $uploadDir;

    public function __construct()
    {
        $this->uploadDir   = __DIR__ . '/../../public/uploads/';
        $this->filter      = in_array($_GET['filter'] ?? '', ['top', 'regular'])
            ? $_GET['filter']
            : 'top';
        $this->storagePath = __DIR__ . '/../../storage/' . $this->filter . '_employees.json';
    }

    private function load(): array
    {
        if (!file_exists($this->storagePath)) return [];
        return json_decode(file_get_contents($this->storagePath), true) ?: [];
    }

    private function persist(array $data): void
    {
        file_put_contents($this->storagePath, json_encode(array_values($data), JSON_PRETTY_PRINT));
    }

    private function handleUpload(string $field): ?string
    {
        if (empty($_FILES[$field]['name'])) return null;
        if (!is_dir($this->uploadDir)) mkdir($this->uploadDir, 0755, true);
        $ext     = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($ext, $allowed)) return null;
        $filename = 'emp_' . uniqid() . '.' . $ext;
        if (move_uploaded_file($_FILES[$field]['tmp_name'], $this->uploadDir . $filename)) {
            return 'uploads/' . $filename;
        }
        return null;
    }

    public function index(): void
    {
        $employees  = $this->load();
        $filter     = $this->filter;
        $action     = $_GET['action'] ?? 'list';
        $search     = trim($_GET['q'] ?? '');
        $editItem   = null;
        $activePage = 'employees';

        if ($search) {
            $employees = array_filter($employees, function ($emp) use ($search) {
                return stripos($emp['name'], $search) !== false ||
                    stripos($emp['position'] ?? '', $search) !== false ||
                    stripos($emp['description'] ?? '', $search) !== false;
            });
        }

        if ($action === 'delete' && !empty($_GET['id'])) {
            $id        = $_GET['id'];
            $employees = array_values(array_filter($employees, fn($e) => $e['id'] !== $id));
            $this->persist($employees);
            header("Location: ?employees&filter={$filter}");
            exit;
        }

        if ($action === 'edit' && !empty($_GET['id'])) {
            foreach ($employees as $emp) {
                if ($emp['id'] === $_GET['id']) {
                    $editItem = $emp;
                    break;
                }
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
                    'id'          => uniqid('emp_'),
                    'image'       => $imagePath ?? '',
                    'name'        => $name,
                    'position'    => $position,
                    'description' => $description,
                    'email'       => $email,
                    'linkedin'    => $linkedin,
                ];
            }
            $this->persist($employees);
            header("Location: ?employees&filter={$filter}");
            exit;
        }

        include __DIR__ . '/../Views/admin/employees.php';
    }
}
