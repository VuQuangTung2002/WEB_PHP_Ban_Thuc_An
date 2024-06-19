<?php
//views/carts/index.php
//echo "<pre>";
//print_r($_SESSION['cart']);
//echo "</pre>";
//nhúng class Helper trong thư mục helpers/Helper.php
//để sử dụng phương thức tĩnh slug() -> tạo ra link chi tiết
//theo dạng đường dẫn thân thiện
require_once 'helpers/Helper.php';
?>

<div class="timeline-items container">
    <h2>Giỏ hàng của bạn</h2>
    <?php if (isset($_SESSION['cart'])): ?>
        <form action="" method="post">
            <table class="table table-bordered" >
                <tbody>
                <tr >
                    <th width="40%" style="padding-left: 10px;">Tên sản phẩm</th>
                    <th width="12%" style="padding-left: 10px;">Số lượng</th>
                    <th style="padding-left: 10px;">Giá</th>
                    <th style="padding-left: 10px;">Thành tiền</th>
                    <th style="padding-left: 10px;"></th>
                </tr>

                <?php
                //khai báo 1 biến chứa tổng giá trị đơn hàng
                $total_cart = 0;
                foreach($_SESSION['cart'] AS $product_id => $cart):
                    $slug = Helper::getSlug($cart['name']);
                    $url_detail = "chi-tiet-san-pham/$slug/$product_id";
                    ?>
                    <tr>
                        <td style="padding-left: 10px;">
                            <img class="product-avatar img-responsive"
                                 src="../backend/assets/uploads/<?php echo $cart['avatar']?>"
                                 width="80">
                            <div class="content-product" style="padding-top: 10px; font-size: 20px; font-weight: bold;">
                                <a href="<?php echo $url_detail; ?>"
                                   class="content-product-a">
                                    <?php echo $cart['name']; ?>
                                </a>
                            </div>
                        </td>
                        <td>
                            <!--  cần khéo léo đặt name cho input số lượng,
                            để khi xử lý submit form update lại giỏ hàng sẽ đơn giản hơn    -->
                            <input type="number" min="0" name="<?php echo $product_id; ?>"
                                   class="product-amount form-control"
                                   value="<?php echo $cart['quality']?>">
                        </td>
                        <td>
                            <?php echo number_format($cart['price']); ?>
                        </td>
                        <td>
                            <?php
                            //thành tiền
                            $total_item = $cart['price'] * $cart['quality'];
                            echo number_format($total_item);
                            //cộng dồn Thành tiên cho tổng giá trị đơn hàng
                            $total_cart += $total_item;
                            ?>
                        </td>
                        <td>
                            <a class="content-product-a"
                               href="xoa-san-pham/<?php echo $product_id; ?>">
                                Xóa
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5" style="text-align: right">
                        Tổng giá trị đơn hàng:
                        <span class="product-price">
                      <?php
                      echo number_format($total_cart);
                      ?>
                    </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="product-payment" style="padding-left: 10px;">
                        <input type="submit" name="submit" value="Cập nhật lại số lượng" class="btn btn-primary">
                        <a href="thanh-toan" class="btn btn-success">Đến trang thanh toán</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    <?php else: ?>
        <h3>Giỏ hàng trống</h3>
    <?php endif; ?>
</div>