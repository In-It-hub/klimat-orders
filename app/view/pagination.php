<?php 
	$total_pages = $this->view_data['total_pages'];
	$pageno = $this->view_data['pageno'];
 ?>
<div class="paginnation">
    <ul>
        <?php echo '<li><a href="/orders/index/?status=' . $status_active . '&pageno=1" class="button primary"><<</a></li>'; ?>
        <?php 
        		for ($i=0; $i < $total_pages; $i++) { 
        			$page = $i+1;
        			if ($page == $pageno) {
        				echo '<li><a href="/orders/index/?status=' . $status_active . '&pageno=' . $page . '" class="button primary active">' . $page . '</a></li>';
        			} else {
        				echo '<li><a href="/orders/index/?status=' . $status_active . '&pageno=' . $page . '" class="button primary">' . $page . '</a></li>';
        			}
        		}
         ?>
        <?php echo '<li><a href="/orders/index/?status=' . $status_active . '&pageno=' . $total_pages . '" class="button primary">>></a></li>'; ?>
    </ul>
</div>