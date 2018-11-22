<?php

    function showError($text_error) {
        echo '<div class="text-danger text-center mt-4 font-weight-bold" 
                    style="font-size: 120%;">'.$text_error.'</div>';
    }

    function writeArchievePaginator($page, $total_pages) {
        if ( ($total_pages > 1) && ($total_pages < 6) ) {
            echo '<div class="archieve-paginator">';

            for ($i = 1; $i <= $total_pages; $i++) {
                if ( $i == $page ) {
                    echo '<a class="current-page-link" 
                                        href="/pages/archieve.php?page='.$i.'">'.$i.'</a>';
                } else {
                    echo '<a href="/pages/archieve.php?page='.$i.'">'.$i.'</a>';
                }
            }

            echo '</div>';
        }

        if ( ($total_pages >= 6) ) {
            echo '<div class="archieve-paginator">';

            if ($page == 1) {
                echo '<a class="current-page-link" 
                                        href="/pages/archieve.php?page=1"> 1 </a>';
                echo '<a href="/pages/archieve.php?page='.($page + 1).'">'.($page + 1).'</a>';
                echo '<a href="/pages/archieve.php?page='.($page + 2).'">'.($page + 2).'</a>';
            }

            if ($page > 1) {
                echo '<a href="/pages/archieve.php?page=1"> 1 </a>';
            }

            if ( $page == 2 ) {
                echo '<a class="current-page-link" 
                                        href="/pages/archieve.php?page='.$page.'">'.$page.'</a>';
                echo '<a href="/pages/archieve.php?page='.($page + 1).'">'.($page + 1).'</a>';
                echo '<a href="/pages/archieve.php?page='.($page + 2).'">'.($page + 2).'</a>';
            }

            if ($page >= 4) {
                echo '<span style="margin: 0px 5px;"> ... </span>';
            }

            if ( ($page > 2) && ($page < ($total_pages - 1)) ) {
                echo '<a href="/pages/archieve.php?page=' . ($page - 1) . '">'.($page - 1).'</a>';
                echo '<a class="current-page-link" 
                                        href="/pages/archieve.php?page='.$page.'">'.$page.'</a>';
                echo '<a href="/pages/archieve.php?page=' . ($page + 1) . '">'.($page + 1).'</a>';
            }

            if ( $page <= ($total_pages - 3) ) {
                echo '<span style="margin: 0px 5px;"> ... </span>';
            }

            if ( $page == ($total_pages - 1) ) {
                echo '<a href="/pages/archieve.php?page='.($page - 2).'">'.($page - 2).'</a>';
                echo '<a href="/pages/archieve.php?page='.($page - 1).'">'.($page - 1).'</a>';
                echo '<a class="current-page-link" 
                                        href="/pages/archieve.php?page='.$page.'">'.$page.'</a>';
            }

            if ($page < $total_pages) {
                echo '<a href="/pages/archieve.php?page='.$total_pages.'">'.$total_pages.'</a>';
            }

            if ($page == $total_pages) {
                echo '<a href="/pages/archieve.php?page='.($page - 2).'">'.($page - 2).'</a>';
                echo '<a href="/pages/archieve.php?page='.($page - 1).'">'.($page - 1).'</a>';
                echo '<a class="current-page-link" 
                                        href="/pages/archieve.php?page='.$total_pages.'">'.$total_pages.'</a>';
            }

            echo '</div>';
        }
    }


