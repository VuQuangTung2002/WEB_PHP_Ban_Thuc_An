<?php
require_once 'helpers/Helper.php';
?>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td><?php echo $introduce['id']?></td>
    </tr>

    <tr>
        <th>Title</th>
        <td><?php echo $introduce['title']?></td>
    </tr>
    <tr>
        <th>Summary</th>
        <td><?php echo $introduce['summary']?></td>
    </tr>
    <tr>
        <th>Avatar</th>
        <td>
            <?php if (!empty($introduce['avatar'])): ?>
                <img height="80" src="assets/uploads/<?php echo $introduce['avatar'] ?>"/>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th>Content</th>
        <td><?php echo $introduce['content']?></td>
    </tr>
    <tr>
        <th>Status</th>
        <td><?php echo Helper::getStatusText($introduce['status']) ?></td>
    </tr>
    <tr>
        <th>Created at</th>
        <td><?php echo date('d-m-Y H:i:s', strtotime($introduce['created_at'])) ?></td>
    </tr>
    <tr>
        <th>Updated at</th>
        <td><?php echo !empty($introduce['updated_at']) ? date('d-m-Y H:i:s', strtotime($introduce['updated_at'])) : '--' ?></td>
    </tr>
</table>
<a href="index.php?controller=introduce&action=index" class="btn btn-primary">Back</a>