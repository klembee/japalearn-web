<template>
    <md-card class="col-12 col-md-6 mx-auto">
        <div class="teacherCard">
            <div class="teacher_picture">
                <img v-if="teacher.picture_path" :src="'/storage/' + teacher.picture_path"/>
                <img v-else src="/images/no_profile_image.png"/>
            </div>
            <div>
                <h2>{{teacher.name}}</h2>
                Average rating:
                <star-rating
                    :rating="teacher.information.average_rating"
                ></star-rating>
            </div>

        </div>

        <md-card-actions>
            <md-button :href="scheduleLessonUrl" :disabled="teacher.information.stripe_account_id == null" class="md-raised md-primary">Schedule lesson</md-button>
        </md-card-actions>
    </md-card>
</template>

<script>
    export default {
        name: "TeacherCard",
        props: {
            teacher: {
                type: Object,
                required: true
            },
            scheduleLessonUrl: {
                type: String,
                required:true
            }
        }
    }
</script>

<style scoped>
    .teacherCard{
        display:flex;
        flex-direction: row;
        padding-top:20px;
    }

    .teacher_picture{
        height: 100%;
        width: auto;
        margin-right:20px;
    }
    .teacher_picture img{
        border-radius:20px;
        max-width: 200px;
    }
</style>
