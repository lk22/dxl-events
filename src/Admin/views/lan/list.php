<div class="dxl dxl-events events-container">
    <div class="header">
        <div class="logo">
            <img height="100" src="http://localhost:8888/dxl-v2/wp-content/uploads/2022/03/cropped-cropped-DXL-LOGO-Hjemmeside_192x192.png" alt="">
        </div>
        <h1>LAN Begivenheder</h1>
        <div class="actions">
            <a href="#" class="button-primary modal-button" data-bs-toggle="modal" data-bs-target="#createLanModal">Opret begivenhed <span class="dashicons dashicons-calendar"></span></a>
        </div>
    </div>

    <div class="content mt-4 fadeUp">
        <div class="events-list list">
            <table class="table table-striped widefat">
                <tbody>
                    <?php 
                        foreach( $events as $event ) {
                            ?>
                                <tr>
                                    <td><?php echo $event->title ?></td>
                                    <td>
                                        <?php echo ($event->is_draft) ? "Ikke offentliggjort" : "Offentliggjort" ?>
                                    </td>
                                    <td>
                                        <?php echo $event->tournaments_count ?> Turneringer
                                    </td>
                                    <td>
                                        <?php echo $event->participants_count ?> deltagere
                                    </td>
                                    <td>
                                        Start dato: <span><?php echo date("d-m-Y", $event->start) ?></span>
                                    </td>
                                    <td>
                                        Slut dato: <span><?php echo date("d-m-Y", $event->end) ?></span>
                                    </td>
                                    <td>
                                        <a href="<?php echo generate_dxl_subpage_url(["action" => "details", "id" => $event->id]); ?>" class="button-primary">Se begivenhed</a>
                                    </td>
                                </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
            <div class="row">
                <?php //require dirname(__FILE__) . "/partials/lan-list.php"; ?>
            </div>
        </div>
    </div>
</div>

<?php require dirname(__FILE__) . "/partials/create-lan-modal.php"; ?>