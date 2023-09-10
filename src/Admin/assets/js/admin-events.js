jQuery(function($) {

    /**
     * Initializing event module object
     */
    const DxladminEvents = {
        
        /**
         * Initiating admin event events and properties
         */
        init: function() {
            this.dxl = DXLCore;
            this.container = $('.dxl');
            this.deleteTournamentButton = this.container.find('.delete-tournament-button')
            this.attachGameButton = this.container.find('.attachGameButton')
            this.attachEventButton = this.container.find('.attach-event-btn');
            this.publishTournamentButton = this.container.find('.publish-tournament-btn');
            this.createEventButton = this.container.find('.create-event-button')
            this.deleteLanModalButton = this.container.find('.delete-lan-modal-btn')
            this.publishEventButton = this.container.find('.publish-event')
            this.unpublishEventButton = this.container.find('.unpublish-event')
            this.removeGameTypeButton = this.container.find('.remove-game-type')
            this.exportParticipantsButton = this.container.find('.export-participants')
            this.setTeamMaxSizeButton = this.container.find('.set-team-size-btn')
            this.setHeldStatusButton = this.container.find('.isheld-tournament-btn')
            this.updateTournamnentButton = this.container.find('.update-tournament-btn')
            this.createCalendarEventButton = this.container.find('.create-calendar-event-button');
            this.updateCalendarEventButton = this.container.find('.update-calendar-event-button');
            this.eventModals = {
                deleteLanModal: $('deleteLanModal'),
                createLanEventModal: $('#createLanModal'),
                createTournamentModal: $('#createTournamentModal'),
                tournamentDescriptionModal: $('#tournamentDescriptionModal'),
                eventConfigModal: $('.configEventModal'),
                updateEventModal: $('#updateEventModal'),
                updateTournamentModal: $('#updateTournamentModal'),
                deleteTournamentModal: $('.deleteTournamentModal'),
                createGameModal: $('#createGameModal'),
                createGameTypeModal: $('#createGameTypeModal'),
                updateTournamentDetailsModal: $('#updateAdminTournamentModal'),
                updateEventTimeplanModal: $('#createTimeplanModal, #updateTimeplanModal, #confirmPublishTimeplanModal, #deleteTimeplanModal'),
                createCalendarEventModal: $('#createCalendarEventModal'),
                updateCalendarEventModal: $('#updateCalendarEventModal'),
                deleteCalendarEventModal: $('#deleteCalendarEventModal'),
            }
            this.initializeActions();
        },

        /**
         * trigger global event handling events
         */
         initializeActions: function() {
            const self = this;

            $('[data-bs-toggle="tooltip"]').tooltip();

            self.triggerTournamentEvents();
            self.triggerLanEvents();
            self.triggerGameEvents();
            self.triggerCalendarEvents();
        },

        /**
         * Trigger tournament specific events
         */
        triggerTournamentEvents: function() {
            const self = this;

            /**
             * Creating new tournament ressource from form
             */
            self.eventModals.createTournamentModal.find('.create-tournament-button').click((e) => {
                
                const tournamentCreateForm = $('.admin-create-tournament-form');

                self.dxl.request.data = {
                    action: "dxl_admin_tournament_create",
                    dxl_core_nonce: dxl_core_vars.dxl_core_nonce, 
                    event: {
                        title: tournamentCreateForm.find('#tournament-name').val(),
                        type: tournamentCreateForm.find('[name="tournament-type"]:checked').val(),
                        is_team_tournament: tournamentCreateForm.find('[name="is-team-tournament"]:checked').val(),
                        min_participants: tournamentCreateForm.find('#tournament-min-participants').val(),
                        max_participants: tournamentCreateForm.find('#tournament-max-participants').val(),
                        startdate: tournamentCreateForm.find('#tournament-startdate').val(),
                        enddate: tournamentCreateForm.find('#tournament-enddate').val(),
                        starttime: tournamentCreateForm.find('#tournament-starttime').val(),
                        endtime: tournamentCreateForm.find('#tournament-endtime').val()
                    }
                }

                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: self.dxl.request.data,
                    success: (response) => {

                        const json = JSON.parse(response).event

                        if( json.error && json.error.length ) {
                            $.toast({
                                title: "Fejl",
                                text: json.response,
                                icon: "error",
                                position: "bottom-right"
                            });
                        }

                        self.dxl.redirectToAction('events-tournaments', {
                            action: "details",
                            id: json.data.id
                        });
                    }
                })
            })

            /**
             * Updating tournament date and time information
             */
            self.eventModals.updateTournamentDetailsModal.find('.update-tournament-btn').click((e) => {
                e.preventDefault();

                const tournamentID = self.eventModals.updateTournamentDetailsModal.find('.update-tournament-btn').data('tournament');

                self.dxl.request.data = {
                    action: "dxl_admin_tournament_update",
                    dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                    event: {
                        action: "update-tournament-details",
                        id: tournamentID,
                        title: self.eventModals.updateTournamentDetailsModal.find('#title').val(),
                        startdate: self.eventModals.updateTournamentDetailsModal.find('#start-date').val(),
                        enddate: self.eventModals.updateTournamentDetailsModal.find('#end-date').val(),
                        starttime: self.eventModals.updateTournamentDetailsModal.find('#start-time').val(),
                        endtime: self.eventModals.updateTournamentDetailsModal.find('#end-time').val(),
                    }
                }

                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: self.dxl.request.data,
                    success: (response) => {
                        console.log(response);

                        self.dxl.closeModal();

                        $.toast({
                            title: "Success",
                            text: "Turneringen er blevet opdateret",
                            icon: "success",
                            position: "bottom-right"
                        });

                        window.location.href = window.location.href;
                    }, 
                    error: (error) => {
                        console.log(error)
                    }
                })
            })

            /**
             * udpate tournament description
             */
            self.eventModals.tournamentDescriptionModal.find('.update-tournament-description-btn').click((e) => {
                e.preventDefault();
                const action = $('.update-tournament-description-btn').data('action');
                const tournament = $('.update-tournament-description-btn').data('tournament');

                console.log(tinyMCE.activeEditor.getContent());

                self.dxl.request.data = {
                    action: "dxl_admin_tournament_update",
                    dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                    event: {
                        id: tournament,
                        action: "bulk-update-description",
                        description: tinyMCE.activeEditor.getContent()
                    },
                }

                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: self.dxl.request.data,
                    success: (response) => {
                        const json = JSON.parse(response).event;
                        if( json.error && json.error.length ) {
                            $.toast({
                                title: "Fejl",
                                text: json.response,
                                icon: "error",
                                position: "bottom-right"
                            })
                        }
                        $('.description-label').addClass('hidden');
                        $('.right-details').find('.tournament-description').html("").html(tinyMCE.activeEditor.getContent());
                        self.dxl.closeModal();
                        location.reload();
                    }
                });
            });

            self.setTeamMaxSizeButton.click((e) => {
                e.preventDefault()

                const max_team_size = $('#max-team-size').val();

                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: {
                        action: "dxl_admin_tournament_update",
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        event: {
                            id: self.setTeamMaxSizeButton.data('tournament'),
                            action: "set_team_max_size",
                            max_team_size: max_team_size
                        }
                    },
                    success: (response) => {
                        console.log(response)
                    },
                    error: (err) => {
                        console.log(err);
                    }
                })
            });

            /**
             * Set held status on tournament
             */
            self.setHeldStatusButton.click((e) => {
                e.preventDefault();
                const tournament = self.container.find('.isheld-tournament-btn').data('tournament');
                self.dxl.request.data = {
                    action: "dxl_admin_tournament_update",
                    dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                    event: {
                        id: tournament,
                        action: "set_held_status"
                    }
                }

                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: self.dxl.request.data,
                    success: (response) => {
                        if ( response.success ) {
                            $.toast({
                                title: 'Succes',
                                text: response.data.message,
                                icon: "success",
                                position: "bottom-right"
                            });
                            $('.is-held-status').html('Turneringen er afhold').show();
                        } else {
                            $.toast({
                                title: 'Fejl',
                                text: response.data.message,
                                icon: "error",
                                position: "bottom-right"
                            });
                        }
                    },
                    error: (err) => {
                        console.log(err);
                    }
                });
            });
            
            // delete tournament action
            self.container.find('table.tournaments-list tbody tr').each((i, el) => {
                $(el).find('.delete-tournament-btn').click((e) => {
                    e.preventDefault();

                    const tournament = $(el).find('.delete-tournament-btn').data('tournament');
                    self.dxl.request.data.dxl_core_nonce = dxl_core_vars.dxl_core_nonce;
                    
                    self.dxl.request.data = {
                        action: "dxl_admin_tournament_delete",
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        event: {
                            tournament: tournament
                        }
                    }
    
                    $.ajax({
                        method: "POST", 
                        url: self.dxl.request.url,
                        data: self.dxl.request.data,
                        success: (response) => {
                            console.log(response)
                            const json = JSON.parse(response).event;
                            if(json.error) {
                                $.toast({
                                    title: 'Fejl',
                                    text: "Der opstod en fejl i fjernelse af turnering",
                                    icon: "error",
                                    position: "bottom-right"
                                });
                            } else {
                                $.toast({
                                    title: 'Success',
                                    text: "Turnering fjernet",
                                    icon: "success",
                                    position: "bottom-right"
                                });
                            }
                        },
                        error: (error) => {
    
                        },
                        beforeSend: () => {
                            $.toast({
                                title: "Fjerner turnering",
                                icon: "info",
                                position: "bottom-right"
                            })
                        }
                    })
                });
            });

            /**
             * when selecting a game, fetch game modes attached to the chosen game
             */
            self.container.find('#game-field').change((e) => {
                e.preventDefault();

                console.log(e.target.value)

                $.ajax({
                    method: 'GET',
                    url: self.dxl.request.url,
                    data: {
                        action: 'dxl_admin_fetch_game_modes',
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        event: {
                            game: {
                                id: e.target.value
                            }
                        }
                    },
                    success: (response) => {
                        // TODO: render game modes for the specific game in a new select field 
                        $('#game-mode').addClass('hidden').html('')
                        const gameModes = JSON.parse(response).event.data;
                        gameModes.forEach((mode, index) => {
                            $('#game-mode').append(
                                '<option value="' + mode.id + '">' + mode.name + '</option>'
                            ).removeClass('hidden');
                        })
                    
                    }
                })
            });

            /**
             * updating the game settings attached to the tournamen
             */
            self.attachGameButton.click((e) => {
                e.preventDefault();
                const game = $('#game-field').val();
                const gameMode = $('#game-mode').val();
                const tournament = $('.attachGameButton').data('tournament');

                $.ajax({
                    method: "POST", 
                    url: self.dxl.request.url, 
                    data: {
                        action: 'dxl_admin_tournament_update',
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        event:{
                            action: "attach-game",
                            id: tournament,
                            game: {
                                id: game,
                                mode: gameMode
                            }
                        }
                    },
                    beforeSend: () => {
                        $.toast({
                            title: "Opdeterer",
                            test: "Opdaterer turnering vent venligst",
                            icon: "info",
                            position: "bottom-right"
                        })
                    },
                    success: (response) => {
                        console.log(response);
                        location.reload();
                    },
                    error: (error) => {
                        console.log(error)
                    }
                })
            })
            
            // attach tournament to LAN event
            self.attachEventButton.click((e) => {
                e.preventDefault();
                const tournament = $('.attach-event-btn').data('tournament');
                const event = $('#lan-event').val();

                console.log(self.dxl.request.url)

                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: {
                        action: "dxl_admin_tournament_update",
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        event: {
                            action: "attach-lan-event",
                            id: tournament,
                            lan: event
                        }
                    },
                    success: (response) => {
                        console.log(response);

                        const parsed = JSON.parse(response).event;

                        if( parsed.error ) {
                            $.toast({
                                title: "Fejl",
                                text: parsed.response,
                                icon: "error",
                                position: "bottom-right"
                            });
                        } else {
                            $.toast({
                                title: "Success",
                                text: parsed.response,
                                icon: "success",
                                position: "bottom-right"
                            });

                            location.reload();
                        }
                    }
                })
            })

            self.publishTournamentButton.click((e) => {
                const tournament = $('.publish-tournament-btn').data('tournament');
                const is_draft = $('.publish-tournament-btn').data('draft');

                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: {
                        action: "dxl_admin_tournament_update",
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        event: {
                            action: (is_draft === 1) ? "publish-tournament" : "unpublish-tournament",
                            id: tournament,
                            is_draft
                        }
                    },
                    success: (response) => {
                        console.log(response);
                        window.location.reload();
                    },
                    error: (error) => {
                        console.log(error);
                    }
                })
            });
        },

        /**
         * Trigger LAN event specific events
         */
        triggerLanEvents: function() {
            const self = this;

            // creating new lan event
            self.eventModals.createLanEventModal.find('.create-event-button').click((e) => {
                e.preventDefault()
                const eventForm = $('.createEventForm');
                console.log("creating");

                console.log(
                    eventForm.find('textarea#event-description').val(),
                )
                self.dxl.request.data = {
                    action: "dxl_event_create",
                    dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                    event: {
                        title: eventForm.find('#event-title').val(),
                        description: eventForm.find('textarea#event-description').val(),
                        description_extra: eventForm.find('#event-description-extra').val(),
                        location: eventForm.find('#event-location').val(),
                        startdate: eventForm.find('#event-startdate').val(),
                        enddate: eventForm.find('#event-enddate').val(),
                        participation_due: eventForm.find('#event-participation_due').val(),
                        participation_open: eventForm.find('#event-participation-open').val(),
                        seats_available: eventForm.find('#event-seats').val()
                    }
                }

                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: self.dxl.request.data,
                    success: (response) => {
                        console.log(response)

                        const parsed = JSON.parse(response).event;

                        if( parsed.error ) {
                            $.toast({
                                title: "Fejl",
                                text: parsed.response,
                                icon: "error",
                                position: "bottom-right"
                            })
                        } else {
                            $.toast({
                                title: "Success",
                                text: parsed.response,
                                icon: "info",
                                position: "bottom-right"
                            });

                            self.dxl.redirectToAction('events-lan', {
                                action: "list"
                            });
                        }
                    }
                })
            })

            /**
             * configuring
             */
            
            $('.config-event-btn').click((e) => {
                const configurationForm = $('.configEventForm');
                const event = configurationForm.find('input[name="event"]').val()
                

                self.dxl.request.data = {
                    action: "dxl_event_configure",
                    dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                    event: event,
                    config: {
                        breakfast_friday_price: configurationForm.find('#breakfast-friday').val(),
                        breakfast_saturday_price: configurationForm.find('#breakfast-saturday').val(),
                        lunch_saturday_price: configurationForm.find('#lunch-saturday').val(),
                        dinner_saturday_price: configurationForm.find('#dinner-saturday').val(),
                        breakfast_sunday_price: configurationForm.find('#breakfast-sunday').val(),
                        start_at: configurationForm.find('#start-at').val(),
                        end_at: configurationForm.find('#end-at').val(),
                        participation_opening_date: configurationForm.find('#participation-opening-date').val(),
                        latest_participation_date: configurationForm.find('#latest-participation-date').val()
                    }
                }

                console.log(self.dxl.request.data.config);

                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: self.dxl.request.data,
                    success: (response) => {
                        console.log(response);

                        const parsed = JSON.parse(response).event;
                        if( parsed.error === true ) {
                            $.toast({
                                title: "Fejl",
                                text: parsed.response,
                                icon: "error",
                                position: "bottom-right"
                            })
                        } else {
                            $.toast({
                                title: "Success",
                                text: parsed.response,
                                icon: "info",
                                position: "bottom-right"
                            });

                            self.dxl.redirectToAction('events-lan', {
                                action: "details",
                                id: event
                            });
                        }
                    }
                })
            })

            // updating event ressource
            self.eventModals.updateEventModal.find('.update-event-button').click(() => {
                const eventForm = $('.updateEventForm');
                const event = eventForm.find('input[name="event_id"]').val();

                self.dxl.request.data = {
                    action: "dxl_event_update",
                    dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                    event: {
                        id: event,
                        title: eventForm.find('#event-title').val(),
                        description: eventForm.find('#event-description').val(),
                        description_extra: eventForm.find('#event-description-extra').val(),
                        startdate: eventForm.find('#event-startdate').val(),
                        enddate: eventForm.find('#event-enddate').val(),
                        seats_available: eventForm.find('#event-seats').val(),
                        settings: {
                            event_location: eventForm.find('#event-location').val(),
                            breakfast_friday_price: eventForm.find('#breakfast-friday').val(),
                            breakfast_saturday_price: eventForm.find('#breakfast-saturday').val(),
                            lunch_saturday_price: eventForm.find('#lunch-saturday').val(),
                            dinner_saturday_price: eventForm.find('#dinner-saturday').val(),
                            breakfast_sunday_price: eventForm.find('#breakfast-sunday').val(),
                            start_at: eventForm.find('#start-at').val(),
                            end_at: eventForm.find('#end-at').val(),
                            latest_participation_date: eventForm.find('#event-participation_due').val(),
                            participation_opening_date: eventForm.find('#event-participation-open').val(),
                        }
                    }
                }

                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: self.dxl.request.data,
                    success: (response) => {
                        console.log(response);

                        const parsed = JSON.parse(response);

                        if(parsed.event.error) {
                            $.toast({
                                title: "Fejl",
                                text: parsed.event.response,
                                icon: "error",
                                position: "bottom-right" 
                            });
                        } else {
                            $.toast({
                                title: "Success",
                                text: parsed.event.response,
                                icon: "success",
                                position: "bottom-right"
                            })

                            self.dxl.closeModal();
                            self.dxl.redirectToAction('events-lan', {
                                action: "details",
                                id: event
                            })
                        }
                    }
                })
            })

            // deleting LAN event
            $('.delete-lan-modal-btn').on('click', (e) => {
                console.log("deleting event");
                const event = $('.delete-lan-modal-btn').data('event');

                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: {
                        action: "dxl_lan_event_delete",
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        event: event
                    },
                    success: (response) => {
                        console.log(response);

                        const parsed = JSON.parse(response);

                        if(parsed.event.error) {
                            $.toast({
                                title: "Fejl",
                                text: parsed.event.response,
                                icon: "error",
                                position: "bottom-right"
                            })
                        } else {
                            $.toast({
                                title: "Success",
                                text: parsed.event.response,
                                icon: "success",
                                position: "bottom-right"
                            })

                            self.dxl.redirectToAction('events-lan', {
                                action: "list"
                            })
                        }
                    }
                })
            });

            // publish event
            self.publishEventButton.click((e) => {
                e.preventDefault();

                const event = $('.publish-event').data('event');
                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: {
                        action: "dxl_event_publish",
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        event: event
                    },
                    success: (response) => {
                        console.log(response)

                        const parsed = JSON.parse(response)

                        if( parsed.event.error ) {
                            $.toast({
                                title: "Fejl",
                                text: parsed.event.response,
                                icon: "error",
                                position: "bottom-right"
                            })
                        } else {
                            $.toast({
                                title: "Success",
                                text: parsed.event.response,
                                icon: "success",
                                position: "bottom-right"
                            })

                            self.dxl.closeModal();
                            self.dxl.redirectToAction('events-lan', {
                                action: "details",
                                id: event
                            })
                        }
                    }
                })
            })

            // unpublish event 
            self.unpublishEventButton.click((e) => {

                const event = $('.unpublish-event').data('event');

                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: {
                        action: "dxl_event_unpublish",
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        event: event
                    },
                    success: (response) => {
                        console.log(response);

                        const parsed = JSON.parse(response).event

                        if( parsed.error ) {
                            $.toast({
                                title: "Fejl",
                                text: parsed.response,
                                icon: "error",
                                position: "bottom-right"
                            })
                        } else {
                            $.toast({
                                title: "Success",
                                text: parsed.response,
                                icon: "success",
                                position: "bottom-right"
                            })

                            self.dxl.redirectToAction("events-lan", {
                                action: "details",
                                id: event
                            })
                        }
                    }
                })
            })

            self.exportParticipantsButton.click((e) => {
                e.preventDefault();

                const event = $('.export-participants').data('event');
                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: {
                        action: "dxl_event_export_participants",
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        event: event
                    },
                    success: (response) => {
                        console.log(response);

                        const exported = JSON.parse(response).event.export;

                        if ( exported ) {
                            const exportLink = document.createElement('a');
                            exportLink.setAttribute('download', exported);
                            exportLink.setAttribute('href', "/" + exported);
                            console.log(exportLink.download); // validate the download attribute support
                            document.body.appendChild(exportLink)
                            exportLink.click();
                        }
                    }, error: (error) => {
                        console.log(error);
                    }
                })

            });

            /**
             * Adding timeplan items
             */
            const addPlanItemButton = self.eventModals.updateEventTimeplanModal.find('.add-plan-item');
            let timeplanItemCount = self.eventModals.updateEventTimeplanModal.find('.timeplan-item').length;
            addPlanItemButton.each((index, button) => {
                $(button).click((e) => {
                    e.preventDefault();
                    timeplanItemCount++;
                    const timeplanday = $(button).data('timeplan-day');

                    const starttime = self.eventModals.updateEventTimeplanModal.find('#timeplan-' + timeplanday + ' .item-wrapper').find('input[name="' + timeplanday + '-timeplan-start-time[]"]').last().val();
                    const event = self.eventModals.updateEventTimeplanModal.find('#timeplan-' + timeplanday + ' .item-wrapper').find('input[name="' + timeplanday + '-timeplan-event[]"]').last().val();

                    if ( starttime && event ) {
                        self.eventModals.updateEventTimeplanModal.find('#timeplan-' + timeplanday + ' .item-wrapper').append(
                            "<div class='form-group row mt-3 timeplan-item' data-plan-item='" + timeplanItemCount + "'>" +
                                "<div class='col-2'>" +
                                    "<label for='event-timeplan-start-time'>Start tid:</label>" +
                                    "<input type='time' name='" + timeplanday + "-timeplan-start-time[]' id='event-timeplan-start-time' class='form-control'>" +
                                "</div>" +
                                "<div class='col-2'>" +
                                    "<label for='event-timeplan-end-time'>Slut tid:</label>" +
                                    "<input type='time' name='" + timeplanday + "-timeplan-end-time[]' id='event-timeplan-end-time' class='form-control'>" +
                                "</div>" +
                                "<div class='col-8'>" +
                                "<label for='" + timeplanday + "-timeplan-description' class='event-timeplan-description'>Hvad skald der ske?</label>" +
                                    "<input type='text' name='" + timeplanday + "-timeplan-event[]'>" +
                                    "<span class='dashicons dashicons-no remove-timeplan-item' data-item='" + timeplanItemCount + "'></span>" +
                                "</div"+
                            "</div>"
                        )
                    } else if ( ! starttime && event ) {
                        // add error focus to last item
                        self.eventModals.updateEventTimeplanModal.find('#timeplan-' + timeplanday + ' .item-wrapper').find('input[name="' + timeplanday + '-timeplan-event[]"]').addClass('was-validated').last().focus();
                    } else if ( starttime && ! event ) {
                        // add error focus to last item
                        self.eventModals.updateEventTimeplanModal.find('#timeplan-' + timeplanday + ' .item-wrapper').find('input[name="' + timeplanday + '-timeplan-event[]"]').addClass('was-validated').last().focus();
                    }
                    
                })
            })

            // removing timeplan items
            self.eventModals.updateEventTimeplanModal.on('click', '.remove-timeplan-item', (e) => {
                e.preventDefault();
                const item = $(e.target).data('item');
                console.log(item)
                self.eventModals.updateEventTimeplanModal.find('[data-plan-item="' + item + '"]').remove();
            })

            
            // updating timeplan
            self.eventModals.updateEventTimeplanModal.find('.timeplan-button').click((e) => {
                console.log("Updating timeplan");
                $(this).prop('disabled', true)
                
                const event = e.target.dataset.event;
                const action = e.target.dataset.action;
                
                console.log({event, action})
                // disabling button
                const timeplanObj = {
                    friday: [],
                    saturday: [],
                    sunday: []
                }
                
                self.eventModals.updateEventTimeplanModal.find('#timeplan-friday .timeplan-item').each((index, item) => {
                    timeplanObj.friday.push({
                        start: $(item).find('input[name="friday-timeplan-start-time[]"]').val(),
                        end: $(item).find('input[name="friday-timeplan-end-time[]"').val(),
                        description: $(item).find('input[name="friday-timeplan-event[]"]').val()
                    })
                })
                
                self.eventModals.updateEventTimeplanModal.find('#timeplan-saturday .timeplan-item').each((index, item) => {
                    timeplanObj.saturday.push({
                        start: $(item).find('input[name="saturday-timeplan-start-time[]"]').val(),
                        end: $(item).find('input[name="saturday-timeplan-end-time[]"]').val(),
                        description: $(item).find('input[name="saturday-timeplan-event[]"]').val()
                    })
                });
                
                self.eventModals.updateEventTimeplanModal.find('#timeplan-sunday .timeplan-item').each((index, item) => {
                    timeplanObj.sunday.push({
                        start: $(item).find('input[name="sunday-timeplan-start-time[]"]').val(),
                        end: $(item).find('input[name="sunday-timeplan-end-time[]"]').val(),
                        description: $(item).find('input[name="sunday-timeplan-event[]"]').val()
                    })
                });
                
                const timeplanData = {
                    action: "dxl_event_create_update_timeplanner",
                    dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                    timeplanAction: action,
                    timeplan: timeplanObj,
                    event: event
                };

                self.updatingTimeplanforEvent(
                    timeplanData, 
                    self.dxl.request.url,
                    );
                })

                /**
                 * Publishing timeplan for LAN event
                 */
                self.eventModals.updateEventTimeplanModal.find('.confirm-publish-timeplan-button').click((e) => {
                    console.log("publishing timeplan");
                    $(this).prop('disabled', true);
        
                    const event = e.target.dataset.event;
                    const action = e.target.dataset.action;
    
                    const timeplanData = {
                        action: "dxl_event_create_update_timeplanner",
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        timeplanAction: action,
                        event: event
                    };
    
                    self.updatingTimeplanforEvent(
                        timeplanData,
                        self.dxl.request.url
                    )
                })
            },
            
            
            /**
             * trigger all event game actions
            */
        triggerGameEvents: function() {
            const self = this;

            // updating game action
            const updateGameForm = self.eventModals.updateTournamentModal.find('.updateGameForm');
            const gameModeRow = updateGameForm.find('.game-mode-row');
            const gameModes = updateGameForm.find('.row');
            let gameModeValue = gameModes.find('label').data('game-mode');
            const addRowButton = $(gameModes).find('.add-game-mode-item');

            addRowButton.click((e) => {
                e.preventDefault();
                gameModeValue++
                $('.game-mode-row').append(
                    "<div class='row' data-game-mode='" + gameModeValue + "' style='margin-bottom: 0.5rem'>" + 
                        "<label for='game-mode-" + gameModeValue + "' data-game-mode='" + gameModeValue + "'>" +
                            "<b>#" + gameModeValue + " </b>" +
                            "<input placeholder='Spilletilstand #" + gameModeValue + "' type='text' name='game-mode-" + gameModeValue + "' id='game-mode-" + gameModeValue + "'>" +
                        "</label>" +
                    "</div>"
                );
            })

            self.eventModals.updateTournamentModal.find('.update-game-button').click((e) => {
                e.preventDefault();

                self.dxl.request.data = {
                    action: "dxl_event_game_update",
                    dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                    game: {
                        id: updateGameForm.find('input[name="game"]').val(),
                        type: updateGameForm.find('#game-type').val(),
                        modes: []
                    }
                }

                let gameModesArr = [];
                gameModeRow.find('.row').each((index, row) => {
                    const modeVal = $(row).data('game-mode');
                    console.log(modeVal);

                    gameModesArr[modeVal] = {
                        name: $(row).find('input[name="game-mode-' + modeVal + '"]').val()
                    }
                    console.log(gameModesArr[modeVal].name)
                })

                self.dxl.request.data.game.modes = [...gameModesArr];

                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: self.dxl.request.data,
                    success: (response) => {
                        console.log(response);

                        const json = JSON.parse( response )
                        if( ! json.error ) {
                            self.dxl.closeModal();
                            self.dxl.redirectToAction('events-games', {
                                action: "details",
                                id: updateGameForm.find('input[name="game"]').val()
                            });
                        }

                    }
                })
            })

            // delete game mode from game
            self.container.find('table.gamemodes-list').find('tr').each((index, row) => {
                $(row).find('.remove-gamemode-btn').click((e) => {
                    const val = $(row).find('.remove-gamemode-btn').data('gamemode');
                    console.log(val);

                    $.ajax({
                        method: "POST",
                        url: self.dxl.request.url,
                        data: {
                            action: "dxl_event_gamemode_delete",
                            dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                            gameMode: val 
                        },
                        success: (response) => {
                            console.log(response);
                            $('tr[data-gamemode="' + val + '"]').fadeOut(250);

                            $.toast({
                                title: "Success",
                                text: "Spilletilstand er fjernet",
                                icon: "success",
                                position: "bottom-right"
                            })
                        },
                        error: (error) => {
                            console.log(error);

                            $.toast({
                                title: "Fejl",
                                text: "Der opstod en fejl, kunne ikke fjerne spilletilstand",
                                icon: "error",
                                position: "bottom-right"
                            })
                        }
                    })
                });
            })

            // remove game resource
            self.eventModals.deleteTournamentModal.find('.remove-game-btn').click((e) => {
                e.preventDefault();

                $.ajax({
                    method: "POST", 
                    url: self.dxl.request.url,
                    data: {
                        action: "dxl_event_game_delete",
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        id: self.eventModals.deleteTournamentModal.find('.remove-game-btn').data('game')
                    },
                    success: (response) => {
                        console.log(response);

                        self.dxl.redirectToAction('events-games', {
                            action: "list"
                        });
                    },
                    error: (error) => {
                        console.log(error);
                    }
                })
            })
        

            /**
             * Creating new Game in backend
             * Leo Knudsen 02/09-2022
             */
            self.eventModals.createGameModal.find('.create-game-btn').click((e) => {
                e.preventDefault();

                const game = $('#game-name').val();
                const gametype = $('#game-type').val();
                // console.log(self.dxl.request.url)

                $.ajax({
                    method: 'POST',
                    url: self.dxl.request.url,
                    data: {
                        action: "dxl_event_game_create",
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        game: game,
                        gametype: gametype
                    },
                    beforeSend: () => {
                        console.log({sending: true});
                    },
                    success: (response) => {
                        console.log(response);
                        const json = JSON.parse(response);
                        if ( json.error ) {
                            $.toast({
                                title: "Error",
                                text: json.error,
                                icon: "error",
                                position: "bottom-right"
                            });
                        } else {
                            $.toast({
                                title: "Success",
                                text: json.error,
                                icon: "success",
                                position: "bottom-right"
                            });
                        }
                    },
                    error: (error) => {
                        console.log(error);
                    }
                })
            })

            // creating game type resource to attach to games
            self.eventModals.createGameTypeModal.find('.create-gametype-btn').click((e) => {
                e.preventDefault();

                const type = self.eventModals.createGameTypeModal.find('#game-type').val();

                $.ajax({
                    method: "POST", 
                    url: self.dxl.request.url,
                    data: {
                        action: "dxl_event_game_type_create",
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        type: type
                    },
                    success: ( response ) => {
                        console.log( response )

                        const parsed = JSON.parse( response ).event;

                        if( parsed.error ) {
                            $.toast({
                                title: "Fejl",
                                text: parsed.response,
                                icon: "error",
                                position: "bottom-right"
                            })
                        } else {
                            $.toast({
                                title: "Success",
                                text: "Spil type " + type + " oprettet",
                                icon: "success",
                                position: "bottom-right"
                            });

                            $('.gametypes-list').find("tbody").append(
                                "<tr data-game-type='" + parsed.id + "'>" +
                                    "<td>" + type + "</td>" +
                                    "<td><button class='button-primary remove-game-type' data-game-type='" + parsed.id + "'>Fjern <span class='dashicons dashicons-trash'></span></button></td>" +
                                "</tr>" 
                            );
                            self.eventModals.createGameTypeModal.modal('hide');
                        }
                    }
                })
            })

            self.removeGameTypeButton.each((index, button) => {
                $(button).click(() => {
                    const type = $(button).data('game-type');
                    console.log(type);

                    $.ajax({
                        method: "POST", 
                        url: self.dxl.request.url,
                        data: {
                            action: "dxl_event_game_type_delete",
                            dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                            type: type
                        },
                        success: (response) => {
                            console.log(response)

                            const parsed = JSON.parse(response).event

                            if( parsed.error ) {
                                $.toast({
                                    title: "Fejl",
                                    text: parsed.response,
                                    icon: "error",
                                    position: "bottom-right"
                                })
                            } else {
                                $.toast({
                                    title: "Success",
                                    text: "Spil type fjernet",
                                    icon: "success",
                                    position: "bottom-right"
                                });

                                $('tr[data-game-type="' + type + '"]').fadeOut(250);
                            }
                        }
                    })
                })
            })
        },

        /**
         * Calendar event actions
         */
        triggerCalendarEvents: function() {
            const self = this;

            self.eventModals.createCalendarEventModal.find('.create-calendar-event-button').click((e) => {
                const calendarEventForm = $('#calendarEventForm');

                // validated event date and deadline
                const eventDate = calendarEventForm.find('#calendar-event-date').val();
                const eventDeadline = calendarEventForm.find('#calendar-event-deadline').val();

                // format date and deadline to timestamp
                const formattedEventDate = new Date(eventDate).getTime();
                const formattedEventDeadline = new Date(eventDeadline).getTime();

                // console.log({formattedEventDate, formattedEventDeadline})
                // debugger;

                if ( formattedEventDeadline < formattedEventDate ) {
                    calendarEventForm.find('#calendar-event-deadline').addClass('is-invalid');
                    calendarEventForm.find('.invalid-deadline-feedback').show();
                    calendarEventForm.find('#calendar-event-deadline').focus();
                    return;
                }

                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: {
                        action: "dxl_calendar_event_create",
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        eventName: calendarEventForm.find('#calendar-event-name').val(),
                        description: calendarEventForm.find('#calendar-event-description').val(),
                        eventDate: calendarEventForm.find('#calendar-event-date').val(),
                        eventDeadline: calendarEventForm.find('#calendar-event-deadline').val(),
                    },
                    success: (response) => {
                        console.log(response);

                        if ( response.success ) {
                            self.dxl.closeModal();
                            self.dxl.redirectToAction('events-calendar');
                        }
                    },
                    error: (error) => console.log(error),
                    beforeSend: () => console.log("Creating calendar event")
                })
            })

            self.eventModals.updateCalendarEventModal.find('.update-calendar-event-button').click((e) => {
                const updateCalendarEventForm = $('#updateCalendarEventForm');

                const eventId = e.target.dataset.event;
                console.log({eventId})

                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: {
                        action: "dxl_calendar_event_update",
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        eventId: eventId,
                        eventName: updateCalendarEventForm.find('#calendar-event-name').val(),
                        description: updateCalendarEventForm.find('#calendar-event-description').val(),
                        eventDate: updateCalendarEventForm.find('#calendar-event-date').val(),
                        eventDeadline: updateCalendarEventForm.find('#calendar-event-deadline').val(),
                    },
                    success: (response) => {
                        console.log(response);

                        if ( response.success ) {
                            $('.event-name').html(updateCalendarEventForm.find('#calendar-event-name').val());
                            $('.event-description').html(updateCalendarEventForm.find('#calendar-event-description').val());
                            $('.event-date-value').html(updateCalendarEventForm.find('#calendar-event-date').val());
                            $('.event-deadline-value').html(updateCalendarEventForm.find('#calendar-event-deadline').val());
                            // close modal
                            self.dxl.closeModal();
                        }
                    },
                    error: (error) => console.log(error),
                    beforeSend: () => console.log("Updating calendar event")
                })
            });

            self.eventModals.deleteCalendarEventModal.find('.delete-calendar-event-button').click((e) => {
                const eventId = e.target.dataset.event;

                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: {
                        action: "dxl_calendar_event_delete",
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        eventId: eventId
                    },
                    success: (response) => {
                        console.log(response);

                        if ( response.success ) {
                            // redirect back to calendar
                            self.dxl.redirectToAction('events-calendar');
                        }
                    },
                    error: (error) => console.log(error),
                    beforeSend: () => console.log("Deleting calendar event")
                })
            });

            self.container.find('.complete-calendar-event-btn').click((e) => {
                const event = e.target.dataset.event;

                $.ajax({
                    method: "POST",
                    url: self.dxl.request.url,
                    data: {
                        action: "dxl_calendar_event_complete",
                        dxl_core_nonce: dxl_core_vars.dxl_core_nonce,
                        eventId: event
                    },
                    success: (response) => {
                        console.log(response);

                        if ( response.success ) {
                            $('.event-name-column').append('<span class="completed-status">Denne opgave er udført</span>');
                            $(e.target).hide();
                        }
                    },
                    error: (error) => {
                        console.log(error);
                        $(e.target).html('Færdiggør opgave');
                        $(e.target).prop('disabled', false);
                    },
                    beforeSend: () => {
                        console.log("Completing calendar event");
                        $(e.target).html('Afslutter opgave <span class="dashicons dashicons-cloud"></span>');
                        $(e.target).prop('disabled', true);
                    }
                })
            });
        },

        /**
         * fetching tournament participants action
         * @param {*} event 
         */
        fetchTournamentParticipants: function(event) {
            const self = this;

            $('.participants-list').find('tbody').addClass('hidden').hide();
            
            $('.modal-body').find('.text').removeClass('hidden');
            
            self.dxl.request.data.action = "dxl_admin_tournament_fetch_participants";
            
            self.dxl.request.data.dxl_core_nonce = dxl_core_vars.dxl_core_nonce;
            
            self.dxl.request.data.event = {
                tournament: event,
                title: ""
            };

            $.ajax({
                method: "GET",
                url: self.dxl.request.url,
                data: self.dxl.request.data,
                success: (response) => { 
                    const data = JSON.parse(response).event;
                    if( data.participants.length > 0 ){
                        let participantRow;
                        data.participants.map((participant, index) => {
                            participantRow += "<tr data-tournament='" + event + "'>";
                            participantRow += "<td>" + participant.name + "</td>";
                            participantRow += "<td>" + participant.gamertag + "</td>";
                            participantRow += "<td>" + participant.email + "</td>";
                            participantRow += "<td></td>";
                            participantRow += "</tr>";
                        });
                        $('.participants-list').find('tbody').html(participantRow).removeClass('hidden').show();
                        $('.modal-body').find('.text').addClass('hidden');
                    }
                }
            })
        },

        /**
         * removing participant from tournament
         * 
         * @param {int$} event 
         * @param {int} participant 
         */
        removeParticipantFromTournament(event, participant)
        {
            console.log(event)

            console.log(participant)

            self.dxl.request.data = {
                action: "dxl_admin_tournament_remove_participants",
                event: {
                    event: event,
                    participant: participant    
                }
            }

            $.ajax({
                method: "POST",
                url: self.dxl.request.url,
                data: self.dxl.request.data,
                success: (response) => {
                    console.log(response);
                }
            });
        },


        updatingTimeplanforEvent: (timeplan, url) => {
            $.ajax({
                method: "POST",
                url: url,
                data: timeplan,
                success: (response) => {
                    console.log(response);

                    if ( timeplan.timeplanAction === "create" ) {
                        // close modal
                        $('#createTimeplanModal').modal('hide', () => {
                            // clear modal
                            $('#createTimeplanModal').find('form').trigger('reset');
                        });
    
                        location.reload();
                    }

                    if ( timeplan.timeplanAction === "delete" ) {
                        $('#deleteTimeplanModal').modal('hide', () => {
                            location.reload();
                        });
                    }

                    if ( timeplan.timeplanAction === "update" ) {
                        $('#updateTimeplanModal').modal('hide', () => {
                            location.reload();
                        })
                    }

                    // reload when uodate action is "publish" or "sendAndPublish"
                    if ( timeplan.timeplanAction === "publish" || timeplan.timeplanAction === "sendAndPublish" ) {
                        $('#confirmPublishTimeplanModal').modal('hide', () => {
                            localtion.reload();
                        });
                    }
                },
                error: (error) => console.log(error),
                beforeSend: () => console.log("Updating timeplan")
            });
        }
    }

    DxladminEvents.init();
})