<div id="page-about">
    <div class="container">
        <div class="row">
            <div class="col-md-12" id="layout-page">
                <div class="content-page">
                    <?php foreach ($introduces as $introduce): ?>
                    <h2><?php echo $introduce['title']; ?></h2>
                    <p><?php echo $introduce['summary']; ?></p>
                        <p><?php echo $introduce['content']; ?></p>
                    <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>