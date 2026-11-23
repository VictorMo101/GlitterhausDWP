<?php
class AdminController {
    private $admin;

    public function __construct($admin) {
        $this->admin = $admin;
    }

    public function admin() {
        if (!is_admin()) {
            redirect_to('index.php?page=home');
        }

        require_once __DIR__ . "/../views/admin/adminDashboard.php";
    }

    public function adminAbout() {
        if (!is_admin()) {
            redirect_to('index.php?page=home');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (!csrf_validate($token)) {
                http_response_code(403);
                exit('Invalid form submission.');
            }

            $action = $_POST['action'] ?? '';
            $aboutId = filter_input(INPUT_POST, 'aboutId', FILTER_VALIDATE_INT);
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $displayOrder = filter_input(INPUT_POST, 'displayOrder', FILTER_VALIDATE_INT);

            try {
                if ($action === 'create') {
                    if ($title === '' || $content === '' || $displayOrder === false || $displayOrder === null) {
                        throw new InvalidArgumentException('Title, content, and display order are required.');
                    }
                    $this->admin['about']->createSection($title, $content, $displayOrder);
                    $_SESSION['admin_about_message'] = 'Section added successfully.';
                } elseif ($action === 'update') {
                    if (!$aboutId || $title === '' || $content === '' || $displayOrder === false || $displayOrder === null) {
                        throw new InvalidArgumentException('A valid section, title, content, and display order are required.');
                    }
                    $this->admin['about']->updateSection($aboutId, $title, $content, $displayOrder);
                    $_SESSION['admin_about_message'] = 'Section updated successfully.';
                } elseif ($action === 'delete') {
                    if (!$aboutId) {
                        throw new InvalidArgumentException('A valid section is required.');
                    }
                    $this->admin['about']->deleteSection($aboutId);
                    $_SESSION['admin_about_message'] = 'Section deleted successfully.';
                } else {
                    throw new InvalidArgumentException('Unknown action.');
                }
            } catch (InvalidArgumentException | PDOException $exception) {
                $_SESSION['admin_about_message'] = $exception instanceof PDOException
                    ? 'The section could not be saved. Please try again.'
                    : $exception->getMessage();
            }

            redirect_to('index.php?page=adminAbout');
        }

        $sections = $this->admin['about']->getSections();
        $adminAboutMessage = $_SESSION['admin_about_message'] ?? null;
        unset($_SESSION['admin_about_message']);
        require_once __DIR__ . "/../views/admin/adminAbout.php";
    }
}