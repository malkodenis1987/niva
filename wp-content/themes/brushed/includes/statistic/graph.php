<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.03.15
 * Time: 2:38
 */
?>
<?php var_dump($_POST)?>
<canvas id="graph" height="300" width="600"></canvas>
<script>
    var randomScalingFactor = function(){ return Math.round(Math.random()*5)};
    var goals = [];
    for (var i = 1; i < 76; i++) {
        goals.push(randomScalingFactor());
    }
    var minutes = [];
    for (var i = 1; i < 76; i++) {
        if (i%5 == 0) {
            minutes.push(i);
        } else {
            minutes.push('');
        }
    }
    var lineChartData = {
        labels : minutes,
        datasets : [
            {
                label: "My First dataset",
                fillColor : "rgba(220,220,220,0.2)",
                strokeColor : "rgba(220,220,220,1)",
                pointColor : "rgba(220,220,220,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(220,220,220,1)",
                data : goals
            }
        ]
    }
    window.onload = function(){
        var ctx = document.getElementById("graph").getContext("2d");
        window.myLine = new Chart(ctx).Line(lineChartData, {
            responsive: true
        });
    }
</script>