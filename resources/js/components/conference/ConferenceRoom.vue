<template>
    <div>
        <div class="row">
            <device-configurator
                v-if="meetingSession"
                :meeting-session="meetingSession"
                class="col-md-3 col-12">

            </device-configurator>

            <div class="col-md-9 col-12">
                <button @click="startSession">Start session</button>
                <button @click="stopSession">Stop session</button>
                <audio id="audioElement">

                </audio>

                <div class="local-video-container">
                    <video id="localVideo">

                    </video>
                </div>

                <div id="tileArea">
                    <div id="tile-1">
                        <video class="video" id="video-1">

                        </video>
                    </div>
                </div>

            </div>
        </div>
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
                this.logger = new ConsoleLogger('logger2', LogLevel.ERROR);

                this.deviceController = new DefaultDeviceController(this.logger);
                this.configuration = new MeetingSessionConfiguration(this.meetingResponse, this.attendeesResponse);
                this.meetingSession = new DefaultMeetingSession(
                    this.configuration,
                    this.logger,
                    this.deviceController
                );

                let self = this;
                const observer = {
                    videoTileDidUpdate(tileState) {
                        if (!tileState.boundAttendeeId) {
                            return;
                        }

                        var videoElement = null;

                        if(tileState.localTile) {
                            videoElement = document.getElementById('localVideo');
                        }else{
                            videoElement = document.getElementById('video-1');
                        }

                        self.meetingSession.audioVideo.bindVideoElement(tileState.tileId, videoElement);
                    },

                    videoSendHealthDidChange: (bitrateKbps, packetsPerSecond) => {
                        console.log(`Sending bitrate in kilobits per second: ${bitrateKbps} and ${packetsPerSecond}`);
                    },
                    videoSendBandwidthDidChange: (newBandwidthKbps, oldBandwidthKbps) => {
                        console.log(`Sending bandwidth changed from ${oldBandwidthKbps} to ${newBandwidthKbps}`);
                    },
                    videoReceiveBandwidthDidChange: (newBandwidthKbps, oldBandwidthKbps) => {
                        console.log(`Receiving bandwidth changed from ${oldBandwidthKbps} to ${newBandwidthKbps}`);
                    }
                };

                this.meetingSession.audioVideo.addObserver(observer);

            },
            startSession(){
                const audioElement = document.getElementById('audioElement');
                this.meetingSession.audioVideo.bindAudioElement(audioElement);

                let self = this;
                const observer = {
                    audioVideoDidStart() {
                        console.log("STARTED !!");
                        self.meetingSession.audioVideo.startLocalVideoTile();
                    }
                };

                this.meetingSession.audioVideo.addObserver(observer);
                this.meetingSession.audioVideo.start();
            },
            stopSession(){
                this.meetingSession.audioVideo.stop();
            },
        },
        mounted() {
            this.setup()
        }
    }
</script>

<style scoped>
    .local-video-container{
        position: absolute;
        width: 20%;
        right: 0;
        border: 2px solid black;
    }
    .video{
        width:100%;
    }
</style>
