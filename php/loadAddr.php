<?php
session_start();
$mysqli = require __DIR__ . "/database.php";
$addrsql = sprintf(
    "SELECT * FROM addresses
            WHERE userID = '%s'",
    $mysqli->real_escape_string($_SESSION['userid'])
);
$addresses = $mysqli->query($addrsql);

if ($addresses) {
    if (mysqli_num_rows($addresses) > 0) {
        while ($row = mysqli_fetch_assoc($addresses)) { ?>
            <div id='addrbox' class='pb-5'>
                <div class='flex justify-between'>
                    <div class='text-xl text-LMtext-2 dark:text-DMtext2'>
                        <p>
                            <?= $row["firstName"] ?>
                            <?= $row["lastName"] ?>
                        </p>
                        <p>
                            <?= $row["company"] ?>
                        </p>
                        <p>
                            <?= $row["address1"] ?>,
                        </p>
                        <?php if ($row['address2']) {
                            ?>
                            <p>
                                <?= $row["address2"] ?>,
                            </p>
                        <?php } ?>
                        <p class='pb-5'>
                            <?= $row["city"] ?>,
                            <?= $row["stateAbbr"] ?>
                            <?= $row["zip"] ?>
                        </p>
                    </div>
                    <button id=<?= $row["id"] ?>
                        class='px-8 text-lg border border-b-4 rounded deleteAddr w-fit h-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Remove</button>
                </div>
                <div class='w-full mx-auto border-t-2 border-LMtext2 dark:border-DMtext2'></div>
            </div>
            <?php
        } ?>
        </div>
        <?php
    } else { ?>
        <p class='text-xl text-LMtext-2 dark:text-DMtext2'>No addresses added.</p>
    <?php } ?>
<?php
}
?>