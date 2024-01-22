<?php if (isset($_GET['code'])) {
    die(highlight_file(__File__, 1));
} ?>

<?php
require('conf2.php');
require('funktsioonid.php');
$sort = "eesnimi";
$otsisona = "";
global $yhendus;
if (isset($_REQUEST["sort"])) {
    $sort = $_REQUEST["sort"];
}
if (isset($_REQUEST["otsisona"])) {
    $otsisona = $_REQUEST["otsisona"];
}

if (isset($_REQUEST["inimene_lisamine"])) {
    //ei luba tühja väli ja tühiku sisestamine
    if (!empty(trim($_REQUEST["eesnimi"])) && !empty(trim($_REQUEST["perenimi"]))) {
        lisaInimene($_REQUEST["eesnimi"], $_REQUEST["perenimi"], $_REQUEST["maakond_id"]);
    }
    header("Location: index.php");
    exit();
}

if (isset($_REQUEST["maakond_lisamine"])) {
    //ei luba tühja väli ja tühiku sisestamine
    if (!empty(trim($_REQUEST["maakond"]))) {
        lisaMaakond($_REQUEST["maakond"]);
    }
    header("Location: index.php");
    exit();
}

//andmete kustutamine tabelist
if (isset($_REQUEST["kustuta"])) {
    $paring = $yhendus->prepare("DELETE FROM inimene WHERE id=?");
    $paring->bind_param("i", $_REQUEST["kustuta"]);
    $paring->execute();
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="et">

<head>
    <meta charset="UTF-8">
    <title>Inimesed ja maakonnad</title>
    <link rel="stylesheet" href="formStyle.css">
</head>

<body>
    <h1>Inimesed ja maakonnad</h1>

    <div id="form1">
        <form action="index.php">
            <input type="text" name="eesnimi" placeholder="eesnimi">
            <input type="text" name="perenimi" placeholder="perenimi">
            <?php echo selectLoend("select id, maakond_nimi from maakond", "maakond_id"); ?>
            <p><input type="submit" value="Lisa inimene" name="inimene_lisamine"></p>
        </form>
    </div>

    <div id="form2">
        <form action="index.php">
            <input type="text" name="maakond" placeholder="maakond">
            <p><input type="submit" value="Lisa maakond" name="maakond_lisamine"></p>
        </form>
    </div>

    <div id="form3">
        <form action="index.php">
            <input type="text" name="otsisona" placeholder="otsi inimest nimega">
            <p><input type="submit" value="Otsi"></p>
        </form>
    </div>


    <table>
        <?php
        if (isset($_REQUEST["muuda"])) {
            $muuda_id = $_REQUEST["muuda"];
            $muuda_inimene = inimeneById($muuda_id);

            if ($muuda_inimene) {
        ?>
                <form action="muuda.php" method="post">
                    <input type="hidden" name="muuda_id" value="<?= $muuda_id ?>">
                    <tr>
                        <th>Eesnimi</a></th>
                        <th>Perenimi</a></th>
                        <th>Maakond</a></th>
                        <th>Uuenda</a></th>
                        <th>Loobu</a></th>
                    </tr>
                    <tr>
                        <td><input type="text" name="eesnimi" value="<?= $muuda_inimene->eesnimi ?>" placeholder="eesnimi"></td>
                        <td><input type="text" name="perenimi" value="<?= $muuda_inimene->perekonnanimi ?>" placeholder="perenimi"></td>
                        <td><?php echo selectLoend("select id, maakond_nimi from maakond", "maakond_id", $muuda_inimene->maakond_id); ?></td>
                        <td>
                            <input type="submit" value="Uuenda inimest" name="inimene_uuendamine">
                        </td>
                        <td>
                            <a href="index.php">
                                <button type="button">Loobu</button>
                            </a>
                        </td>
                    </tr>

                </form>
            <?php
            }
        } else { ?>
            <tr>
                <th>Id</th>
                <th><a href="index.php?sort=eesnimi">Eesnimi</a></th>
                <th><a href="index.php?sort=perekonnanimi">Perenimi</a></th>
                <th><a href="index.php?sort=maakond_nimi">Maakond</a></th>
                <th>Kustuta</th>
                <th>Muuda</th>
            </tr>
            <?php
            $inimesed = inimesteKuvamine($sort, $otsisona);
            foreach ($inimesed as $inimene) : ?>
                <tr>

                    <td><?= $inimene->id ?></td>
                    <td><?= $inimene->eesnimi ?></td>
                    <td><?= $inimene->perekonnanimi ?></td>
                    <td><?= $inimene->maakond_nimi ?></td>
                    <td><?= "<a href='?kustuta=$inimene->id'>Kustuta</a>" ?></td>
                    <td><?= "<a href='?muuda=$inimene->id'>Muuda</a>" ?></td>

                </tr>
            <?php endforeach; ?>
        <?php } ?>

    </table>

</body>

</html>