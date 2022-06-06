<?php

?>

<div class="event lan-participate my-5">
    <div class="container">
        <h3>Tilmelding <?php echo $details->title ?></h3>
        <p class="lead">Der er <?php echo $details->seats_available?> pladser tilbage</p>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-xl-6">
                <form action="#" class="lan-participate-form">
                    <div class="form-floating mb-3">
                        <input type="text" value="<?php echo $member->name ?>" class="form-control" id="floatingInput participant-name" placeholder="name@example.com" disabled>
                        <label for="floatingInput">Medlemsnavn</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" value="<?php echo $member->gamertag ?>" class="form-control" id="floatingInput participant-gamertag" placeholder="Gamertag123" disabled>
                        <label for="floatingInput">gamertag</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" value="<?php echo $member->email ?>" class="form-control" id="floatingInput participant-email" placeholder="name@example.com" disabled>
                        <label for="floatingInput">Email</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" value="<?php echo $member->address; ?>" class="form-control" id="floatingInput participant-address" disabled>
                        <label for="floatingInput">Email</label>
                    </div>

                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" role="switch" id="participant-breakfast" checked>
                        <label class="form-check-label" for="flexSwitchCheckChecked">Brunch (Lørdag, Søndag)</label>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="participant-dinner-saturday" checked>
                        <label class="form-check-label" for="flexSwitchCheckChecked">Aftensmad (Lørdag)</label>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" role="switch" id="participant-dinner-sunday" checked>
                        <label class="form-check-label" for="flexSwitchCheckChecked">Aftensmad (Søndag)</label>
                    </div>

                    <label">Hvem ønsker du at sidde sammen med</label>
                    <select class="form-select member-select mb-4" multiple aria-label="Vælg medlmmer">
                        <?php 
                            foreach($members as $member) {
                                ?>
                                    <option value="<?php echo $member->gamertag ?>"><?php echo $member->gamertag; ?></option>
                                <?php
                            }
                        ?>
                    </select>

                    <div class="form-floating mt-4">
                        <textarea class="form-control" placeholder="Noget vi særligt skal være opmærksom på?" id="floatingTextarea2 participant-message" style="height: 300px"></textarea>
                        <label for="floatingTextarea2">Noget vi særligt skal være opmærksom på?</label>
                    </div>

                    <div class="form-group my-4">
                        <input type="button" class="btn btn-success" value="Tilmeld mig">
                    </div>
                </form>
            </div>
            <div class="col-lg-5 col-xl-5 offset-lg-1 offset-xl-1 bg-dark text-white p-4 rounded rounded-md">
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