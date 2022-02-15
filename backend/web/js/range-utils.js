$(document).ready(function () {
    //js 修改daterangepicker值
    let pickerId = 'temp_picker';
    let startDate = '2021-01-01', endDate = '2021-01-02';//初始化默认今天，开始，结束都是今天
    let pickerContainer = pickerId + '-container';
    let tempPicker = jQuery('#' + pickerContainer)
        .find('.kv-drp-dropdown').data('daterangepicker');
    tempPicker.setStartDate(startDate);
    tempPicker.setEndDate(endDate);
    //设置hidden值
    jQuery('#' + pickerContainer).find('.range-value').val(startDate + ' - ' + endDate);

    //echartphp ajax渲染
    if (typeof echarts != 'undefined') {
        var chart_temp = echarts.init(document.getElementById('trend'), 'null');
        if (typeof chart_temp != 'undefined') {
            chart_temp.setOption({
                "title":{"text":"test title","textStyle":{"fontSize":13}},
                "grid":{"left":"10%"},
                "color":["#55A0F8"],
                "xAxis":[{"type":"category","boundaryGap":false,"data":[],"show":true,"axisLabel":{"show":true,"interval":0,"rotate":40}}],
                "yAxis":[{"type":"value","boundaryGap":[0,"100%"],"show":true,"max":1}],
                "series":[{"type":"line","data":[],"showAllSymbol":true,"label":{"normal":{"show":true,"position":"top"}}}]}
            });
        }
    }
});