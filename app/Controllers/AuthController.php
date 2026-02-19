<?php
class AuthController {

    private const API_URL         = 'http://goatedcodoer:8090/items/user';
    private const ALLOWED_DEPT    = 1;
    private const REQUEST_TIMEOUT = 10;

    public function showLogin(): void {
        $error = $_SESSION['login_error'] ?? null;
        unset($_SESSION['login_error']);
        include __DIR__ . '/../Views/login.php';
    }

    public function login(): void {
        $email    = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $_SESSION['login_error'] = 'Please enter your email and password.';
            header('Location: ?login');
            exit;
        }

        $ch = curl_init(self::API_URL);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD        => $email . ':' . $password,
            CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
            CURLOPT_TIMEOUT        => self::REQUEST_TIMEOUT,
            CURLOPT_HTTPHEADER     => ['Accept: application/json'],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr  = curl_error($ch);
        curl_close($ch);

        if ($curlErr || $response === false) {
            $_SESSION['login_error'] = 'Could not reach the authentication server. Please try again.';
            header('Location: ?login');
            exit;
        }

        if ($httpCode === 401 || $httpCode === 403) {
            $_SESSION['login_error'] = 'Invalid email or password.';
            header('Location: ?login');
            exit;
        }

        if ($httpCode !== 200) {
            $_SESSION['login_error'] = 'Authentication server error (HTTP ' . $httpCode . ').';
            header('Location: ?login');
            exit;
        }

        $decoded = json_decode($response, true);
        $users   = $this->extractUsers($decoded);

        if (empty($users)) {
            $_SESSION['login_error'] = 'No user data returned from the server.';
            header('Location: ?login');
            exit;
        }

        // Match by user_email; fall back to first record (API already validated credentials)
        $matchedUser = null;
        foreach ($users as $user) {
            if (!is_array($user)) continue;
            if (isset($user['user_email']) && strtolower($user['user_email']) === strtolower($email)) {
                $matchedUser = $user;
                break;
            }
        }
        if ($matchedUser === null) {
            $matchedUser = $users[0];
        }

        if (!is_array($matchedUser)) {
            $_SESSION['login_error'] = 'Could not identify the authenticated user.';
            header('Location: ?login');
            exit;
        }

        // Department check — field is user_department
        $department = (int)($matchedUser['user_department'] ?? 0);

        if ($department !== self::ALLOWED_DEPT) {
            $_SESSION['login_error'] = 'Access denied. Only Department 1 members can access this panel.';
            header('Location: ?login');
            exit;
        }

        $_SESSION['logged_in'] = true;
        $_SESSION['user']      = $matchedUser;
        header('Location: ?admin');
        exit;
    }

    private function extractUsers($decoded): array {
        if (!is_array($decoded)) return [];

        // Bare indexed array: [{...}, {...}]
        if (isset($decoded[0]) && is_array($decoded[0])) {
            return $decoded;
        }

        // Wrapped response: {"data": [...]}
        if (isset($decoded['data']) && is_array($decoded['data'])) {
            return $decoded['data'];
        }

        // Single user object: {"user_id": 1, "user_email": "...", ...}
        if (isset($decoded['user_id']) || isset($decoded['user_email'])) {
            return [$decoded];
        }

        return [];
    }

    public function logout(): void {
        session_unset();
        session_destroy();
        header('Location: ?login');
        exit;
    }
}
