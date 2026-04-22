<div class="content-wrapper">
    <section class="content-header">
        <h1>Pesanan</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?=base_url('order/index')?>">Pesanan</a></li>
            <li class='aktif'>Lihat</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-mytheme">
                    <div class="box-body box-profile">
                        <div class="col-lg-6 col-md-6">
                            <form method="POST" id="paymentFrm">
                                <div class="form-group">
                                    <label for="payment_method">Metode Pembayaran</label> <span class="text-danger">*</span>
                                    <div class="col">
                                        <div class="form-check form-check-inline">
                                          <input <?=set_radio('payment_method', 5, TRUE); ?> class="form-check-input <?=form_error('payment_method') ? 'is-invalid' : ''?>" type="radio" name="payment_method" id="cash_on_delivery" value="5">
                                          <label class="form-check-label" for="cash_on_delivery">Cash On Delivery</label>
                                        </div>
                                        <?php if($pengaturan_umum->paypal_payment_method == 1) { ?>
                                            <div class="form-check form-check-inline">
                                              <input <?=set_radio('payment_method', 10); ?> class="form-check-input <?=form_error('payment_method') ? 'is-invalid' : ''?>" type="radio" name="payment_method" id="paypal" value="10">
                                              <label class="form-check-label" for="paypal">Paypal</label>
                                            </div>
                                        <?php } ?>
                                        <?php if($pengaturan_umum->stripe_payment_method == 1) { ?>
                                            <div class="form-check form-check-inline">
                                              <input class="form-check-input <?=form_error('payment_method') ? 'is-invalid' : ''?>" type="radio" name="payment_method" id="stripe" value="20">
                                              <label class="form-check-label" for="stripe">Stripe</label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php if($pengaturan_umum->stripe_payment_method == 1) { ?>
                                    <div class="form-row" id="stripeCard">
                                        <div class="form-group col-sm-6">
                                            <label>Nomor Kartu</label>
                                            <div id="card_number" class="field"></div>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label>Tanggal Expired</label>
                                            <div id="card_expiry" class="field"></div>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label>Kode CVC</label>
                                            <div id="card_cvc" class="field"></div>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <div class="card-errors text-danger" id="paymentResponse"></div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" id="placeOrder">Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="checkout-cart-list">
                                <h3 style="margin-top: 0px">Informasi Pesanan</h3>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Gambar</th>
                                            <th>Produk</th>
                                            <th>Total Pesanan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($item_pesanan as $orderitem) { ?>
                                            <tr>
                                                <td class="p-1">
                                                    <img class="checkoutimage rounded mx-auto d-block" src="<?=app_image_link($orderitem->coverphoto,'uploads/buku_toko/','buku_toko.jpg')?>" alt="<?=$orderitem->nama?>">
                                                </td>
                                                <td><?=$orderitem->nama?> <strong> × <?=$orderitem->jumlah?></strong></td>
                                                <td><?=app_amount_format($orderitem->subtotal)?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="order_total">
                                            <th colspan="2">Ongkos Kirim</th>
                                            <th><strong><?=app_amount_format($pengaturan_umum->delivery_charge) ?></strong></th>
                                        </tr>
                                        <tr class="order_total">
                                            <th colspan="2">Harga Diskon</th>
                                            <th><strong><?=app_amount_format(0) ?></strong></th>
                                        </tr>
                                        <tr class="order_total">
                                            <th colspan="2">Total Pesanan</th>
                                            <th><strong><?=app_amount_format($order->total + $pengaturan_umum->delivery_charge); ?></strong></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php if($pengaturan_umum->stripe_payment_method == 1) { ?>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <script>
        // Set your publishable API key
        var stripe = Stripe('<?=$this->config->item('stripe_key');?>');

        $('#stripeCard').hide();

        $('#cash_on_delivery, #paypal').on('change', function() {
            $('#stripeCard').hide('slow');
        });

        $('#stripe').on('click', function() {
            $('#stripeCard').show('slow');
        });

        // Create an instance of elements
        var elements = stripe.elements();
        var style = {
            base: {
                fontWeight: 400,
                fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
                fontSize: '16px',
                lineHeight: '1.4',
                color: '#555',
                backgroundColor: '#fff',
                '::placeholder': {
                    color: '#888',
                },
            },
            invalid: {
                color: '#eb1c26',
            }
        };
        var cardElement = elements.create('cardNumber', {
            style: style
        });
        cardElement.mount('#card_number');

        var exp = elements.create('cardExpiry', {
            'style': style
        });
        exp.mount('#card_expiry');

        var cvc = elements.create('cardCvc', {
            'style': style
        });
        cvc.mount('#card_cvc');

        // Validate input of the card elements
        var resultContainer = document.getElementById('paymentResponse');
        cardElement.addEventListener('change', function(event) {
            if (event.error) {
                resultContainer.innerHTML = '<p>'+event.error.message+'</p>';
            } else {
                resultContainer.innerHTML = '';
            }
        });

        // Get payment form element
        var form = document.getElementById('paymentFrm');

        // Create a token when the form is submitted.
        form.addEventListener('submit', function(e) {
            var mystripe = $('input[name="payment_method"]:checked').val();
            if(mystripe == 20) {
                e.preventDefault();
                createToken();
            }
        });

        // Create single-use token to charge the user
        function createToken() {
            stripe.createToken(cardElement).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error
                    resultContainer.innerHTML = '<p>'+result.error.message+'</p>';
                } else {
                    // Send the token to your server
                    stripeTokenHandler(result.token);
                }
            });
        }

        // Callback to handle the response from stripe
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('nama', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            
            // Submit the form
            form.submit();
        } 

    </script>
<?php } ?>