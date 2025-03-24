<?php
require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';

$commentsPerPage = 6; // Number of comments to display per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number, default is 1

// Calculate the offset for comments retrieval
$offset = ($page - 1) * $commentsPerPage;

$stmt = $pdo->prepare("SELECT * FROM intra_mitarbeiter_log WHERE profilid = ? ORDER BY datetime DESC LIMIT ?, ?");
$stmt->execute([$_GET['id'], $offset, $commentsPerPage]);
$comments = $stmt->fetchAll();

foreach ($comments as $comment) {
    $commentType = '';
    switch ($comment['type']) {
        case 0:
            $commentType = 'note';
            break;
        case 1:
            $commentType = 'positive';
            break;
        case 2:
            $commentType = 'negative';
            break;
        case 4:
            $commentType = 'rank';
            break;
        case 5:
            $commentType = 'modify';
            break;
        case 6:
            $commentType = 'created';
            break;
        case 7:
            $commentType = 'document';
            break;
    }

    echo "<div class='comment $commentType border shadow-sm'>";
    $comtime = date("d.m.Y H:i", strtotime($comment['datetime']));
    echo "<p>{$comment['content']}<br><small><span><i class='las la-user'></i> {$comment['paneluser']} <i class='las la-clock'></i> $comtime";
    if ($fadmin && $comment['type'] <= 3 || $admin && $comment['type'] <= 3) {
        echo " / <a href='/admin/personal/comment-delete.php?id={$comment['logid']}&pid={$comment['profilid']}'><i class='las la-trash' style='color:red;margin-left:5px'></i></a></span></small></p>";
    } else {
        echo "</span></small></p>";
    }
    echo "</div>";
}


// Calculate the total number of comments
$totalComments = count($comments);

// Calculate the total number of pages
$totalPages = ceil($totalComments / $commentsPerPage);

// Display pagination links if there are more than one page
if ($totalPages > 1) {
    echo '<nav aria-label="Comment Pagination">';
    echo '<ul class="pagination justify-content-center">';

    $editArgument = isset($_GET['edit']) ? '&edit' : '';

    // Previous page link
    if ($page > 1) {
        echo '<li class="page-item"><a class="page-link" href="?id=' . $_GET['id'] . '&page=' . ($page - 1) . $editArgument . '">Zurück</a></li>';
    }

    // Page links
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $page) {
            echo '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
        } else {
            echo '<li class="page-item"><a class="page-link" href="?id=' . $_GET['id'] . '&page=' . $i . $editArgument . '">' . $i . '</a></li>';
        }
    }

    // Next page link
    if ($page < $totalPages) {
        echo '<li class="page-item"><a class="page-link" href="?id=' . $_GET['id'] . '&page=' . ($page + 1) . $editArgument . '">Weiter</a></li>';
    }

    echo '</ul>';
    echo '</nav>';
}
