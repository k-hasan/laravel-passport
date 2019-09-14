
<?php


function generateTaskDataHierarchy($resultData) {
    $data=[];
    foreach($resultData as $row){
        $sub_data['id'] = $row->id;
        $sub_data['parent_id'] =  $row->parent_id;
        $sub_data['title'] =  $row->title .' ('.$row->point.')';
        $data[] = $sub_data;

        if(isset($data)){
            foreach($data as $key => &$value) {
                $output[$value["id"]] = &$value;
            }

            foreach($data as $key => &$value) {
                if ($value["parent_id"] && isset($output[$value["parent_id"]])) {
                    $output[$value["parent_id"]]["nodes"][] = &$value;
                }
            }

            foreach($data as $key => &$value) {
                if ($value["parent_id"] && isset($output[$value["parent_id"]])) {
                    unset($data[$key]);
                }
            }

        }

    }

    return $data;
}

function olLiTree($tree )
{
    echo '<ul>';
    foreach ( $tree as $item ) {
        echo "<li> $item[title]";
        if ( isset( $item['nodes'] ) ) {
            olLiTree( $item['nodes'] );
        }
    }
    echo '</li></ul>';
}


?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <table class="table table-dark" width="100%" border="1" style="border-collapse: collapse;">
                <tr>
                    @foreach($data as $count=> $list)
                    <td>
                        {{ $users[$count]}}
                        <?php
                            olLiTree(generateTaskDataHierarchy($list));
                        ?>
                    </td>
                    @endforeach
                </tr>
            </table>
        </div>
    </body>
</html>
