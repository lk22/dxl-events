<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="filter-container">
                <h1>Filtrering</h1>
                <div class="filter-group">
                    <input type="checkbox" class="btn-check" name="event-type" id="event-type-lan" value="LAN" autocomplete="off" checked>
                    <label class="btn btn-primary" for="btn-check event-type">LAN</label>

                    <input type="checkbox" class="btn-check" name="event-type" id="btn-check-2 event-type-tournament" value="Turnering" autocomplete="off" checked>
                    <label class="btn btn-primary" for="event-typet">Turnering</label>

                    <input type="checkbox" class="btn-check" name="event-type" id="btn-check-3 event-type-training" autocomplete="off" value="Træning" checked>
                    <label class="btn btn-primary" for="event-type">Kampagne</label>
                </div>
            </div>
        </div>
        <div class="col-12 px-0">
            <div class="events-list">
                <div class="container">
                    <?php require "partials/lan-event-list.php"; ?>
                    <?php require "partials/tournament-event-list.php"; ?>
                    <?php require "partials/training-event-list.php"; ?>
                </div>
            </div>
        </div>
    </div>
</div>