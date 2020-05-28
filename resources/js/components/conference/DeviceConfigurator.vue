<template>
    <div class="settings_menu">
        <md-field>
            <label>Audio input device</label>
            <md-select @md-selected="audioInputSelected" v-model="selectedAudioInput">
                <md-option v-for="audioInput in audioInputDevices" :key="audioInput.deviceId" :value="audioInput.deviceId">{{audioInput.label}}</md-option>
            </md-select>
        </md-field>

        <md-field>
            <label>Audio output device</label>
            <md-select @md-selected="audioOutputSelected" v-model="selectedAudioOutput">
                <md-option v-for="audioOutput in audioOutputDevices" :key="audioOutput.deviceId" :value="audioOutput.deviceId">{{audioOutput.label}}</md-option>
            </md-select>
        </md-field>

        <md-field>
            <label>Video device</label>
            <md-select @md-selected="videoSelected" v-model="selectedVideoInput">
                <md-option v-for="videoInput in videoInputDevices" :key="videoInput.deviceId" :value="videoInput.deviceId">{{videoInput.label}}</md-option>
            </md-select>
        </md-field>

        <hr />
        <md-field>
            <label>Video quality</label>
            <md-select @md-selected="videoQualitySelected" v-model="videoQuality">
                <md-option value="360p">360p</md-option>
                <md-option value="540p">540p</md-option>
                <md-option value="720p">720p</md-option>
                <md-option value="1080p">1080p</md-option>
            </md-select>
        </md-field>
    </div>
</template>

<script>
    export default {
        name: "DeviceConfigurator",
        props: {
            meetingSession: {
                type: Object,
                required: true
            },
        },
        data: function(){
            return {
                audioInputDevices: [],
                audioOutputDevices: [],
                videoInputDevices: [],
                audioInputDone: false,
                audioOutputDone: false,
                videoInputDone: false,
                selectedAudioInput: "",
                selectedAudioOutput: "",
                selectedVideoInput: "",
                videoQuality: "720p"
            }
        },
        methods: {
            getDevices(){
                let self = this;

                this.meetingSession.audioVideo.listAudioInputDevices()
                    .then(function(audioInputs){
                        self.audioInputDevices = audioInputs;
                        if(audioInputs.length > 0) {
                            self.selectedAudioInput = audioInputs[0].deviceId;
                        }
                    })
                    .catch(function(error){
                        console.log("Error while retrieving audio input devices: " + error);
                    });

                this.meetingSession.audioVideo.listAudioOutputDevices()
                    .then(function(audioOutputs){
                        self.audioOutputDevices = audioOutputs;
                        if(audioOutputs.length > 0) {
                            self.selectedAudioOutput = audioOutputs[0].deviceId;
                        }
                    })
                    .catch(function(error){
                        console.log("Error while retrieving audio output devices: " + error);
                    });

                this.meetingSession.audioVideo.listVideoInputDevices()
                    .then(function(videoInputs){
                        self.videoInputDevices = videoInputs;

                        if(videoInputs.length > 0) {
                            self.selectedVideoInput = videoInputs[0].deviceId;
                        }
                    })
                    .catch(function(error){
                        console.log("Error while retrieving video input devices: " + error);
                    });
            },
            audioInputSelected(deviceId){
                this.meetingSession.audioVideo.chooseAudioInputDevice(deviceId)
                    .then(function(result){
                        self.audioInputDone = true;
                        self.checkIfDoneSetup();
                        console.log("Audio input selected")
                    })
                    .catch(function(error){
                        console.log("Failed to select audio input")
                    });
            },
            audioOutputSelected(deviceId){
                this.meetingSession.audioVideo.chooseAudioOutputDevice(deviceId)
                    .then(function(result){
                        self.audioOutputDone = true;
                        self.checkIfDoneSetup();
                        console.log("Audio output selected")
                    })
                    .catch(function(error){
                        console.log("Failed to select audio output")
                    });
            },
            videoSelected(deviceId){
                let self = this;
                this.meetingSession.audioVideo.chooseVideoInputDevice(deviceId)
                    .then(function(result){
                        self.videoInputDone = true;
                        self.checkIfDoneSetup();
                        console.log("Video source selected");
                    })
                    .catch(function(error){
                        console.log("Failed to select video source")
                    });
            },
            videoQualitySelected(quality){
                switch (quality) {
                    case '360p':
                        this.meetingSession.audioVideo.chooseVideoInputQuality(640, 360, 15, 600);
                        break;
                    case '540p':
                        this.meetingSession.audioVideo.chooseVideoInputQuality(960, 540, 15, 1400);
                        break;
                    case '720p':
                        this.meetingSession.audioVideo.chooseVideoInputQuality(1280, 720, 15, 1400);
                        break;
                    case '1080p':
                        this.meetingSession.audioVideo.chooseVideoInputQuality(1920, 1080, 15, 1400);
                        break;
                }

                this.videoSelected(this.selectedVideoInput);
            },
            checkIfDoneSetup(){
                if(this.videoInputDone && this.audioInputDone && this.audioOutputDone){
                    this.$emit('setup-done');
                }
            }

        },
        mounted() {
            this.getDevices();
        }
    }
</script>

<style scoped>
    .settings_menu{
        top: 0;
        left: 0;
        height: 100vh;
        width:300px;
        background-color: #313131;
        padding:20px;
    }
</style>
