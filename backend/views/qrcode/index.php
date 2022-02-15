<?php

/* @var $this \yii\web\View */

$this->title = ''; //'二维码生成';

?>
<style>
    .center-in-center {
        position: absolute;
        top: 48%;
        left: 15%;
        transform: translate(0, -50%);
    }
</style>
<script>
    function generateCode() {
        let qrcode_text = $('#qrcode_text').val();
        $.ajax({
            type: "GET",
            url: "/qrcode/generate",
            data: {
                "text": qrcode_text,
            },
            async: false,
            success: function (data) {
                $('#span_tip').text('').remove();
                $('#qrimage').attr('src', 'data:image/png;base64,' + data.data.qrcode);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                ;
            }
        });
    }
</script>

<div class="scrollable padder">
    <div class="row bg-light m-b">
        <div class="col-md-12">
            <section class="panel panel-info">
                <header class="panel-heading font-bold">
                    <?= $this->title ?>
                </header>
                <div class="panel-body">
                    <div class="col-md-1"></div>
                    <div class="col-md-6">
                        <textarea cols="70" rows="10" class="col-md-12" placeholder="请输入文字" id="qrcode_text"></textarea>
                        <a class="btn btn-success" onclick="generateCode()"
                           style="margin-top: 20px; margin-left:42%;">生成二维码</a>
                    </div>
                    <div class="col-md-4">
                        <div style="color:#bbb;font-size: 16px;border:1px solid rgba(120,130,140,0.20); width:202px; height: 202px;">
                            <img id="qrimage" src="" style="width:202px; height: 202px;">
                            <span id="span_tip" class="center-in-center">此处生成二维码</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

