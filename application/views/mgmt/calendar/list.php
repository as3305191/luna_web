<head>

</head>
<div id="calendar">
  
</div>
<script src="<?= base_url("js/plugin/fullcalendar/-jquery.fullcalendar.min.js") ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(document).on('ready', function () {
        var fullDate = new Date();
        var yyyy = fullDate.getFullYear();
        var MM = (fullDate.getMonth() + 1) >= 10 ? (fullDate.getMonth() + 1) : ("0" + (fullDate.getMonth() + 1));
        var dd = fullDate.getDate() < 10 ? ("0"+fullDate.getDate()) : fullDate.getDate();
        var today = yyyy + "-" + MM + "-" + dd;

        $('#calendar').fullCalendar({
            header: { // 頂部排版
                left: "prev,next today", // 左邊放置上一頁、下一頁和今天
                center: "title", // 中間放置標題
                right: "month,basicWeek,basicDay" // 右邊放置月、周、天
            },
            defaultDate: today,
            userLang    : 'zh-TW',
            americanMode: false,
            editable: true,

        })
    });

</script>