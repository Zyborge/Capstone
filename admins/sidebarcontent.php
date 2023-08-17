<?php
session_start();
require('../configs/config.php');

// Check if the user is authenticated
if (!isset($_SESSION['user_role'])) {
  // User is not logged in, redirect to the login page
  header("Location: index.php");
  exit;
}

// Get the user's role from the session
$userRole = $_SESSION['user_role'];

// Define the sidebar links based on user roles
$sidebarLinks = array(
    'president' => array(
        'dashboard.php' => array(
            'icon' => 'bx bx-grid-alt',
            'label' => 'Dashboard'
        ),
        'residents.php' => array(
            'icon' => 'bx bx-user',
            'label' => 'Residents'
        ),
        'announcement.php' => array(
            'icon' => 'bx bx-file',
            'label' => 'Post'
        ),
        'booking.php' => array(
            'icon' => 'bx bx-calendar',
            'label' => 'Booking'
        ),
        'account.php' => array(
            'icon' => 'bx bxs-user-account',
            'label' => 'Pending Account'
        ),
        'logout.php' => array(
            'icon' => 'bx bx-power-off',
            'label' => 'Logout'
        )
        ),
    
  'vicepresident' => array(
    'dashboard.php' => array(
      'icon' => 'bx bx-grid-alt',
      'label' => 'Dashboard'
    ),
    'financial_reports.php' => array(
      'icon' => 'bx bx-chart',
      'label' => 'Financial Reports'
    ),
    'account.php' => array(
      'icon' => 'bx bxs-user-account',
      'label' => 'Account'
    ),
    'logout.php' => array(
      'icon' => 'bx bx-power-off',
      'label' => 'Logout'
    )
  ),
  'secretary' => array(
    'dashboard.php' => array(
      'icon' => 'bx bx-grid-alt',
      'label' => 'Dashboard'
    ),
    'meeting_records.php' => array(
      'icon' => 'bx bx-file',
      'label' => 'Meeting Records'
    ),
    'residents.php' => array(
      'icon' => 'bx bx-user',
      'label' => 'Residents'
    ),
    'account.php' => array(
      'icon' => 'bx bxs-user-account',
      'label' => 'Account'
    ),
    'logout.php' => array(
      'icon' => 'bx bx-power-off',
      'label' => 'Logout'
    )
  )
);

// Function to generate sidebar links based on user role
function generateSidebarLinks($links)
{
  global $userRole;
  $output = '';
  foreach ($links[$userRole] as $url => $link) {
    $activeClass = '';
    if (basename($_SERVER['PHP_SELF']) === $url) {
      $activeClass = 'active';
    }
    $output .= '<li class="nav-item">
        <a href="' . $url . '" class="nav-link ' . $userRole . ' ' . $activeClass . '">
          <i class="' . $link['icon'] . '"></i>
          <span class="links_name">' . $link['label'] . '</span>
        </a>
      </li>';
  }
  return $output;
}
?>