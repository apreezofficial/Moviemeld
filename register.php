<?php
session_start();
require 'pdo.php';
error_reporting(0);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Combine name
    $name = ucfirst($firstName) . ' ' . ucfirst($lastName);

    // Default profile picture
    $profile_pic = "https://ui-avatars.com/api/?name=" . urlencode($name) . "&background=8A2BE2&color=fff";

    // Validation
    if (!$firstName || !$lastName) $errors[] = "Please enter your full name.";
    if (!$username) $errors[] = "Username is required.";
    if (!$email) $errors[] = "A valid email is required.";
    if (!$password || strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if ($password !== $confirmPassword) $errors[] = "Passwords do not match.";

    // Check if email or username already exists
    if (empty($errors)) {
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $check->execute([$email, $username]);
        if ($check->fetch()) {
            $errors[] = "Email or username already in use.";
        }
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO users (name, username, email, password, profile_pic) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $username, $email, $hashedPassword, $profile_pic]);

        $userId = $pdo->lastInsertId();
        $_SESSION['user'] = [
            'id' => $userId,
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'profile_pic' => $profile_pic
        ];

        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
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
<body class="bg-[#0D0D0D] text-[#EAEAEA] flex items-center justify-center min-h-screen">
  <div class="bg-[#1A1A1A] p-8 rounded-xl shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-[#8A2BE2]">Create Your Account</h2>

    <?php if ($errors): ?>
      <div class="bg-red-600 text-white p-3 rounded mb-4 text-sm">
        <?php foreach ($errors as $error): ?>
          <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <div class="flex gap-3">
        <input type="text" name="first_name" placeholder="First Name" value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>" required class="w-1/2 p-2 rounded bg-[#2A2A2A] border border-[#6F42C1] focus:outline-none" />
        <input type="text" name="last_name" placeholder="Last Name" value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>" required class="w-1/2 p-2 rounded bg-[#2A2A2A] border border-[#6F42C1] focus:outline-none" />
      </div>
      <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required class="w-full p-2 rounded bg-[#2A2A2A] border border-[#6F42C1] focus:outline-none" />
      <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required class="w-full p-2 rounded bg-[#2A2A2A] border border-[#6F42C1] focus:outline-none" />
      <input type="password" name="password" placeholder="Password" required class="w-full p-2 rounded bg-[#2A2A2A] border border-[#6F42C1] focus:outline-none" />
      <input type="password" name="confirm_password" placeholder="Confirm Password" required class="w-full p-2 rounded bg-[#2A2A2A] border border-[#6F42C1] focus:outline-none" />
      <button type="submit" class="w-full py-2 bg-[#8A2BE2] hover:bg-[#6F42C1] rounded text-white font-bold transition">Register</button>
    </form>
    <p class="mt-4 text-sm text-center text-[#A1A1A1]">Already have an account? <a href="login.php" class="text-[#FF6B00] hover:underline">Login</a></p>
  </div>
</body>
</html>