<?php
require 'db.php';

// Fetch messages
$messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

// Fetch career applications
$careers = $pdo->query("SELECT * FROM careers ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Livetech Solutions</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CDN -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body { background-color: #f9f9f9; font-family: 'Segoe UI', sans-serif; }
    .container { padding-top: 40px; }
    .section-title { color: #333; margin-bottom: 1rem; font-weight: bold; }
    table { font-size: 0.95rem; }
    .table thead { background-color: #212529; color: #fff; }
    .resume-link { color: #007bff; text-decoration: underline; }
  </style>
</head>
<body>
  <div class="container">
    <h2 class="text-center mb-4 text-warning">Livetech Admin Dashboard</h2>

    <!-- Messages Section -->
    <div class="mb-5">
      <h4 class="section-title">💬 Messages</h4>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Message</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($messages as $msg): ?>
              <tr>
                <td><?= htmlspecialchars($msg['name']) ?></td>
                <td><?= htmlspecialchars($msg['phone']) ?></td>
                <td><?= htmlspecialchars($msg['email']) ?></td>
                <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                <td><?= $msg['created_at'] ?></td>
              </tr>
            <?php endforeach; ?>
            <?php if (empty($messages)) echo '<tr><td colspan="5" class="text-center text-muted">No messages found.</td></tr>'; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Careers Section -->
    <div class="mb-5">
      <h4 class="section-title">📄 Career Applications</h4>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Position</th>
              <th>Experience (yrs)</th>
              <th>Details</th>
              <th>Resume</th>
              <th>Submitted</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($careers as $c): ?>
              <tr>
                <td><?= htmlspecialchars($c['name']) ?></td>
                <td><?= htmlspecialchars($c['phone']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td><?= htmlspecialchars($c['position']) ?></td>
                <td><?= (int)$c['experience'] ?></td>
                <td><?= nl2br(htmlspecialchars($c['details'])) ?></td>
                <td>
                  <?php if (!empty($c['resume'])): ?>
                    <a class="resume-link" href="<?= htmlspecialchars($c['resume']) ?>" target="_blank">View</a>
                  <?php else: ?>
                    <span class="text-muted">No file</span>
                  <?php endif; ?>
                </td>
                <td><?= $c['created_at'] ?></td>
              </tr>
            <?php endforeach; ?>
            <?php if (empty($careers)) echo '<tr><td colspan="8" class="text-center text-muted">No applications found.</td></tr>'; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</body>
</html>
