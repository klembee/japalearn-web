<template>
    <div class="latest-activty">
        <h3 class="mb-3">Your latest activities</h3>
        <table class="table" v-if="latestActivity.length > 0">
            <tbody>
                <tr v-for="activity in latestActivity">
                    <td>{{activity.display_text.replace("#", activity.nb_items)}}</td>
                    <td>{{formattedDate(activity.created_at)}}</td>
                </tr>
            </tbody>
        </table>
        <div v-else>
            <md-empty-state
                md-icon="assignment"
                md-label="Latest activity"
                md-description="When you learn new things or review your items, they will appear in your latest activities.">
            </md-empty-state>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LatestActivityWidget",
        props: {
            latestActivityApi: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                latestActivity: []
            }
        },
        methods: {
            fetchActivity(){
                let self = this;
                axios.get(this.latestActivityApi)
                    .then(function(response){
                        console.log(response);
                        if(response.data.success){

                            self.latestActivity = response.data.activity;
                        }else{
                            toastr.error("Error while retrieving latest activity.")
                        }
                    })
                    .catch(function(error){
                        toastr.error("Error while retrieving latest activity.")
                    })
            },
            formattedDate(dateString){
                let date = moment(dateString);

                return date.format('YYYY-MM-DD hh:mm')
            }
        },
        mounted() {
            this.fetchActivity()
        }
    }
</script>

<style scoped>
    .latest-activty{
        padding-top:15px;
    }
</style>
