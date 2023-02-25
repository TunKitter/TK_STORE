<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Tạo mới đơn hàng</title>
        <!-- Bootstrap core CSS -->
        <link href="/vnpay_php/assets/bootstrap.min.css" rel="stylesheet"/>
        <!-- Custom styles for this template -->
        <link href="/vnpay_php/assets/jumbotron-narrow.css" rel="stylesheet">  
        <script src="/vnpay_php/assets/jquery-1.11.3.min.js"></script>
    </head>

    <body>
        <?php require_once("./config.php"); ?>             
        <div class="container">
            <div class="header clearfix">
                <h3 class="text-muted">VNPAY DEMO</h3>
            </div>
            <h3>Tạo mới đơn hàng</h3>
            <div class="table-responsive">
                <form action="/vnpay_php/vnpay_create_payment.php" id="create_form" method="post">       

                    <!-- <div class="form-group">
                        <label for="language">Loại hàng hóa </label>
                        <select name="order_type" id="order_type" class="form-control">
                            <option value="topup">Nạp tiền điện thoại</option>
                            <option value="billpayment">Thanh toán hóa đơn</option>
                            <option value="fashion">Thời trang</option>
                            <option value="other">Khác - Xem thêm tại VNPAY</option>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label for="order_id">Mã hóa đơn</label>
                        <input class="form-control" id="order_id" name="order_id" type="text" value="<?php echo date("YmdHis") ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="amount">Số tiền</label>
                        <input class="form-control" id="amount"
                               name="amount" type="number" value="10000"/>
                    </div>
                    <div class="form-group">
                        <label for="order_desc">Nội dung thanh toán</label>
                        <textarea class="form-control" cols="20" id="order_desc" name="order_desc" rows="2">Noi dung thanh toan</textarea>
                    </div>
                    <div class="form-group">
                    <input name="bank_code" type="hidden" value="NCB"/>
                    </div>
                    <div class="form-group">
                        <input name="language" type="hidden" value="vn"/>
                    </div>
                    <div class="form-group">
                        <label >Thời hạn thanh toán</label>
                        <input class="form-control" id="txtexpire"
                               name="txtexpire" type="text" value="<?php echo $expire; ?>"/>
                    </div>
                    <div class="form-group">
                        <h3>Thông tin hóa đơn (Billing)</h3>
                    </div>
                    <div class="form-group">
                        <label >Họ tên (*)</label>
                        <input class="form-control" id="txt_billing_fullname"
                               name="txt_billing_fullname" type="text" value="NGUYEN VAN XO"/>             
                    </div>
                    <div class="form-group">
                        <label >Email (*)</label>
                        <input class="form-control" id="txt_billing_email"
                               name="txt_billing_email" type="text" value="xonv@vnpay.vn"/>   
                    </div>  
                    <div class="form-group">
                        <label >Số điện thoại (*)</label>
                        <input class="form-control" id="txt_billing_mobile"
                               name="txt_billing_mobile" type="text" value="0934998386"/>   
                    </div>
                    <div class="form-group">
                        <label >Địa chỉ (*)</label>
                        <input class="form-control" id="txt_billing_addr1"
                               name="txt_billing_addr1" type="text" value="22 Lang Ha"/>   
                    </div>
                    <div class="form-group">
                        <label >Mã bưu điện (*)</label>
                        <input class="form-control" id="txt_postalcode"
                               name="txt_postalcode" type="text" value="100000"/> 
                    </div>
                    <div class="form-group">
                        <label >Tỉnh/TP (*)</label>
                        <input class="form-control" id="txt_bill_city"
                               name="txt_bill_city" type="text" value="Hà Nội"/> 
                    </div>
                    <div class="form-group">
                        <label>Bang (Áp dụng cho US,CA)</label>
                        <input class="form-control" id="txt_bill_state"
                               name="txt_bill_state" type="text" value=""/>
                    </div>
                    <div class="form-group">
                        <label >Quốc gia (*)</label>
                        <input class="form-control" id="txt_bill_country"
                               name="txt_bill_country" type="text" value="VN"/>
                    </div>
                    
                    <div class="form-group">
                        <h3>Thông tin gửi Hóa đơn điện tử (Invoice)</h3>
                    </div>
                    <div class="form-group">
                        <label >Tên khách hàng</label>
                        <input class="form-control" id="txt_inv_customer"
                               name="txt_inv_customer" type="text" value="Lê Văn Phổ"/>
                    </div>
                    <div class="form-group">
                        <label >Công ty</label>
                        <input class="form-control" id="txt_inv_company"
                               name="txt_inv_company" type="text" value="Công ty Cổ phần giải pháp Thanh toán Việt Nam"/>
                    </div>
                    <div class="form-group">
                        <label >Địa chỉ</label>
                        <input class="form-control" id="txt_inv_addr1"
                               name="txt_inv_addr1" type="text" value="22 Láng Hạ, Phường Láng Hạ, Quận Đống Đa, TP Hà Nội"/>
                    </div>
                    <div class="form-group">
                        <label>Mã số thuế</label>
                        <input class="form-control" id="txt_inv_taxcode"
                               name="txt_inv_taxcode" type="text" value="0102182292"/>
                    </div>
                    <div class="form-group">
                        <label >Loại hóa đơn</label>
                        <select name="cbo_inv_type" id="cbo_inv_type" class="form-control">
                            <option value="I">Cá Nhân</option>
                            <option value="O">Công ty/Tổ chức</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label >Email</label>
                        <input class="form-control" id="txt_inv_email"
                               name="txt_inv_email" type="text" value="pholv@vnpay.vn"/>
                    </div>
                    <div class="form-group">
                        <label >Điện thoại</label>
                        <input class="form-control" id="txt_inv_mobile"
                               name="txt_inv_mobile" type="text" value="02437764668"/>
                    </div>
                    <button type="submit" name="redirect" id="redirect" class="btn btn-default">Thanh toán Redirect</button>

                </form>
            </div>
            <p>
                &nbsp;
            </p>
            <footer class="footer">
                <p>&copy; VNPAY <?php echo date('Y')?></p>
            </footer>
        </div>  
       
         


    </body>
</html>
