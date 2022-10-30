<div class="event lan-participate my-5">
    <div class="container">
        <div class="row">
            <div class="col-10">
                <h3>Tilmelding <?php echo $details->title ?></h3>
                <p class="lead">Der er <?php echo $details->seats_available?> pladser tilbage</p>
            </div>
            <div class="col-2">
                <a href="events/?action=details&type=lan&event=<?php echo $details->slug; ?>" class="btn btn-success">Gå tilbage</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-xl-6">
                <form action="#" class="lan-participate-form">
                    <div class="form-hiddens">
                        <input type="hidden" name="event" id="event" value="<?php echo $_GET["event"]; ?>">
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="participant-name" value="<?php echo $member->name ?>" class="form-control" id="floatingInput participant-name" disabled>
                        <label for="floatingInput">Medlemsnavn</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" value="<?php echo $member->gamertag ?>" class="form-control" name="participant-gamertag" id="floatingInput participant-gamertag" placeholder="Gamertag123" disabled>
                        <label for="floatingInput">gamertag</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" value="<?php echo $member->email ?>" class="form-control" name="participant-email" id="floatingInput participant-email"  placeholder="name@example.com" disabled>
                        <label for="floatingInput">Email</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" value="<?php echo $member->address; ?>" class="form-control" name="participant-address" id="floatingInput participant-address" disabled>
                        <label for="floatingInput">Email</label>
                    </div>

                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" role="switch" name="participant-breakfast" id="participant-breakfast" checked>
                        <label class="form-check-label" for="flexSwitchCheckChecked">Brunch (Lørdag, Søndag)</label>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="participant-dinner-friday" id="participant-dinner-friday" checked>
                        <label class="form-check-label" for="flexSwitchCheckChecked">Aftensmad (Fredag)</label>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" role="switch" name="participant-dinner-saturday" id="participant-dinner-saturday" checked>
                        <label class="form-check-label" for="flexSwitchCheckChecked">Aftensmad (Lørdagg)</label>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input type="checkbox" role="switch" name="participant-has-companion-field" id="participant-companion" class="form-check-input">
                        <label for="companionSwitchCheckCkeced" class="form-check-label">Har du ledsager med?</label>
                    </div>

                    <div class="form-floating companion-name-field d-none mb-3">
                        <input type="text" class="form-control" name="participant-companion-name" id="floatingInput participant-companion-name" placeholder="udfyld navn på ledsager">
                        <label for="floatingInput">Navn på ledsager</label>
                    </div> 

                    <div class="form-floating companion-phone-field d-none mb-3">
                        <input type="number" class="form-control" name="participant-companion-phone" id="floatingInput participant-companion-phone" placeholder="udfyld telefon nummer på ledsager">
                        <label for="floatingInput">Telefon nummer på ledsager</label>
                    </div> 
                    
                    <div class="form-floating companion-mail-field d-none mb-3">
                        <input type="text" class="form-control" name="participant-companion-mail" id="floatingInput participant-companion-mail" placeholder="udfyld email på ledsager">
                        <label for="floatingInput">Email på ledsager</label>
                        <small>Vi skal bruge din ledsages kontaktoplysninger (Navn, email eller telefonnummer)</small>
                    </div> 

                    <label>Hvem ønsker du at sidde sammen med</label>
                    <select class="form-select member-select mb-4" id="participant-member-select" multiple aria-label="Vælg medlmmer">
                        <?php 
                            foreach($members as $member) {
                                ?>
                                    <option value="<?php echo $member->gamertag ?>"><?php echo $member->gamertag; ?></option>
                                <?php
                            }
                        ?>
                    </select>

                    <div class="form-floating mt-4">
                        <textarea class="form-control" placeholder="Noget vi særligt skal være opmærksom på?" name="participant-message"  id="floatingTextarea2 participant-message" style="height: 300px"></textarea>
                        <label for="floatingTextarea2">Noget vi særligt skal være opmærksom på?</label>
                    </div>

                    <div class="form-group my-4">
                        <input type="submit" class="btn btn-success participate-btn" value="Tilmeld mig">
                    </div>
                </form>
                <div class="participate-error-container alert alert-danger" style="display:none">
                    
                </div>
            </div>
            <div class="col-lg-5 col-xl-5 offset-lg-1 offset-xl-1 p-4 rounded rounded-md">
                <h2 class="border-bottom border-white pb-2">Yderligere info</h2>
                <p class="lead">Vær opmærksom på følgende</p>
                <ul>
                    <li>Er dine medlemsoplysninger forkerte, bedes du ændre dem på din DXL profil</li>
                </ul>
                <h3 class="border-bottom border-white pb-2">Huskeliste</h3>
                <p><?php echo $details->extra_description; ?></p>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-lg fade fadeInUp" id="lanParticipateTournamentModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tilmelding turneringer</h3>
            </div>
            <div class="modal-body">
                <p>Fedt, du er nu tilmeldt <?php echo $details->title; ?>, vi glæder os til at se dig</p>
                <p>Kunne du tænke dig at være med i nogle af vores LAN turneringer, skal du trykke tilmeld under hver turnering vi viser</p>
                <?php
                    foreach($tournaments as $tournament) {
                        ?>
                            <div class="tournament d-flex justify-content-between my-4">
                                <div class="title">
                                    <h3><?php echo $tournament->title; ?></h3>
                                </div>
                                <div class="participants-count">
                                    <p><?php echo $tournament->participants_count; ?> deltagere</p>
                                </div>
                                <div class="action">
                                    <button
                                        class="btn btn-success participate-tournament-btn"
                                        data-tournament="<?php echo $tournament->id; ?>"
                                        data-member="<?php echo $current_user->ID; ?>"
                                        data-event="<?php echo $_GET["event"]; ?>"
                                    >
                                        Tilmeld
                                    </button>
                                </div>
                            </div>
                        <?php
                    }
                ?>
            </div>
            <div class="modal-footer">
                <button class="close-modal btn btn-success" data-bs-dismiss="modal">Luk</button>
            </div>
        </div>
    </div>
</div>
