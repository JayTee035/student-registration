<?php
// dashboard.php
ob_start();
require_once 'db.php';
require_once 'functions/helpers.php';

// Check if user is logged in
if (!isLoggedIn()) {
    setFlashMessage('error', 'Please register or login to access the dashboard');
    header('Location: index.php');
    exit();
}

include 'includes/header.php';
?>

<div class="welcome-section">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! 👋</h2>
    <p class="welcome-message">Your registration was successful. Here are your details:</p>
</div>

<?php
// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($user):
?>

<div class="dashboard-card">
    <h3>📋 Your Registration Details</h3>
    <div class="user-details-grid">
        <div class="detail-item">
            <span class="detail-label">Full Name:</span>
            <span class="detail-value"><?php echo htmlspecialchars($user['name']); ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Registration Number:</span>
            <span class="detail-value"><?php echo htmlspecialchars($user['registration_number']); ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Email Address:</span>
            <span class="detail-value"><?php echo htmlspecialchars($user['email']); ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Course:</span>
            <span class="detail-value"><?php echo htmlspecialchars($user['course']); ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Gender:</span>
            <span class="detail-value"><?php echo ucfirst(htmlspecialchars($user['gender'])); ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Age:</span>
            <span class="detail-value"><?php echo $user['age'] ? htmlspecialchars($user['age']) : 'Not provided'; ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Registered on:</span>
            <span class="detail-value"><?php echo date('F j, Y \a\t g:i a', strtotime($user['created_at'])); ?></span>
        </div>
    </div>
</div>

<div class="dashboard-card">
    <h3>🔒 Privacy & Security</h3>
    <div class="privacy-features">
        <div class="feature">
            <span class="feature-icon">✅</span>
            <span>Your password is encrypted</span>
        </div>
        <div class="feature">
            <span class="feature-icon">✅</span>
            <span>Data is securely stored</span>
        </div>
        <div class="feature">
            <span class="feature-icon">✅</span>
            <span>Session is protected</span>
        </div>
    </div>
</div>

<div class="dashboard-actions">
    <a href="logout.php" class="btn-logout">🚪 Logout</a>
    <a href="index.php" class="btn-home">🏠 Home</a>
</div>

<?php else: ?>
    <div class="alert alert-error">Unable to fetch your details. Please try again.</div>
<?php endif; ?>

<?php
include 'includes/footer.php';
ob_end_flush();
?>
