<?php
class AdminController
{
    public function dashboard()
    {
        // Helper to load JSON
        $loadJson = function ($filename) {
            $path = __DIR__ . '/../../storage/' . $filename;
            if (!file_exists($path)) return [];
            return json_decode(file_get_contents($path), true) ?: [];
        };

        $regularEmployees = $loadJson('regular_employees.json');
        $topEmployees     = $loadJson('top_employees.json');
        $testimonials     = $loadJson('testimonials.json');

        $totalEmployees    = count($regularEmployees) + count($topEmployees);
        $topEmployeesCount = count($topEmployees);
        $testimonialsCount = count($testimonials);

        // Try to include models or query DB directly if no models exist yet
        // For now, we are using the JSON storage as our data source

        include __DIR__ . '/../Views/admin/dashboard.php';
    }
}
