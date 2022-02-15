<?php

use yii\helpers\Url;
use components\FullCalendarWidget;

/* @var $monthData array */
/* @var $this \yii\web\View */

$this->title = '日历事项';

?>
<style>
    .fc-event-title {
        white-space: normal !important;
    }
</style>

<script>
    function fetchMonth(month) {
        $.ajax({
            type: "GET",
            url: "/calendar-event/calendar-month",
            data: {
                "month": month,
            },
            async: false,
            success: function (data) {
                if (data.code != 0) {
                    alert(data.msg);
                    return;
                }
                //g_event = data.data;
                //Remove all events
                g_full_calendar.removeAllEvents();
                //Getting new event json data
                g_full_calendar.addEventSource(data.data);
                g_full_calendar.refetchEvents();
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
                    <?= FullCalendarWidget::widget([
                        'id' => 'calendar',
                        'pluginOptions' => [
                            'locale' => 'zh-cn',
                            'events' => $monthData,
                        ],
                        'pluginEvents' => [
                            'prevYearClick' => 'function() {
                                cal_year = cal_year - 1; 
                                fetchMonth(cal_year + "-" + cal_month);
                            }',
                            'nextYearClick' => 'function() {
                                cal_year = cal_year + 1; 
                                fetchMonth(cal_year + "-" + cal_month);
                            }',
                            'prevClick' => 'function() {
                                cal_month = parseInt(cal_month);
                                cal_month = cal_month - 1;
                                if (cal_month <= 0) {
                                    cal_month = 12;
                                    cal_year = cal_year - 1;
                                }
                                cal_month = g_month.toString().padStart(2, "0");
                                fetchMonth(cal_year + "-" + cal_month);
                            }',
                            'nextClick' => 'function() {
                                cal_month = parseInt(cal_month);
                                cal_month = cal_month + 1;
                                if (cal_month > 12) {
                                    cal_month = 1;
                                    cal_year = cal_year + 1;
                                }
                                cal_month = cal_month.toString().padStart(2, "0");
                                fetchMonth(cal_year + "-" + cal_month);
                            }',
                            'todayClick' => 'function() {
                                var today = new Date();
                                today.setTime(today.getTime());
                                cal_year = today.getFullYear();
                                cal_month = (today.getMonth() + 1).toString().padStart(2, "0");
                                fetchMonth(cal_year + "-" + cal_month);
                            }',
                        ],
                    ]); ?>
                </div>
            </section>
        </div>
    </div>
</div>

