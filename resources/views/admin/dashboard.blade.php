@extends('admin.layout')
@section('content')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            var area_chart_demo = $("#area-chart-demo");

            area_chart_demo.parent().show();

            var area_chart = Morris.Area({
                element: 'area-chart-demo',
                data: [
                    <?php
                    foreach ($visits as $visit) {
                        print_r(json_encode($visit));
                        echo ',';
                    }
                    ?>
                ],
                xkey: 'date',
                ykeys: ['visit'],
                labels: ['Views'],
                lineColors: ['#303641']
            });
        });
    </script>


    <div class="row">


        <div class="col-md-3">

            <div class="tile-stats tile-primary">
                <div class="icon"><i class="entypo-users"></i></div>
                <div class="num" data-start="0" data-end="{{$registered_user_count}}" data-postfix=""
                     data-duration="1400" data-delay="0">{{$registered_user_count}}
                </div>

                <h3>Registered Users</h3>
            </div>

            <div class="tile-stats tile-green">
                <div class="icon"><i class="entypo-check"></i></div>
                <div class="num" data-start="0" data-end="{{$approved_posts_count}}" data-postfix=""
                     data-duration="1400" data-delay="0">{{$approved_posts_count}}
                </div>

                <h3>Approved Posts</h3>
            </div>

            <div class="tile-stats tile-red">
                <div class="icon"><i class="entypo-cancel"></i></div>
                <div class="num" data-start="0" data-end="{{$disapproved_posts_count}}" data-postfix=""
                     data-duration="1400" data-delay="0">{{$disapproved_posts_count}}
                </div>

                <h3>Approved Posts</h3>
            </div>


        </div>
    </div>

    <br/>

    <div class="row">
        <div class="panel-body">

            <div class="tab-content">

                <div class="tab-pane" id="area-chart">
                    <div id="area-chart-demo" class="morrischart" style="height: 300px"></div>
                </div>

            </div>

        </div>

    </div>
@stop