<div id="wrapper-collection">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 pull-right">

                <!-- Begin collection info -->
                <!-- Content-->
                <div class="row main-content">

                    <div class="col-md-12">
                        <div class="toolbar-inner clearfix">
                            <div class="tool-sortby pull-left">
                               <h2>Danh Sách Sản Phẩm</h2>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-12 product-list">
                        <div class="content-product-list products-resize">
                            <div class="product-list-view row  grid  products-grid">


                                <?php
                                require_once 'helpers/Helper.php';
                                foreach ($products AS $product):
                                $slug = Helper::getSlug($product['title']);
                                // url phải ở dạng rewrite
                                $product_link = "chi-tiet-san-pham/$slug/" . $product['id'];
                                ?>

                                <div class="ajax_block_product col-xs-12 col-sm-6 col-md-4 col-lg-4 wow fadeInUp animation rainbow_0">
                                    <div class="product-item product-resize clearfix">

                                        <div class="left-block product-img image-resize">

                                            <a href="<?php echo $product_link; ?>" title="<?php echo $product['title']; ?> - <?php echo $product['weight']; ?>">
                                                <img alt=" <?php echo $product['title']; ?> - <?php echo $product['weight']; ?> " src="../backend/assets/uploads/<?php echo $product['avatar']; ?>" />
                                            </a>
                                            <a href="<?php echo $product_link; ?>" class="mask-brg"></a>
                                            <div class="hover-mask">
                                                <div class="inner-mask">
                                                    <a class="add-view-cart btn-cart add-cart " data-variant="1007783469" href="them-vao-gio-hang/<?php echo $product['id']; ?>" title="Thêm vào giỏ">
                                                        <i class="fa fa-bars"></i>
                                                        Thêm vào giỏ
                                                    </a>	<ul class="add-to-links">
                                                        <li><a href="<?php echo $product_link; ?>"  class="mask-view" data-handle="/products/xa-lach-romaine-dl" title="Xem nhanh"><i class="fa fa-eye"></i></a></li>
                                                        <li><a href="<?php echo $product_link; ?>" class=""  title="Xem chi tiết"><i class="fa fa-search"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="right-block product-detail">
                                            <h3 class="pro-name"><a href="<?php echo $product_link; ?>" title="<?php echo $product['title']; ?> - <?php echo $product['weight']; ?>"><?php echo $product['title']; ?> - <?php echo $product['weight']; ?> </a></h3>
                                            <p class="pro-vendor">
                                                Nhà cung cấp: <span><?php echo  $product['supplier']; ?></span>
                                            </p>

                                            <div class="box-price">
                                                <p class="pro-price"><?php echo number_format($product['price']); ?></p>
                                            </div>
                                            <p class="pro-price-del">

                                            </p>
                                        </div>


                                    </div>
                                </div>
                                <?php endforeach; ?>











                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="" method="post"
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pull-left">
                <!-- Sidebar menu-->

                <div class="news-menu list-group" id="list-group-l">

                    <div class="menu-left-title">
                        <strong>Nhóm danh mục</strong>
                    </div>

                    <ul class="nav navs sidebar menu" id='cssmenu'>
<!--                        Danh muc san pham de loc-->

                        <?php foreach ($categories AS $category):
                            // xử lý đổ lại dữ liệu ra phần lọc theo category để user biết đã tích vào
                            // checkbox nào sau khi filter dựa vào thuộc tính checked của checkbox/radio
                            // với thẻ select opption -> selected
                            $checked = '';
                            // nếu user đã submit form kiểm tra nếu id của category hiện tại nằm trong mảng
                        //$_POST[category] thì chắc chắn category hiện tại đang đc checked
                            if (isset($_POST['category'])) {
                                if (in_array($category['id'], $_POST['category'])) {
                                    $checked = 'checked';
                                }
                            }
                        ?>

                            <li class="item  first">
                                <a>
                                <input type="checkbox" name="category[]" <?php echo $checked; ?>
                                       value="<?php echo $category['id'];?>" />

                                    <span><?php echo $category['name']; ?></span>
                                </a>

                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="sidebar_price list-group">
                    <div class="menu-left-title">
                        <strong>Lọc theo giá</strong>
                    </div>

                    <?php
                        $checked_price1 = '';
                        $checked_price2 = '';
                        $checked_price3 = '';
                        $checked_price4 = '';
                        $checked_price5 = '';
                        //nếu user submit form Filter thì xử lý đổ lại dữ liệu
                    if (isset($_POST['price'])) {
                        if (in_array(1, $_POST['price'])) {
                            $checked_price1 = 'checked';
                        }
                        if (in_array(2, $_POST['price'])) {
                            $checked_price2 = 'checked';
                        }
                        if (in_array(3, $_POST['price'])) {
                            $checked_price3 = 'checked';
                        }
                        if (in_array(4, $_POST['price'])) {
                            $checked_price4 = 'checked';
                        }
                        if (in_array(5, $_POST['price'])) {
                            $checked_price5 = 'checked';
                        }
                    }
                    ?>
                    <ul class="nav navs sidebar menu" id='cssmenu'>

                        <li class="item  first">
                            <a >
                                <input type="checkbox" name="price[]" value="1"
                                <?php echo $checked_price1; ?>> Dưới 10,000
                            </a>
                        </li>
                        <li class="item">
                            <a >
                                <input type="checkbox" name="price[]" value="2"
                                    <?php echo $checked_price2; ?>> Từ 10,000 - 30,000
                            </a>
                        </li>
                        <li class="item">
                            <a >
                                <input type="checkbox" name="price[]" value="3"
                                    <?php echo $checked_price3; ?>> Từ 30,000 - 50,000
                            </a>
                        </li>
                        <li class="item ">
                            <a >
                                <input type="checkbox" name="price[]" value="4"
                                    <?php echo $checked_price4; ?>> Từ 50,000 - 80,000
                            </a>
                        </li>
                        <li class="item  last">
                            <a >
                                <input type="checkbox" name="price[]" value="5"
                                    <?php echo $checked_price5; ?>> Trên 80,000
                            </a>
                        </li>
                    </ul>

                </div>
                <div class="form-group">
                    <input type="submit" name="filter" value="Filter" class="btn btn-primary">
                    <a href="danh-sach-san-pham" class="btn btn-default">Xóa filter</a>
                </div>
            </div>
            </form>

        </div>
        <!-- End collection info -->
        <!-- Begin no products -->


        <!-- End no products -->
    </div>
</div>