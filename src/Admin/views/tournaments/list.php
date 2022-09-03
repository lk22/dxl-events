<div class="dxl dxl-events events-container">
    <div class="header">
        <div class="logo">
            <img height="100" src="http://localhost:8888/dxl-v2/wp-content/uploads/2022/03/cropped-cropped-DXL-LOGO-Hjemmeside_192x192.png" alt="">
        </div>
        <h1>Turneringer</h1>
        <div class="actions">
            <a href="#" class="button-primary modal-button" data-bs-toggle="modal" data-bs-target="#createTournamentModal">Opret begivenhed <span class="dashicons dashicons-calendar"></span></a>
        </div>
    </div>

    <div class="content mt-4">
        <div class="row">
            <div class="col-2">
                <div class="d-flex align-items-start">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-lan-tab" data-bs-toggle="pill" data-bs-target="#v-pills-lan" type="button" role="tab" aria-controls="v-pills-lan" aria-selected="true">Lan turneringer</button>
                        <button class="nav-link" id="v-pills-online-tab" data-bs-toggle="pill" data-bs-target="#v-pills-online" type="button" role="tab" aria-controls="v-pills-online" aria-selected="false">Online turneringer</button>
                    </div>
                </div>
            </div>
            <div class="col-10">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-lan" role="tabpanel" aria-labelledby="v-pills-lan-tab" tabindex="0">
                        <?php require_once(dirname(__FILE__) . '/partials/lan-tournaments.php'); ?>
                    </div>
                    <div class="tab-pane fade" id="v-pills-online" role="tabpanel" aria-labelledby="v-pills-online-tab" tabindex="0">
                        <?php require_once(dirname(__FILE__) . '/partials/online-tournaments.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- create tournament modal -->
<div class="modal createTournamentModal modal-lg fade fadeInUp hidden" id="createTournamentModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Opret turnering</h2>
            </div>
            <div class="modal-body">
                <form action="#" class="admin-create-tournament-form">
                    <div class="row mb-4">

                        <div class="form-group tournament-title col-12">
                            <label for="tournament-name" class="w-100">
                                Turnerings titel
                                <input type="text" class="form-control" name="tournament-name" id="tournament-name" required>
                            </label>
                        </div>
                        <div class="form-group tournament-type col-12 mt-2">
                            <h4>Vælg type turnering</h4>
                            <label for="tournament-type">
                                Online turnering
                                <input type="radio" class="form-control" name="tournament-type" id="tournament-type" value="2" required>
                            </label>
                            <label for="tournament-type">
                                LAN Turnering
                                <input type="radio" class="form-control" name="tournament-type" id="tournament-type" value="3" required>
                            </label>
                        </div>
                        <div class="form-group tournament-minimum-participants col-12">
                            <label for="tournament-min-participants" class="w-100">
                                Minimum antal deltagere
                                <input type="number" class="form-control" id="tournament-min-participants" name="tournament-min-participants">
                            </label>
                        </div>
                        <div class="form-group tournament-maximum-participants col-12">
                            <label for="tournament-max-participants" class="w-100">
                                Maximum antal deltagere
                                <input type="number" class="form-control" id="tournament-max-participants" name="tournament-max-participants">
                            </label>
                        </div>
                    </div>
                
                    <h3 class="h-3">Tidsindstillinger</h3>
                    <div class="row">
                        <div class="form-group start-date">
                            <label for="tournament-startdate" class="w-100">
                                Start dato: 
                                <input type="date" class="form-control" name="tournament-startdate" id="tournament-startdate" required>
                            </label>
                        </div>
                        <div class="form-group end-date">
                            <label for="tournament-startdate" class="w-100">
                                Slut dato: 
                                <input type="date" class="form-control" name="tournament-enddate" id="tournament-enddate" required>
                            </label>
                        </div>
                        <div class="form-group start-time">
                            <label for="tournament-starttime" class="w-100">
                                Start tidspunkt: 
                                <input type="time" class="form-control" name="tournament-starttime" id="tournament-starttime" required>
                            </label>
                        </div>
                        <div class="form-group end-time">
                            <label for="tournament-endtime" class="w-100">
                                Start tidspunkt: 
                                <input type="time" class="form-control" name="tournament-endtime" id="tournament-endtime" required>
                            </label>
                        </div>
                    </div>
                
            </form>
            </div>
            <div class="modal-footer">
                <button class="button-primary close-modal" data-bs-dismiss="modal">Luk <span class="dashicons dashicons-no"></span></button>
                <button class="button-primary create-tournament-button">Opret <span class="dashicons dashicons-calendar"></span></button>
            </div>
        </div>
    </div>
</div>

<!-- participant list -->
<div class="modal hidden tournamentParticipantListModal" id="tournamentParticipantListModal" role="dialog">
    <div class="modal-header">
        <h3>Deltager</h3>
    </div>
    <div class="modal-body">
        <div class="text">
            <h2>Indlæser deltager liste <span class="dashicons dashicons-admin-users"></span></h2>
            <p>vent venligst.</p>
        </div>
       
        <table class="participants-list widefat fixed striped">
            <thead>
                <th>Navn</th>
                <th>Gamertag</th>
                <th>E-mail</th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button class="button-primary close-modal">Luk <span class="dashicons dashicons-no"></span></button>
    </div>
</div>
<div class="overlay hidden"></div>