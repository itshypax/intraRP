<?php

$commentsPerPage = 6; // Number of comments to display per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number, default is 1

// Calculate the offset for comments retrieval
$offset = ($page - 1) * $commentsPerPage;

$stmt = mysqli_prepare($conn, "SELECT * FROM personal_log WHERE profilid = ? ORDER BY datetime DESC LIMIT ?, ?");
mysqli_stmt_bind_param($stmt, "iii", $_GET['id'], $offset, $commentsPerPage);
mysqli_stmt_execute($stmt);
$comments = mysqli_stmt_get_result($stmt);

while ($comment = mysqli_fetch_array($comments)) {
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
    echo "<p>{$comment['content']}<br><small><span><em>- {$comment['paneluser']} / $comtime";
    if ($fadmin && $comment['type'] <= 3 || $admin && $comment['type'] <= 3) {
        echo " / <a href='/admin/personal/comment-delete.php?id={$comment['logid']}&pid={$comment['profilid']}'><i class='fa-solid fa-trash-can fa-xs' style='color:red;margin-left:5px'></i></a></em></span></small></p>";
    } else {
        echo "</em></span></small></p>";
    }
    echo "</div>";
}


// Calculate the total number of comments
$totalComments = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM personal_log WHERE profilid = " . $_GET['id']));

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
