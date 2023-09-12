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
        '../admins/dashboard.php' => array(
            'icon' => 'bx bx-grid-alt',
            'label' => 'Dashboard'
        ),
        '../crud/residents.php' => array(
            'icon' => 'bx bx-user',
            'label' => 'Residents'
        ),
        '../admins/announcement.php' => array(
            'icon' => 'bx bx-file',
            'label' => 'Post'
        ),
        '../admins/booking.php' => array(
            'icon' => 'bx bx-calendar',
            'label' => 'Booking'
        ),
        '../admins/account.php' => array(
            'icon' => 'bx bxs-user-account',
            'label' => 'Pending Account'
        ),
        '../map/index.php' => array(
          'icon' => 'bx bx-map',
          'label' => 'Map'
        ),
        '../admins/logout.php' => array(
            'icon' => 'bx bx-power-off',
            'label' => 'Logout'
        )
        ),
    
  'vicepresident' => array(
    '../admins/dashboard.php' => array(
      'icon' => 'bx bx-grid-alt',
      'label' => 'Dashboard'
    ),
    '../admins/financial_reports.php' => array(
      'icon' => 'bx bx-chart',
      'label' => 'Financial Reports'
    ),
    '../admins/account.php' => array(
      'icon' => 'bx bxs-user-account',
      'label' => 'Account'
    ),
    '../admins/logout.php' => array(
      'icon' => 'bx bx-power-off',
      'label' => 'Logout'
    )
  ),
  'secretary' => array(
    '../admins/dashboard.php' => array(
      'icon' => 'bx bx-grid-alt',
      'label' => 'Dashboard'
    ),
    '../admins/meeting_records.php' => array(
      'icon' => 'bx bx-file',
      'label' => 'Meeting Records'
    ),
    '../admins/residents.php' => array(
      'icon' => 'bx bx-user',
      'label' => 'Residents'
    ),
    '../admins/account.php' => array(
      'icon' => 'bx bxs-user-account',
      'label' => 'Account'
    ),
    '../admins/logout.php' => array(
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