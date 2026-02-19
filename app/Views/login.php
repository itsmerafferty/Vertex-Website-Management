<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login — Vertex Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --bg: #f8fafc;
            --fg: #18181b;
            --primary: #6366f1;
            --primary-dark: #4338ca;
            --border: #e5e7eb;
            --card-bg: #fff;
            --radius: 0.5rem;
            --danger: #ef4444;
            --muted: #52525b;
        }
        *, *::before, *::after { box-sizing: border-box; }
        body {
            background: var(--bg);
            color: var(--fg);
            font-family: 'Inter', Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-wrap {
            width: 100%;
            max-width: 400px;
            padding: 1rem;
        }
        .login-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            padding: 2.5rem 2rem;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-logo h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary);
            margin: 0 0 0.25rem 0;
        }
        .login-logo p {
            font-size: 0.875rem;
            color: var(--muted);
            margin: 0;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
            margin-bottom: 1rem;
        }
        label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--muted);
        }
        input[type="text"],
        input[type="password"] {
            padding: 0.6rem 0.85rem;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--fg);
            background: #fafafa;
            width: 100%;
            transition: border-color 0.15s, background 0.15s;
        }
        input:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
        }
        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: var(--radius);
            color: var(--danger);
            font-size: 0.875rem;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
        }
        .btn-submit {
            width: 100%;
            padding: 0.7rem 1rem;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: var(--radius);
            font-family: inherit;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s;
            margin-top: 0.5rem;
        }
        .btn-submit:hover { background: var(--primary-dark); }
        .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.82rem;
            color: var(--muted);
        }
    </style>
</head>
<body>
    <div class="login-wrap">
        <div class="login-card">
            <div class="login-logo">
                <h1>Vertex Admin</h1>
                <p>Sign in to manage your website</p>
            </div>

            <?php if (!empty($error)): ?>
            <div class="error-box"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="?login" onsubmit="this.querySelector('button').disabled=true">
                <div class="form-group">
                    <label for="username">Email</label>
                    <input type="text" id="username" name="username"
                           autocomplete="email" autofocus required
                           placeholder="Enter your email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password"
                           autocomplete="current-password" required
                           placeholder="Enter your password">
                </div>
                <button type="submit" class="btn-submit">Sign In</button>
            </form>

            <div class="login-footer">Department 1 access only</div>
        </div>
    </div>
</body>
</html>
