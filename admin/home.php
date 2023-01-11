<?php
if (function_exists('getUser')) {
    if (getUser($_SESSION['adUser']['id'], 2)) {
        ?>
        <div class="bloco home" style="display:block">
            <?php
            if (!empty($_SESSION['return'])) {
                echo $_SESSION['return'];
                unset($_SESSION['return']);
            }
            ?>
            <div class="titulo">Estatísticas do site:</div>
            <script type="text/javascript" src="https://www.google.com/jsapi"></script>
            <script type="text/javascript">
                google.load("visualization", "1", {packages: ["corechart"]});
                google.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Year');
                    data.addColumn('number', 'Visitas');
                    data.addColumn('number', 'Visitantes');
                    data.addColumn('number', 'Pag. Visitadas');
                    data.addRows([
        <?php
        for ($i = 3; $i >= 0; $i--) {
            $date = ($i != 0 ? date('m/Y', strtotime(-$i . 'months')) : date('m/Y'));
            $dateArray = explode('/', $date);
            if ($date == date('m/Y'))
                $date = 'Mês atual';
            if ($readViews = read('cuc_views', 'WHERE month=? AND year=?', array($dateArray[0], $dateArray[1]), 'ii')) {
                foreach ($readViews as $views)
                    echo "['" . $date . "', " . $views['views'] . ", " . $views['viewers'] . ", " . $views['page_views'] . "]";
            } else
                echo "['" . $date . "', 0, 0, 0]";
            if ($i != 0)
                echo ', ';
        }
        ?>
                    ]);

                    var options = {
                        width: 554, height: 200,
                        title: 'Visitas em seu site:',
                        hAxis: {
                            title: 'relátorio dos últimos 4 meses', titleTextStyle: {color: 'red'}},
                        pointSize: 8,
                        focusTarget: 'category'
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('chart_divDois'));
                    chart.draw(data, options);
                }
            </script>
            <div id="chart_divDois" style="width:554px; height:200px; float:left; border:3px solid #CCC; margin-bottom:15px;"></div>
            <?php
            $qntReg = count(read('cuc_users'));
            $qntOnline = count(read('cuc_viewers_online'));
            $qntCats = count(read('cuc_categories'));
            $qntPages = count(read('cuc_posts', "WHERE type='page'"));
            ?>
            <table width="200" border="0" class="tbdados" style="float:right;" cellspacing="0" cellpadding="0">
                <tr class="ses">
                    <td>Usuários cadastrados:</td>
                    <td><?= $qntReg ?></td>
                </tr>
                <tr>
                    <td>Usuários online:</td>
                    <td><?= $qntOnline ?></td>
                </tr>
                <tr class="ses">
                    <td colspan="2">Sessões:</td>
                </tr>
                <tr>
                    <td>Categorias:</td>
                    <td><?= $qntCats ?></td>
                </tr>
                <tr>
                    <td>Páginas:</td>
                    <td><?= $qntPages ?></td>
                </tr>
            </table>
            <?php
            if ($readArts = read('cuc_posts', "WHERE type='post'")) {
                $qntPosts = count($readArts);
                $qntViews = 0;
                foreach ($readArts as $art) {
                    $qntViews += $art['views'];
                }
                $medPosts = $qntViews / $qntPosts;
            } else {
                $qntPosts = 0;
                $qntViews = 0;
                $medPosts = 1;
            }
            ?>
            <script type="text/javascript">
                google.load("visualization", "1", {packages: ["corechart"]});
                google.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Task');
                    data.addColumn('number', 'Visitas totais');
                    data.addRows([
                        ['Artigos', <?= $qntPosts ?>],
                        ['Visitas em artigos', <?= $qntViews ?>],
                        ['Média por artigo', <?= number_format($medPosts, 2) ?>]
                    ]);

                    var options = {
                        title: 'Visitas em seus artigos:'
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                }
            </script>
            <div id="chart_div" style="width:345px; height:141px; float:left; border:3px solid #CCC;"></div>

            <?php
            if (($readPostByDate = read('cuc_posts', "WHERE type='post' ORDER BY date DESC LIMIT 5")) && ($readPostByViews = read('cuc_posts', "WHERE type='post' ORDER BY views DESC LIMIT 5"))) {
                ?>
                <div class="sub" style="margin-top:15px;">Artigos:</div>

                <table width="270" border="0" class="tbdados" style="float:left;" cellspacing="0" cellpadding="0">
                    <tr class="ses">
                        <td>últimas atualizações</td>
                        <td align="center">data</td>
                    </tr>
                    <?php
                    foreach ($readPostByDate as $postByDate) {
                        ?>
                        <tr>
                            <td><a href="<?= BASE . '/artigo/' . $postByDate['url'] ?>" title="ver"><?= resText($postByDate['title'], 25) ?></a></td>
                            <td align="center"><?= $postByDate['date'] ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>

                <table width="270" border="0" class="tbdados" style="float:right;" cellspacing="0" cellpadding="0">
                    <tr class="ses">
                        <td>artigos + vistos</td>
                        <td align="center">visitas</td>
                    </tr>
                    <?php
                    foreach ($readPostByViews as $postByViews) {
                        ?>
                        <tr>
                            <td><a href="<?= BASE . '/artigo/' . $postByDate['url'] ?>" title="ver"><?= $postByViews['title'] ?></a></td>
                            <td align="center"><?= $postByViews['views'] ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div><!-- /bloco home -->
            <?php
        }
    } else {
        echo '<span class="ms al">Você não tem permissão para acessar essa página!</span>';
    }
} else {
    header('Location: index2.php');
}
?>