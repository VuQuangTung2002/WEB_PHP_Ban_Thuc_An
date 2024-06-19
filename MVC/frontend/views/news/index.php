<?php
require_once 'helpers/Helper.php';
?>
<div id="blog">

    <div class="container">
        <div class="main-content row">
            <!-- Begin content -->
            <div class="blog-content col-md-12">
                <div class="row">
                    <div class="col-md-12">


                        <div class="newsletter ">
                            <div class="home-title">
                                <h2>Tin tức mới</h2>
                            </div>
                            <div class="row products-resize">


                                <?php foreach ($news as $new):
                                    $new_slug = Helper::getSlug($new['title']);
                                    $new_link = "chi-tiet-tin-tuc/$new_slug/" . $new['id'];

                                ?>
                                <div class="col-md-4  wow fadeInUp blog_all_1">
                                    <div class="news-item product-resize text-center">
                                        <div class="img-news image-resize">
                                            <a href="<?php echo $new_link; ?>">
                                                <img src="../backend/assets/uploads/<?php echo $new['avatar']?>" alt="news">
                                            </a>

                                        </div>
                                        <div class="content-news">
                                            <h3 class="title-news"><a href="<?php echo $new_link; ?>"><?php echo $new['title']?></a></h3>
                                            <div class="detail-news">
                                                <?php echo $new['summary']?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>



                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- End content -->
    </div>
</div>