<?php
    require_once 'helpers/Helper.php';
?>

<div class="wapper">

    <div class="wap1">
        <div class="container">
            <div class="row">

                <?php
                foreach ($compo_imgs as $compo_img):
                ?>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 page-item wow fadeInUp item_1" style="visibility: visible; animation-name: fadeInUp;">
                    <div class="banner_home">
                        <div class="banner-img-home">
                            <a href="pages/frontpage.html">
                                <div class="img_banner_home" style="background-image: url(../backend/assets/uploads/<?php echo $compo_img['component_img']?>)">
                                </div>
                            </a>
                        </div>
                        <div class="content_banner_home">
                            <div class="title_banner_home">
                                <a href="pages/frontpage.html">
                                    <h2>
                                        <span><?php echo $compo_img['title_component']?></span>
                                    </h2>
                                </a>
                            </div>
                            <div class="detail_banner_home text-center">
                                <p>	<?php echo $compo_img['title_detail']?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php endforeach; ?>





            </div>
        </div>
    </div>




    <div class="wap-list-product">
        <div class="container">
            <div class="top-line"></div>
            <div class="heading-title">
                <h3>
                    Sản phẩm nổi bật của Tiệm bánh

                </h3>
                <p class="text-center">
                    Nguyên liệu nhập khẩu 100%
                </p>
            </div>
            <div class="row content-product-list products-resize">
<!--                START ITEM-->
                <?php if (!empty($products)): ?>
                <?php
                    foreach ($products AS $product):
                        $product_title = $product['title'];
                        $product_slug = Helper::getSlug($product_title);
                        $product_id = $product['id'];
                        $product_weight = $product['weight'];
                        $product_supplier = $product['supplier'];
                        $product_link = "chi-tiet-san-pham/$product_slug/$product_id";

                    ?>


                <div class="col-md-3 col-sm-6 col-xs-12 wow fadeInUp animation rainbow_0" style="visibility: visible; animation-name: fadeInUp;">
                    <div class="product-item product-resize">
                        <div class="product-img image-resize" >
                       <a href="<?php echo $product_link; ?>" title="<?php echo $product_title; ?>">
                                <img alt=" <?php echo $product_title; ?> " src="../backend/assets/uploads/<?php echo $product['avatar']; ?>" />
                            </a>
                            <a href="<?php echo $product_link; ?>" class="mask-brg"></a>
                            <div class="hover-mask">
                                <div class="inner-mask">
                                    <a class="add-view-cart btn-cart add-cart " data-variant="1007783439" href="them-vao-gio-hang/<?php echo $product['id'];?>" title="Thêm vào giỏ">
                                        <i class="fa fa-bars"></i>
                                        Thêm vào giỏ
                                    </a>
                                    <ul class="add-to-links">
                                        <li><a href="<?php echo $product_link; ?>"  class="mask-view" data-handle="/products/phuc-bon-tu" title="Xem nhanh"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="<?php echo $product_link; ?>" class=""  title="Xem chi tiết"><i class="fa fa-search"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="product-detail">
                            <h3 class="pro-name"><a href="<?php echo $product_link; ?>" title="<?php echo $product_title; ?>"><?php echo $product_title; ?> - <?php echo $product_weight; ?> </a></h3>
                            <p class="pro-vendor">
                                Nhà cung cấp: <span><?php echo $product_supplier; ?></span>
                            </p>
                            <div class="box-price">
                                <p class="pro-price"><?php echo number_format($product['price']); ?></p>
                            </div>
                            <p class="pro-price-del">

                            </p>
                        </div>
                    </div>
                </div>
                <!--END ITEM             -->

                    <?php endforeach; ?>
                <?php else: ?>
                <h2>Không có sản phẩm nào</h2>
                 <?php endif; ?>


            </div>
        </div>
    </div>


    <div class="wap2">

        <div class="heading-title">
            <h3>HÌNH ẢNH TIỆM BÁNH</h3>
        </div>
        <div class="gallery-image">
            <ul class="list-gallery  ">



                <?php
                foreach ($compo_imgs as $compo_img):
                ?>
                <li class="col-lg-3 col-md-3 col-sm-6 col-xs-6 img_1 wow slideInLeft">
                    <a class="fancybox" rel="group"  href="../backend/assets/uploads/<?php echo $compo_img['store_img']?>">
                        <div class="bkg-fancybox" style="background-image:url(../backend/assets/uploads/<?php echo $compo_img['store_img']?>);background-size:cover;cursor: pointer;">
                        </div>
                    </a>
                </li>
                <?php endforeach; ?>




            </ul>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $(".fancybox").fancybox();
            });
        </script>

    </div>


    <div class="wap3">
        <div class="container">
            <div class="row">
                <?php foreach ($introduces as $introduce): ?>
                <div class="col-md-6 wow slideInLeft">
                    <a href="gioi-thieu">
                        <img src="../backend/assets/uploads/<?php echo $introduce['avatar']?>">
                    </a>
                </div>


                <div class="col-md-6 pull-right wow slideInRight">
                    <div class="about">
                        <div class="title-about">
                            <h2>SƠ LƯỢC </h2>
                            <h3>Về chúng tôi</h3>
                        </div>
                        <div class="datail-about">
                            <p><?php echo $introduce['summary']?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


    <div class="wap4">
        <div class="container">


            <div class="newsletter">
                <div class="home-title">
                    <h2>Tin tức mới</h2>
                </div>
                <div class="row">
                    <?php
                    foreach ($news as $new):
                    ?>
                    <div class="col-md-4 wow fadeInUp">
                        <div class="news-item  text-center">
                            <div class="img-news">
                                <a href="">

                                    <img src="../backend/assets/uploads/<?php echo $new['avatar']?>"  alt="<?php echo $new['title']?>">

                                </a>
                            </div>
                            <div class="content-news">
                                <h3 class="title-news"><a href=""><?php echo $new['title']?></a></h3>
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


