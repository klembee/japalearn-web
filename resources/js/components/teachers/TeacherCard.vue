<template>
    <md-card class="col-12 col-md-6 mx-auto">
        <div class="teacherCard">
            <div class="teacher_picture">
                <img :src="'/storage/' + teacher.picture_path"/>
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
    }
</style>
