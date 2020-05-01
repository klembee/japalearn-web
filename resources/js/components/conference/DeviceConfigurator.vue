<template>
    <div>
        <div class="row">
            <div class="col-md-3 col-12">
                <h2>Select your devices</h2>
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
            </div>
            <div class="col-md-9 col-12">
                <button @click="startSession">Start session</button>
                <button @click="stopSession">Stop session</button>
                <audio id="audioElement"></audio>
                <video id="videoElement"></video>
            </div>
        </div>
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
                selectedAudioInput: "",
                selectedAudioOutput: "",
                selectedVideoInput: ""
            }
        },
        methods: {
            getDevices(){
                let self = this;

                this.meetingSession.audioVideo.listAudioInputDevices()
                    .then(function(audioInputs){
                        self.audioInputDevices = audioInputs;
                    })
                    .catch(function(error){
                        console.log("Error while retrieving audio input devices: " + error);
                    });

                this.meetingSession.audioVideo.listAudioOutputDevices()
                    .then(function(audioOutputs){
                        self.audioOutputDevices = audioOutputs;
                    })
                    .catch(function(error){
                        console.log("Error while retrieving audio output devices: " + error);
                    });

                this.meetingSession.audioVideo.listVideoInputDevices()
                    .then(function(videoInputs){
                        self.videoInputDevices = videoInputs;
                    })
                    .catch(function(error){
                        console.log("Error while retrieving video input devices: " + error);
                    });
            },
            startSession(){
                const audioElement = document.getElementById('audioElement');
                this.meetingSession.audioVideo.bindAudioElement(audioElement);

                const observer = {
                    audioVideoDidStart() {
                        console.log("STARTED !!");
                    }
                };

                this.meetingSession.audioVideo.addObserver(observer);
                this.meetingSession.audioVideo.start();
            },
            stopSession(){
                this.meetingSession.audioVideo.stop();
            },
            audioInputSelected(deviceId){
                this.meetingSession.audioVideo.chooseAudioInputDevice(deviceId)
                    .then(function(result){
                        console.log("Audio input selected")
                    })
                    .catch(function(error){
                        console.log("Failed to select audio input")
                    });
            },
            audioOutputSelected(deviceId){
                this.meetingSession.audioVideo.chooseAudioOutputDevice(deviceId)
                    .then(function(result){
                        console.log("Audio output selected")
                    })
                    .catch(function(error){
                        console.log("Failed to select audio output")
                    });
            },
            videoSelected(deviceId){
                this.meetingSession.audioVideo.chooseVideoInputDevice(deviceId)
                    .then(function(result){
                        console.log("Video source selected")
                    })
                    .catch(function(error){
                        console.log("Failed to select video source")
                    });
            }
        },
        mounted() {
            this.getDevices();
        }
    }
</script>

<style scoped>

</style>
