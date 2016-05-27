<!doctype HTML>
<html>

<head>
    <title>Teatetahvel</title>
    <meta charset="utf-8">
	
	<link rel="stylesheet" type="text/css" href="style.css">	

</head>

<body>

    <?php foreach (message_list() as $message):?>
        <p style="border: 1px solid blue; background: #EEE;">
            <?= $message; ?>
        </p>
    <?php endforeach; ?>

    <div style="float: right;">
        <form method="post"  action="<?= $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="action" value="logout">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <button id="logout" class="neg_action" type="submit">Logi välja</button>
        </form>
    </div>

    <h1>Teatetahvel</h1>

    <p id="kuva-nupp">
        <button id="kuva" type="button">Vestle</button>
    </p>

    <form id="lisa-vorm" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">

        <input type="hidden" name="action" value="add">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

        <p id="peida-nupp">
            <button class="neg_action" type="button">Peida kirjakast</button>
        </p>

        <table>
            <tr>
                <td>Teade</td>
                <td>
                    <input id="uus_msg" type="text" id="jutt" name="jutt">
                </td>
            </tr>
        </table>

        <p>
            <button class="pos_action" type="submit">Postita</button>
        </p>

    </form>

    <table id="teated" border="1">
        <thead>
            <tr>
				<th>Saatja</th>
                <th>Teade</th>
            </tr>
        </thead>

        <tbody>

        <?php
        // koolon tsükli lõpus tähendab, et tsükkel koosneb HTML osast
        foreach (model_load($page) as $rida): ?>

            <tr>
				<td>
					<?=
						//leiab saatja nime sõnumi id järgi kasutades model_user_poster funktsiooni
						model_user_poster($rida['id'])
					?>
				</td>
                <td>
                    <?=
                        // vältimaks pahatahtlikku XSS sisu, kus kasutaja sisestab õige
                        // info asemel <script> tag'i, peame tekstiväljundis asendama kõik HTML erisümbolid
                        htmlspecialchars($rida['jutt']);
                    ?>
                </td>
                <td>
                    <form method="post" action="<?= $_SERVER['PHP_SELF'];?>">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'];?>">
                        <input type="hidden" name="id" value="<?= $rida['id'];?>">

                        <input type="text" style="width: 5em;" name="jutt" value="<?= $rida['jutt']; ?>">
                        <button class="pos_action" type="submit">Muuda</button>
                    </form>
                </td>
                <td>

                    <form method="post" action="<?= $_SERVER['PHP_SELF'];?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="id" value="<?= $rida['id']; ?>">
                        <button class="neg_action" type="submit">Kustuta teade</button>
                    </form>

                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>
    </table>

    <p>
        <a href="<?= $_SERVER['PHP_SELF']; ?>?page=<?= $page - 1; ?>">
            Eelmine lehekülg
        </a>
        |<?=$page;?>|
        <a href="<?= $_SERVER['PHP_SELF']; ?>?page=<?= $page + 1; ?>">
            Järgmine lehekülg
        </a>
    </p>

    <script src="javascript.js"></script>
</body>

</html>
