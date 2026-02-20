<?php
ob_start(); // Add output buffering
require_once 'db.php';
require_once 'functions/helpers.php';

// Redirect to dashboard if already logged in
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}

include 'includes/header.php';
?>

<h2>Student Registration Form</h2>
<p class="privacy-statement">We respect your privacy. All information provided is securely stored.</p>

<?php
// Display validation errors if any
if (isset($_SESSION['errors'])) {
    echo '<div class="alert alert-error">';
    foreach ($_SESSION['errors'] as $error) {
        echo '<p>❌ ' . htmlspecialchars($error) . '</p>';
    }
    echo '</div>';
    unset($_SESSION['errors']);
}
?>

<form id="registrationForm" action="process.php" method="POST">
    <div class="form-group">
        <label for="name">Full Name *</label>
        <input type="text" id="name" name="name" required 
               value="<?php echo isset($_SESSION['form_data']['name']) ? htmlspecialchars($_SESSION['form_data']['name']) : ''; ?>">
        <span class="error" id="nameError"></span>
    </div>

    <div class="form-group">
        <label for="reg_no">Registration Number *</label>
        <input type="text" id="reg_no" name="reg_no" required 
               placeholder="e.g., STU2024001"
               value="<?php echo isset($_SESSION['form_data']['reg_no']) ? htmlspecialchars($_SESSION['form_data']['reg_no']) : ''; ?>">
        <span class="error" id="regNoError"></span>
    </div>

    <div class="form-group">
        <label for="email">Email Address *</label>
        <input type="email" id="email" name="email" required 
               value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>">
        <span class="error" id="emailError"></span>
    </div>

    <div class="form-group">
        <label for="password">Password *</label>
        <input type="password" id="password" name="password" required>
        <span class="error" id="passwordError"></span>
        <small>Minimum 6 characters</small>
    </div>

    <div class="form-group">
        <label for="course">Course *</label>
        <select id="course" name="course" required>
            <option value="">Select a course</option>
            <option value="Computer Science" <?php echo (isset($_SESSION['form_data']['course']) && $_SESSION['form_data']['course'] == 'Computer Science') ? 'selected' : ''; ?>>Computer Science</option>
            <option value="Engineering" <?php echo (isset($_SESSION['form_data']['course']) && $_SESSION['form_data']['course'] == 'Engineering') ? 'selected' : ''; ?>>Engineering</option>
            <option value="Business" <?php echo (isset($_SESSION['form_data']['course']) && $_SESSION['form_data']['course'] == 'Business') ? 'selected' : ''; ?>>Business</option>
            <option value="Medicine" <?php echo (isset($_SESSION['form_data']['course']) && $_SESSION['form_data']['course'] == 'Medicine') ? 'selected' : ''; ?>>Medicine</option>
            <option value="Arts" <?php echo (isset($_SESSION['form_data']['course']) && $_SESSION['form_data']['course'] == 'Arts') ? 'selected' : ''; ?>>Arts</option>
        </select>
        <span class="error" id="courseError"></span>
    </div>

    <div class="form-group">
        <label>Gender *</label>
        <div class="radio-group">
            <label><input type="radio" name="gender" value="male" required 
                <?php echo (isset($_SESSION['form_data']['gender']) && $_SESSION['form_data']['gender'] == 'male') ? 'checked' : ''; ?>> Male</label>
            <label><input type="radio" name="gender" value="female" required
                <?php echo (isset($_SESSION['form_data']['gender']) && $_SESSION['form_data']['gender'] == 'female') ? 'checked' : ''; ?>> Female</label>
            <label><input type="radio" name="gender" value="other" required
                <?php echo (isset($_SESSION['form_data']['gender']) && $_SESSION['form_data']['gender'] == 'other') ? 'checked' : ''; ?>> Other</label>
        </div>
        <span class="error" id="genderError"></span>
    </div>

    <div class="form-group">
        <label for="age">Age (Optional)</label>
        <input type="number" id="age" name="age" min="1" max="120"
               value="<?php echo isset($_SESSION['form_data']['age']) ? htmlspecialchars($_SESSION['form_data']['age']) : ''; ?>">
        <span class="error" id="ageError"></span>
    </div>

    <div class="form-group">
        <button type="submit" name="register" class="btn-primary">Register</button>
        <button type="reset" class="btn-secondary" onclick="clearForm()">Reset</button>
    </div>
</form>

<?php
// Clear stored form data
unset($_SESSION['form_data']);
include 'includes/footer.php';
ob_end_flush();
?>
