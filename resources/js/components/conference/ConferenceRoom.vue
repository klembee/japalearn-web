<template>
    <div>
        <div class="conference-container">
            <device-configurator
                v-if="meetingSession && setupDone"
                v-show="showSettings"
                :meeting-session="meetingSession"
                @setup-done="startSession"
                class="settings"
            >

            </device-configurator>

            <div class="video-container">
                <md-button class="toggle-settings md-icon-button" @click="showSettings = !showSettings">
                    <md-icon v-if="showSettings">keyboard_arrow_left</md-icon>
                    <md-icon v-else>keyboard_arrow_right</md-icon>
                </md-button>

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

                <div class="chatbox">
                    <div class="messages">

                    </div>
                    <div class="field">
                        <md-field class="m-0 chat-field">
                            <label>Message</label>
                            <md-input v-on:keyup.enter="sendMesssage" v-model="messageToSend"/>
                            <md-button @click="sendMesssage" class="md-icon-button">
                                <md-icon>send</md-icon>
                            </md-button>

                        </md-field>
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
                setupDone: false,
                started: false,
                configuration: {},
                logger: {},
                deviceController: {},
                meetingSession: null,
                showSettings: false,
                messageToSend: ""
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
                this.setupDone = true;
            },
            startSession(){
                if(!this.started) {
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
                    this.started = true;
                }
            },
            stopSession(){
                this.meetingSession.audioVideo.stop();
            },
            sendMesssage(){
                this.messageToSend = "";
            }
        },
        mounted() {
            this.setup();
        }
    }
</script>

<style scoped>
    .local-video-container{
        position: absolute;
        width: 13%;
        right: 0;
        border: 2px solid black;
        z-index:10;
        margin-right: 20px;
    }
    .video{
        position:fixed;
        width:100%;
        max-height:100%;
    }

    #tileArea{
        position: absolute;
        left: 0;
        top: 0;
        height: 100vh;
        width: 100vw;
    }

    #tile-1{
        width:100vw;
    }

    .conference-container{
        display:flex;
    }

    .video-container{
        width:100%;
        height:100vh;
    }

    .chatbox{
        background-color: #3c3c3c;
        width: 25%;
        position: fixed;
        bottom: 1rem;
        left: 1rem;
        height: 50%;
        display: flex;
        flex-direction: column;
        padding: 20px;
        z-index:0;
    }

    .messages{
        flex-grow: 1;
    }

    .settings{
        z-index:1;
    }
</style>
