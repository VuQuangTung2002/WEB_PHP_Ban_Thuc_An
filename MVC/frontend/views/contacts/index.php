<div id="page-contact">
    <div class="container" id="layout-page">
        <div class="row content-contact">

            <?php foreach ($contacts as $contact): ?>
            <div class="col-md-6">
                <div class="contact-map">

                    <p class="text-center">
                        <iframe src="<?php echo $contact['map_url']; ?>" width="100%" height="500" frameborder="0" style="border:0; pointer-events: none;" allowfullscreen></iframe>
                    </p>


                </div>
            </div>
            <div class="col-md-6" id="col-left contactFormWrapper">
                <h3 class="title-contact-form">Viết nhận xét</h3>
                <p>
                    Nếu bạn có thắc mắc gì, có thể gửi yêu cầu cho chúng tôi, và chúng tôi sẽ liên lạc lại với bạn sớm nhất có thể .
                </p>
                <form accept-charset='UTF-8' action="" class='contact-form' method='post'>
                    <input name='form_type' type='hidden' value='contact'>
                    <input name='utf8' type='hidden' value='✓'>




                    <div class="form-group">
                        <label for="contactFormName" class="sr-only">Tên</label>
                        <input required type="text" id="contactFormName" class="form-control input-lg" name="contact[name]" placeholder="Tên của bạn" autocapitalize="words" value="">
                    </div>
                    <div class="form-group">
                        <label for="contactFormEmail" class="sr-only">Email</label>
                        <input required type="email" name="contact[email]" placeholder="Email của bạn" id="contactFormEmail" class="form-control input-lg" autocorrect="off" autocapitalize="off" value="">
                    </div>
                    <div class="form-group">
                        <label for="contactFormMessage" class="sr-only">Nội dung</label>
                        <textarea required rows="6" name="contact[body]" class="form-control" placeholder="Viết bình luận" id="contactFormMessage"></textarea>
                    </div>

                    <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Gửi liên hệ" onclick="alert('Gửi thành công!')"/>


                    <input id='d9dfe8596a624274afc77f87c3568259' name='g-recaptcha-response' type='hidden'><script src='../../www.google.com/recaptcha/api4d7a.js?render=6LdD18MUAAAAAHqKl3Avv8W-tREL6LangePxQLM-'></script><script>grecaptcha.ready(function() {grecaptcha.execute('6LdD18MUAAAAAHqKl3Avv8W-tREL6LangePxQLM-', {action: 'submit'}).then(function(token) {document.getElementById('d9dfe8596a624274afc77f87c3568259').value = token;});});</script></form>

            </div>
            <div class="col-md-12" id="col-right">

                <div class="list-contact-wrapper">
                    <div class="row">
                        <ul class="list-info-contact">
                            <li class="col-lg-4 col-md-4">
                                <div class="address-contact">
                                    Địa chỉ: <?php echo $contact['summary']; ?>
                                </div>
                            </li>

                            <li class="col-lg-4 col-md-4">
                                <div class="email-contact">
                                    <p>
                                        Email: <?php echo $contact['email']; ?>
                                    </p>
                                </div>
                            </li>

                            <li class="col-lg-4 col-md-4">
                                <div class="hotline-contact">
                                    <p>Hotline: <?php echo $contact['hotline']; ?></p>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>




            </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>