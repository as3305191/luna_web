<head>

</head>
<div id="calendar">
  
</div>
<script src="<?= base_url("js/plugin/fullcalendar/-jquery.fullcalendar.min.js") ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(document).on('ready', function () {
        $('#calendar').fullCalendar({
            header: { // 頂部排版
                left: "prev,next today", // 左邊放置上一頁、下一頁和今天
                center: "title", // 中間放置標題
                right: "month,basicWeek,basicDay" // 右邊放置月、周、天
            },
            userLang    : 'zh-TW',
            americanMode: false,
            editable: true,

        })
    });

</script>