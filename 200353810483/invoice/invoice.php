

<?php


require "connection.php";

if (isset($_SESSION["u"])) {
    $oid = $_GET["id"];
     
    $umail = $_SESSION["u"]["email"];

?>

<!DOCTYPE html>

<html>

<head>
    <title> Invoice</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="resources/bestplace.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

</head>

<body class="mt-2" style="background-color:#f7f7ff;">
    <div class="container-fluid">
        <div class="row">

            <div class="col-12">
                <hr />
            </div>

            <div class="col-12 btn-toolbar justify-content-end">
                <button class="btn btn-dark me-2" onclick="printDiv();"><i class="bi bi-printer-fill"></i> print</button>
                <button class="btn btn-danger me-2"><i class="bi bi-file-earmark-pdf-fill"></i> Save as PDF</button>
            </div>


            <div id="GFG">
                <div class="col-12">
                    <hr />
                </div>

                <div class="col-12">
                    <div class="row">
                       

                        <div class="col-6 ">
                            <div class="row">
                                <div class="col-12 text-end text-decoration-underline text-primary">
                                    <h2>bestplace</h2>
                                </div>
                                <div class="col-12 text-end fw-bold">
                                    <span>Wewalwala, ku.bopitiya</span><br />
                                    <span>+94765536428</span><br />
                                    <span>sanodyaj@gmail.com</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <hr class="border border-1 border-primary" />
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <div class="col-6">
                            <h5>INVOICE TO:</h5>
                            <?php
                            $addressrs = database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $umail . "'");
                            $ar = $addressrs->fetch_assoc();
                            echo $umail;
                            ?>
                            <h2><?php echo $_SESSION["u"]["fname"] . "" . $_SESSION["u"]["lname"]; ?></h2>
                            <span class="fw-bold"><?php echo $ar["line1"] . "," . $ar["line2"]; ?></span>
                            <br />
                            <span class="fw-bold text-decoration-underline text-primary"><?php echo $umail; ?></span>
                        </div>

                        <?php


                        $invoicers = Database::search("SELECT * FROM `invoice` WHERE `order_id`='" . $oid . "'");
                        $irr = $invoicers->num_rows;

                        $ir = $invoicers->fetch_assoc();
                        ?>
                        <div class="col-6 text-end mt-4">
                            <h1 class="text-primary">INVOICE <?php echo $ir["id"]; ?></h1>
                            <span class="fw-bold">Date And Time of Invoice :</span>&nbsp;
                            <span class="fw-bold"><?php echo $ir["date"]; ?></span>&nbsp;
                        </div>




                    </div>
                </div>

                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr class="border border-1 border-white">
                                <th>#</th>
                                <th>Order Id & Product</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end"> Quantity</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $invoices = Database::search("SELECT * FROM `invoice` WHERE `order_id`='" . $oid . "'");
                            $ind = $invoices->num_rows;

                            $subtotal = "0";
                            for ($i = 0; $i < $ind; $i++) {
                                $irs = $invoices->fetch_assoc();
                                $pid = $irs["product_id"];

                                $subtotal = $subtotal + $irs["total"];
                                $productrs = Database::search("SELECT * FROM `product` WHERE `id`='" . $pid . "'");
                                $pr = $productrs->fetch_assoc();
                            ?>
                                <tr class="border-0" style="height:70px;">
                                    <td class="bg-primary text-white fs-3 border-0"><?php echo  $irs["id"]; ?></td>
                                    <td>
                                        <a href="#" class="fs-6 fw-bold p-2"><?php echo $irs["order_id"]; ?></a>
                                        <br />
                                        <a href="#" class="fs-6 fw-bold p-2"><?php echo $pr["title"]; ?></a>
                                    </td>
                                    <td class="fs-6 text-end pt-3" style="background-color:rgb(199.199,199);"><?php echo $pr["price"]; ?></td>

                                    <td class="fs-6 text-end pt-3"><?php echo $irs["qty"]; ?></td>
                                    <td class="fs-6 text-end pt-3 text-white bg-primary"><?php echo $irs["total"]; ?></td>
                                </tr>
                        </tbody>


                    <?php
                            }

                    ?>

                    <tfoot>
                        <tr>
                            <td colspan="2" class="border-0"></td>
                            <td colspan="2" class="fs-5 text-end">SUBTOTAL</td>
                            <td class="fs-5 text-end">Rs.<?php echo  $subtotal; ?></td>

                        </tr>
                        <tr>
                            <td colspan="2" class="border-0"></td>
                            <td colspan="2" class="fs-5 text-end border-primary">Discount</td>
                            <td class="fs-5 text-end border-primary">Rs.00.00</td>

                        </tr>
                        <tr>
                            <td colspan="2" class="border-0"></td>
                            <td colspan="2" class="fs-4 text-end text-primary border-0">GRAND TOTAL</td>
                            <td class="fs-5 text-end border-0 text-primary">Rs.<?php echo  $subtotal; ?></td>

                        </tr>
                    </tfoot>
                    </table>
                </div>

                <div class="col-4 text-center" style="margin-top:-100px;margin-bottom:50px;">
                    <span class="fs-1">Thank You</span>
                </div>

                <div class="col-12 mt-3 mb-3 border border-start border-end-0 border-top-0 border-bottom-0 border-5 border-primary rounded" style="background-color:#e7f2ff">
                    <div class="row">
                        <div class="col-12 mt-3 mb-3">
                            <label class="form-label fs-5 fw-bold">NOTICE :</label>
                            <label class="form-label fs-5 ">Purchased items can return befor 7 days of delivery.</label>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <hr class="border border-1 border-primary" />
                </div>

                <div class="col-12 mb-3 text-center">
                    <label class="form-label fs-6 text-black-50"> Invoice was created on a computer and is valid without the signature and seal.</label>
                </div>

            </div>
            <?php require "footer.php"; ?>
        </div>
    </div>


    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

</body>

</html>
<?php
}
?>