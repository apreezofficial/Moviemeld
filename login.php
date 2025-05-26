<?php
session_start();
require 'pdo.php';  // PDO connection
if (isset($_SESSION['user']['id'])) {
    // If a redirect_url is set, use it and unset it after redirect
    if (!empty($_SESSION['redirect_url'])) {
        $redirect = $_SESSION['redirect_url'];
        unset($_SESSION['redirect_url']);
        header("Location: $redirect");
    } else {
        header("Location: index.php");
    }
    exit;
}
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userInput = trim($_POST['user'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($userInput)) {
        $errors[] = "Please enter your username or email.";
    }
    if (empty($password)) {
        $errors[] = "Please enter your password.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :user OR email = :user LIMIT 1");
        $stmt->execute(['user' => $userInput]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'name' => $user['name'],
                'profile_pic' => $user['profile_pic'] ?? 'assets/img/default-profile.png'
            ];

            // Redirect to stored URL or dashboard
            $redirect = $_SESSION['redirect_url'] ?? 'index.php';
            unset($_SESSION['redirect_url']); // clear it after using
            header("Location: $redirect");
            exit;
        } else {
            $errors[] = "Invalid username/email or password.";
        }
    }
}
?>
<!-- The rest of your HTML form remains unchanged -->
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="./font-awesome/css/all.css">
    <title>Moviemeld - Your Movie Hub</title>
    <script src="tailwind.js"></script>
    <script>
      // Tailwind dark mode config
      tailwind.config = {
        darkMode: 'class',
        theme: {
          extend: {},
        }
      }
    </script>
</head>
<body class="bg-[#0D0D0D] text-[#EAEAEA] flex items-center justify-center min-h-screen px-4">
  <main class="max-w-md w-full bg-[#1F1F1F] rounded-lg shadow-lg p-8 border border-[#8A2BE2]">
    <h1 class="text-3xl font-bold mb-6 text-center text-[#FF6B00]">Login to MovieMeld</h1>

    <?php if ($errors): ?>
      <div class="bg-[#FF6B00] bg-opacity-20 text-[#FF6B00] p-3 rounded mb-6 border border-[#FF6B00]">
        <ul class="list-disc list-inside">
          <?php foreach ($errors as $error): ?>
            <li><?=htmlspecialchars($error)?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="POST" action="" class="space-y-6" novalidate>
      <div>
        <label for="email" class="block mb-2 font-semibold text-[#8A2BE2]">Username/Email Address</label>
        <input
          id="email"
          name="user"
          
          required
          value="<?=htmlspecialchars($_POST['email'] ?? '')?>"
          class="w-full px-4 py-3 rounded bg-[#0D0D0D] border border-[#6F42C1] focus:outline-none focus:ring-2 focus:ring-[#FF6B00] text-[#EAEAEA]"
          placeholder="your username or email"
          autocomplete="email"
        />
      </div>

      <div>
        <label for="password" class="block mb-2 font-semibold text-[#8A2BE2]">Password</label>
        <input
          id="password"
          name="password"
          type="password"
          required
          class="w-full px-4 py-3 rounded bg-[#0D0D0D] border border-[#6F42C1] focus:outline-none focus:ring-2 focus:ring-[#FF6B00] text-[#EAEAEA]"
          placeholder="********"
          autocomplete="current-password"
        />
      </div>

      <button
        type="submit"
        class="w-full bg-[#FF6B00] hover:bg-[#e65c00] transition py-3 rounded font-bold text-[#0D0D0D]"
      >
        Login
      </button>
    </form>

    <p class="mt-6 text-center text-[#A1A1A1]">
      Don't have an account? 
      <a href="register.php" class="text-[#8A2BE2] hover:underline">Sign up here</a>
    </p>
  </main>
</body>
</html>