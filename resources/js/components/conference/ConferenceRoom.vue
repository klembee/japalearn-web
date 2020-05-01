<template>
    <div>
        <device-configurator
            v-if="meetingSession"
            :meeting-session="meetingSession">

        </device-configurator>
    </div>
</template>

<script>
    import DeviceConfigurator from "./DeviceConfigurator";
    import {
        ConsoleLogger,
        DefaultDeviceController,
        DefaultMeetingSession,
        LogLevel,
        MeetingSessionConfiguration
    } from "amazon-chime-sdk-js";

    export default {
        name: "ConferenceRoom",
        components: {DeviceConfigurator},
        props: {
            meetingResponse: {
                type: Object,
                required: true
            },
            attendeesResponse: {
                type: Object,
                required: true
            }
        },
        data: function(){
            return {
                configuration: {},
                logger: {},
                deviceController: {},
                meetingSession: null
            }
        },
        methods: {
            setup(){
                this.logger = new ConsoleLogger('logger2', LogLevel.INFO);

                this.deviceController = new DefaultDeviceController(this.logger);
                this.configuration = new MeetingSessionConfiguration(this.meetingResponse, this.attendeesResponse);
                this.meetingSession = new DefaultMeetingSession(
                    this.configuration,
                    this.logger,
                    this.deviceController
                );

            }
        },
        mounted() {

                this.setup()

        }
    }
</script>

<style scoped>

</style>
