<template>
    <table class="table">
        <thead>
        <tr>
            <td>Student</td>
            <td>Date</td>
            <td>Action</td>
        </tr>
        </thead>

        <tbody>
            <tr v-for="lesson in unconfirmedLessons">
                <td>{{lesson.student_info.user.name}}</td>
                <td>{{lesson.date}}</td>
                <td>
                    <md-button @click="confirmLesson(lesson)" class="md-icon-button">
                        <md-icon>done</md-icon>
                    </md-button>
                    <md-button class="md-icon-button">
                        <md-icon>delete</md-icon>
                    </md-button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "LessonsToConfirmTable",
        props: {
            confirmLessonEndpoint: {
                type: String,
                required: true
            },
            deleteLessonEndpoint: {
                type: String,
                required: true
            },
            unconfirmedLessons: {
                type: Array,
                required: true
            }
        },
        methods: {
            confirmLesson(lesson){
                let payload = {
                    lesson_id: lesson.id
                };

                axios.post(this.confirmLessonEndpoint.replace(':appointment_id', lesson.id), payload)
                    .then(function(response){
                        if(response.data.success){
                            window.location.reload()
                        }else{
                            toastr.error('Failed to confirm lesson.')
                        }
                    })
                    .catch(function(error){
                        toastr.error('Failed to confirm lesson.')
                    })
            },
            cancelLesson(lesson){

            }
        }
    }
</script>

<style scoped>

</style>
