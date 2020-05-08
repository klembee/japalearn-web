<template>
    <div>
        <h2>Please select a plan</h2>
        <div class="all-plan-container">
            <div class="row justify-content-center">
                <div class="col-md-3 plan-container">
                    <div class="content">
                        <div class="plan-header">
                            <h3>Month</h3>
                            <div>
                                <p class="pricing">${{month.amount / 100}} CAD</p>
                            </div>
                        </div>

                        <hr />
                        <p>{{month.metadata.description}}</p>
                        <hr />
                        <p>Recurring charge every month <sup>1</sup></p>
                    </div>

                    <button class="select-plan">Select</button>
                </div>
                <div class="col-md-3 offset-md-1 plan-container">
                    <div class="content">
                        <div class="plan-header">
                            <h3>Three months</h3>
                            <div>
                                <p class="pricing">${{trimonth.amount / 100}} CAD</p>
                            </div>
                        </div>
                        <hr />
                        <p>{{trimonth.metadata.description}}</p>
                        <hr />
                        <p>Recurring charge every month <sup>1</sup></p>
                    </div>


                    <button class="select-plan">Select</button>
                </div>
                <div class="col-md-3 offset-md-1 plan-container">
                    <div class="content">
                        <div class="plan-header">
                            <h3>Annual</h3>
                            <div>
                                <p class="pricing">${{year.amount / 100}} CAD</p>
                            </div>
                        </div>
                        <hr />
                        <p>{{year.metadata.description}}</p>
                        <hr />
                        <p>Recurring charge every month <sup>1</sup></p>
                    </div>

                    <button class="select-plan">Select</button>
                </div>
            </div>
        </div>

        <!-- TODO: !!! -->
        <ol>
            <li>
                <p>WaniKani will charge you at the beginning of a subscription period. A period begins on the date when a subscription is added and ends a month or year after the date, depending on the plan selected. Refer to the generated invoice for more information.</p>
                <p>If you do not wish to have your subscription on recurring charge (Month or Annual) simply cancel the subscription anytime during the subscription period under Billing. The account will remain active until the end of the subscription period. At the end of your subscription you will only have access to the free levels (up to level 3). Don't fret! If you decide to subscribe again you'll be back to where you have left off.</p>
            </li>
        </ol>
    </div>
</template>

<script>
    export default {
        name: "SubscriptionPage",
        props: {
            month: {
                type: Object,
                required: true
            },
            trimonth: {
                type: Object,
                required: true
            },
            year: {
                type: Object,
                required: true
            }
        }
    }
</script>

<style scoped>
    .all-plan-container{
        width:80%;
        margin: 30px auto;
    }

    .plan-container{
        padding:0;
        border-radius: 15px;
        border: 2px solid #e2e2e2;
        background-color: #f9f9f9;;
        height:fit-content;
    }

    .plan-header{
        text-align:center;
    }

    .pricing{
        font-weight:bold;
    }

    .content {
        padding:15px;
    }

    .select-plan:focus{
        outline: none;
    }

    .select-plan{
        background-color: #d6d6ef;
        border: none;
        width: 100%;
        border-bottom-left-radius: 13px;
        border-bottom-right-radius: 13px;
        height:40px;
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    }
</style>
