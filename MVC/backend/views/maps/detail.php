<?php
require_once 'helpers/Helper.php';
?>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td><?php echo $map['id']?></td>
    </tr>

    <tr>
        <th>Title</th>
        <td><?php echo $map['title']?></td>
    </tr>
    <tr>
        <th>Hotline</th>
        <td><?php echo $map['hotline']?></td>
    </tr>
    <tr>
        <th>Fax</th>
        <td><?php echo $map['fax']?></td>
    </tr><tr>
        <th>Email</th>
        <td><?php echo $map['email']?></td>
    </tr>

    <tr>
        <th>Summary</th>
        <td><?php echo $map['summary']?></td>
    </tr>

    <tr>
        <th>Map_url</th>
        <td><?php echo $map['map_url']?></td>
    </tr>
    <tr>
        <th>Status</th>
        <td><?php echo Helper::getStatusText($map['status']) ?></td>
    </tr>
    <tr>
        <th>Created at</th>
        <td><?php echo date('d-m-Y H:i:s', strtotime($map['created_at'])) ?></td>
    </tr>
    <tr>
        <th>Updated at</th>
        <td><?php echo !empty($map['updated_at']) ? date('d-m-Y H:i:s', strtotime($map['updated_at'])) : '--' ?></td>
    </tr>
</table>
<a href="index.php?controller=map&action=index" class="btn btn-primary">Back</a>