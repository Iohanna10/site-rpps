<!-- logotipos -->
<footer>
    <!--------------- pegar a url --------------->
    <?php require("config/content-config.php"); ?>
    <!------------------------------------------->

    <?php if($logos !== NULL) { ?>
    <section class="logos">
        <div class="container max-width-container">

            <?php

            foreach (explode(", ", $logos) as $key => $logo) {
                echo '<div class="logo">';
                    echo "<img src=" . base_url("dynamic-page-content/$url/assets/uploads/img/logos/partners/$logo") ." alt='$logo'>";
                echo '</div>';
            }

            ?>
        </div>
    </section>
    <?php } ?>
</footer>