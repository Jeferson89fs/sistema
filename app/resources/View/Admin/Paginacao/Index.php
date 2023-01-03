<nav aria-label="Page navigation example" class="d-flex justify-content-end">
    <ul class="pagination">

        <li class="page-item">
            <a class="page-link" href="<?=$prev?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>        

        <?=$link?>

        <li class="page-item">
            <a class="page-link" href="<?=$next?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        
    </ul>
</nav>