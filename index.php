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
        <caption>
            Dice
        </caption>
        <th colspan="6">
            Dice faces
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
                    <button type="submit" value="1" name="btn">First throw</button>
                </form>
            </td>
        </tr>
    </table>
    <table>
        <form action="" method="post">
            <tr>
                <?php foreach($results as $key => $value) { ?>
                    <td>
                    <img src="/bones/<?php print $value ?>.jpg" alt="">
                    <input type="checkbox" name="checkedBones[]" value="<?php print $key ?>">
                    <input type="hidden" name="oldResults[]" value="<?php print $value ?>">
                </td>
                <?php } ?>
            </tr>
            <td colspan="6">
                <button type="submit" value="1" name="btnSecond">Second throw</button>
            </td>
        </form>
        <tr>
            <?php foreach($newResults as $key => $value) { ?>
                <td>
                    <img src="/bones/<?php print $value ?>.jpg" alt="">
                </td>
            <?php } ?>
        </tr>
        <tr>
            <td colspan="6">
                <?php print $response ?>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <?php print_r($results) ?>
            </td>
        </tr>
    </table>
</body>
</html>
