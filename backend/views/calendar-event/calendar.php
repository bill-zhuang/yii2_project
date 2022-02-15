<?php

use yii\helpers\Url;

/* @var $this \yii\web\View */
backend\assets\FullCalendarAsset::register($this);

$this->title = '日历事项';

?>
<style>
    .fc-event-title {
        white-space: normal !important;
    }
</style>
<script>
    let today = new Date();
    today.setTime(today.getTime());
    let g_year = today.getFullYear();
    let g_month = (today.getMonth() + 1).toString().padStart(2, "0");
    let g_event = []; //{title: 'Meeting', start: '2021-04-13T11:00:00'};
    let g_calendar;
    document.addEventListener('DOMContentLoaded', function () {
        let todayStr = g_year + "-" + g_month + "-" + today.getDate().toString().padStart(2, "0");

        let calendarEl = document.getElementById('calendar');
        g_calendar = new FullCalendar.Calendar(calendarEl, {
            //themeSystem: 'bootstrap',
            headerToolbar: {
                left: 'prevYear,prev,next,nextYear today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            initialDate: todayStr,
            locale: 'zh-cn',
            displayEventEnd: false,
            fixedWeekCount: false, //If true, the calendar will always be 6 weeks tall. If false, the calendar will have either 4, 5, or 6 weeks, depending on the month.
            buttonIcons: false, // show the prev/next text
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectMirror: true,
            /*select: function (arg) {
                var title = prompt('事件标题:');
                if (title) {
                    calendar.addEvent({
                        title: title,
                        start: arg.start,
                        end: arg.end,
                        allDay: arg.allDay
                    })
                }
                calendar.unselect()
            },*/
            eventClick: function (arg) {
                //console.log(arg);
                //arg.event.extendedProp
                //alert('Event: ' + arg.event.title);
                //alert('View: ' + arg.view.type);

                /*if (confirm('确认删除事件?')) {
                    arg.event.remove()
                }*/
            },
            editable: true,
            dayMaxEvents: true, // allow "more" link when too many events
            eventTimeFormat: { // 月tab 时间格式
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            slotLabelFormat: { // 周/日tab 时间格式
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            events: g_event,
        });

        g_calendar.render();
        //calendar.setOption('locale', 'zh-cn');

        //fetch current month data
        fetchMonth(g_year + "-" + g_month);

        //pre/next today method
        $('.fc-prevYear-button').click(function () {
            g_year = g_year - 1;
            fetchMonth(g_year + "-" + g_month);
        });
        $('.fc-nextYear-button').click(function () {
            g_year = g_year + 1;
            fetchMonth(g_year + "-" + g_month);
        });
        $('.fc-prev-button').click(function () {
            g_month = parseInt(g_month);
            g_month = g_month - 1;
            if (g_month <= 0) {
                g_month = 12;
                g_year = g_year - 1;
            }
            g_month = g_month.toString().padStart(2, "0");
            fetchMonth(g_year + "-" + g_month);
        });
        $('.fc-next-button').click(function () {
            g_month = parseInt(g_month);
            g_month = g_month + 1;
            if (g_month > 12) {
                g_month = 1;
                g_year = g_year + 1;
            }
            g_month = g_month.toString().padStart(2, "0");
            fetchMonth(g_year + "-" + g_month);
        });
        $('.fc-today-button').click(function () {
            g_year = today.getFullYear();
            g_month = (today.getMonth() + 1).toString().padStart(2, "0");
            fetchMonth(g_year + "-" + g_month);
        });
    });

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
                g_event = data.data;
                //Remove all events
                g_calendar.removeAllEvents();
                //Getting new event json data
                g_calendar.addEventSource(g_event);
                g_calendar.refetchEvents();
                //calendar.render();
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
                    <!--<div class="form-group ">
                        <a class="btn btn-info fa fa-repeat"
                           href="<?/*= Url::to(['/calendar-event/index']) */?>">列表模式</a>
                    </div>-->
                    <div id='calendar'></div>
                </div>
            </section>
        </div>
    </div>
</div>

