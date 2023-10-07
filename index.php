<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dice</title>
    <link rel="stylesheet" href="css/style.css">
    <?php require_once 'src/main.php'; ?>
</head>
<body>
    <table>
        <th colspan="6">
            Dice
        </th>
        <tr>
            <?php for($i = 1; $i < 7; $i++) { ?>
                <td>
                    <img id="<?php $i ?>" src="/bones/<?php print $i ?>.jpg" alt="">
                </td>
            <?php } ?>
        </tr>
        <tr>
            <td colspan="6">
                <form action="" method="post">
                    <button type="submit" value="1" name="btn">Throw</button>
                </form>
            </td>
        </tr>
        <tr>
            <?php foreach($results as $result) { ?>
                <td>
                    <img id="<?php $i ?>" src="/bones/<?php print $result ?>.jpg" alt="">
                </td>
            <?php } ?>
        </tr>
        <tr>
            <td colspan="6">
                <?php print $response ?>
            </td>
        </tr>
    </table>
</body>
</html>
